<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Exception\BotException;
use Cake\I18n\Time;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 * @property \App\Model\Table\OrderDetailsTable $OrderDetails
 * @property \App\Model\Table\CartTable $Cart
 * @property \App\Model\Table\AmazonAccountsTable $AmazonAccounts
 * @property \App\Model\Table\AddressesTable $Addresses
 * @property \App\Model\Table\DeliveryTypesTable $DeliveryTypes
 * @property \App\Model\Table\OrderSummariesTable $OrderSummaries
 * @property \App\Model\Table\PointHistoryTable $PointHistory
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @property \App\Controller\Component\AmazonComponent $Amazon
 */
class OrdersController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('OrderDetails');
        $this->loadModel('Cart');
        $this->loadModel('AmazonAccounts');

        $this->loadComponent('Amazon');

        $this->Auth->allow(['test']);
    }

    public function checkout()
    {
        $this->request->allowMethod(['get', 'post']);

        $this->loadModel('Addresses');
        $this->loadModel('DeliveryTypes');
        $this->loadModel('OrderSummaries');

        $Cart = $this->Cart->find()
            ->where(['Cart.user_id' => $this->Auth->user('id')])
            ->contain(['Products' => ['ProductImages']])
            ->orderAsc('Cart.created');

        if ($Cart->isEmpty()) throw new NotFoundException();

        /** @var \App\Model\Entity\Cart[] $cart */
        $cart = $Cart->toArray();

        // 未支付订单，如果存在将自动填写地址
        $Cashing = $this->Orders->find()->where([
            'Orders.order_status_id' => \App\Model\Entity\OrderStatus::CASHING,
            'Orders.user_id' => $this->Auth->user('id')
        ]);

        if ($this->request->is('post')) {
            // 送往Bot端的商品数据
            $data = [
                'amazon_account' => null,
                'order_details' => []
            ];

            // 生成新订单
            $order = $this->Orders->newEntity();

            if (($address_id = $this->request->getData('selected')) === '0') {
                // 用户输入的地址，需要进行验证
                $result = $this->Data->validate([
                    'name' => $this->request->getData('name'),
                    'postcode' => $this->request->getData('postcode'),
                    'address' => $this->request->getData('address'),
                    'tel' => $this->request->getData('tel')
                ], $order);

                if (!empty($result['errors'])) {
                    $result['default']['delivery'] = $this->request->getData('delivery');
                    $this->_set($result);
                    return $this->redirect(['action' => 'checkout']);
                }
            } else {
                // 选择的地址
                /** @var \App\Model\Entity\Address $address */
                $address = $this->Addresses->find('active')
                    ->where([
                        'Addresses.user_id' => $this->Auth->user('id'),
                        'Addresses.id' => $address_id
                    ])
                    ->first();

                if (is_null($address)) throw new BadRequestException();

                $order->name = $address->name;
                $order->postcode = $address->postcode;
                $order->address = $address->address;
                $order->tel = $address->tel;
            }

            $order->delivery_type_id = $this->request->getData('delivery');
            $order->user_id = $this->Auth->user('id');
            $order->order_status_id = \App\Model\Entity\OrderStatus::CASHING;

            $order->order_details = [];
            foreach ($cart as $item) {
                $product = $item->product;

                $order->order_details[] = $this->OrderDetails->newEntity([
                    'product_id' => $product->id,
                    'asin' => $product->asin,
                    'name' => $product->name,
                    'price' => $product->price,
                    'standard' => $product->standard,
                    'image' => $product->product_image->main,
                    'product_type_id' => $product->product_type_id,
                    'sale_start_date' => $product->sale_start_date,
                    'restrict_flg' => $product->restrict_flg,
                    'amazon_order_code' => null,
                    'quantity' => $item->quantity
                ]);

                $data['order_details'][$product->asin] = [
                    'price' => $product->price,
                    'quantity' => $item->quantity
                ];
            }

            $this->Data->completion($order, ['ignore' => 'amazon_account']);

            /** @var \App\Model\Entity\AmazonAccount $amazon_account */
            if ($Cashing->isEmpty()) {
                // 新注文，选择一个新Amazon账号
                $amazon_account = $this->AmazonAccounts->find()
                    ->where(['AmazonAccounts.amazon_account_status_id' => \App\Model\Entity\AmazonAccountStatus::IDLE])
                    ->orderDesc('AmazonAccounts.balance')
                    ->first();
            } else {
                // 二次注文，使用原有Amazon账号
                $amazon_account = $this->AmazonAccounts->find()
                    ->where([
                        'AmazonAccounts.email' => $Cashing->first()->amazon_account,
                        'AmazonAccounts.amazon_account_status_id' => \App\Model\Entity\AmazonAccountStatus::USING
                    ])
                    ->first();
            }

            // 若没有可用的Amazon账号，则要求排队
            if (is_null($amazon_account)) {
                return $this->render('busy');
            }

            // 立刻上锁账号
            $amazon_account->amazon_account_status_id = \App\Model\Entity\AmazonAccountStatus::USING;
            if ($this->AmazonAccounts->save($amazon_account)) {
                $order->amazon_account = $data['amazon_account'] = $amazon_account->email;
            } else {
                throw new BadRequestException();
            }

            // 同一时间同一用户只能存在一件未支付订单，重复的POST请求将清除当前所有该用户的未支付订单
            foreach ($Cashing->toArray() as $cashing) {
                $this->Orders->delete($cashing);
            }

            try {
                // Bot加入购物车
                $response = $this->Amazon->bot(BOT_CART, $data);

                if (
                    @$response['result']
                    && count(@$response['products']) === count($data['order_details'])
                    && empty(array_diff_key(@$response['products'], $data['order_details']))
                ) {
                    $divergence = [];
                    $cart = [];
                    foreach ($response['products'] as $asin => $product) {
                        // 原价格和数量
                        $price = $data['order_details'][$asin]['price'];
                        $quantity = $data['order_details'][$asin]['quantity'];

                        // Amazon价格和数量
                        $amazon_price = $product['price'];
                        $amazon_quantity = $product['quantity'];

                        if ($amazon_price === $price && $amazon_quantity === $quantity) {
                            continue;
                        } else {
                            $divergence[$asin] = [
                                'price' => $price,
                                'amazon_price' => $amazon_price,
                                'quantity' => $quantity,
                                'amazon_quantity' => $amazon_quantity
                            ];

                            /** @var \App\Model\Entity\Cart $item */
                            $item = (clone $Cart)->where(['Products.asin' => $asin])->firstOrFail();

                            // 价格变化
                            if ($amazon_price !== $price) {
                                if ($item->product->price !== $amazon_price) {
                                    $item->product->price = $amazon_price;
                                    $item->setDirty('product', true);
                                }
                            }

                            // 数量不足
                            if ($amazon_quantity !== $quantity) {
                                $item->quantity = $amazon_quantity;
                            }

                            if ($item->isDirty()) {
                                $cart[] = $item;
                            }
                        }
                    }

                    // 保存价格有变化的商品的最新价格，数量修改为可购买的最大数量
                    if (!empty($cart)) {
                        $this->Cart->saveMany($cart);
                    }
                } else {
                    $this->_handleError($response);
                }

                // Bot填写地址
                $response = $this->Amazon->bot(BOT_CHECKOUT, ['amazon_account' => $order->amazon_account]);

                if (@$response['result']) {
                    $order->total_price = $response['price'];
                    $order->order_summaries = $this->OrderSummaries->newEntities($response['summaries']);
                } else {
                    $this->_handleError($response);
                }

                $order = $this->Orders->save($order);

                if (!$order) {
                    // TODO send mail including order data
                    throw new BotException();
                }

                $this->set(compact('order', 'divergence'));

                return $this->render('view');

            } catch (\Exception $e) {
                $amazon_account->amazon_account_status_id = \App\Model\Entity\AmazonAccountStatus::IDLE;
                $this->AmazonAccounts->save($amazon_account);

                throw $e;
            }

        } else {
            // 存在未支付注文时，自动填写其地址
            if (!$Cashing->isEmpty()) {
                /** @var \App\Model\Entity\Order $last */
                $last = $Cashing->last();

                $default = [
                    'name' => $last->name,
                    'postcode' => $last->postcode,
                    'address' => $last->address,
                    'tel' => $last->tel,
                    'delivery' => $last->delivery_type_id
                ];

                $this->set(compact('default'));
            }
        }

        $addresses = $this->Addresses->find('active')
            ->where(['Addresses.user_id' => $this->Auth->user('id')])
            ->orderAsc('Addresses.created')
            ->toArray();

        $delivery_types = $this->DeliveryTypes->find('active')->combine('id', 'name')->toArray();

        $this->set(compact('addresses', 'delivery_types'));
    }

    public function buy($id = null)
    {
        $this->request->allowMethod('put');
        $this->autoRender = false;

        $this->loadModel('PointHistory');
        $this->loadModel('Products');

        /** @var \App\Model\Entity\Order $order */
        $order = $this->Orders->find('active')
            ->where([
                'Orders.user_id' => $this->Auth->user('id'),
                'Orders.id' => $id,
                'Orders.order_status_id' => \App\Model\Entity\OrderStatus::CASHING
            ])
            ->contain(['OrderDetails'])
            ->first();

        if (is_null($order)) {
            // 用户变更、交易过期等情况导致无法确认注文的情况下，返回购物车
            return $this->render('exception');
        }

        $user = $this->Users->get($this->Auth->user('id'));

        // 余额不足，前往充值中心
        if ($user->point < $order->total) {
            return $this->redirect(['controller' => 'Charge', 'action' => 'index']);
        }

        // 扣款
        $point_history = [];
        // 通常款
        $point_history[] = $this->PointHistory->newEntity([
            'user_id' => $this->Auth->user('id'),
            'point' => $order->total_price * -1,
            'point_type_id' => \App\Model\Entity\PointType::ORDER,
            'order_id' => $order->id
        ]);
        // 邮费
        if (!$order->isFreeShipping()) {
            $point_history[] = $this->PointHistory->newEntity([
                'user_id' => $this->Auth->user('id'),
                'point' => -0,
                'point_type_id' => \App\Model\Entity\PointType::POSTAGE,
                'order_id' => $order->id
            ]);
        }

        // 扣款失败
        if ($this->PointHistory->saveMany($point_history) === false) {
            $this->_fail($order);
        }

        // TODO send Request
        $result = true;

        if (!$result) {
            // 失败返款
            $this->PointHistory->deleteAll(['PointHistory.order_id' => $order->id]);

            $this->_fail($order);
        }

        $order->order_status_id = \App\Model\Entity\OrderStatus::FINISH;
        $order->finish = Time::now();
        $this->Orders->save($order);

        // 商品被购买次数增加
        foreach ($order->order_details as $order_detail) {
            /** @var \App\Model\Entity\Product $product */
            $product = $this->Products->find()->where(['asin' => $order_detail->asin])->first();
            if (!is_null($product)) {
                $product->bought_times += 1;
                $this->Products->save($product);
            }
        }

        // 清空购物车
        $this->Cart->deleteAll(['Cart.user_id' => $this->Auth->user('id')]);

        $this->request->session()->write(SESSION_FROM_ORDER, true);

        return $this->redirect(['action' => 'success']);
    }

    public function success()
    {
        $this->request->allowMethod('get');
        if (!$this->request->session()->consume(SESSION_FROM_ORDER)) throw new NotFoundException();
    }

    public function fail()
    {
        $this->request->allowMethod('get');
        if (!$this->request->session()->consume(SESSION_FROM_ORDER)) throw new NotFoundException();
    }

    /**
     * 交易失败
     *
     * @param \App\Model\Entity\Order $order
     * @return \Cake\Http\Response
     */
    private function _fail(\App\Model\Entity\Order $order)
    {
        $order->order_status_id = \App\Model\Entity\OrderStatus::FAIL;
        $order->finish = Time::now();
        $this->Orders->save($order);

        $this->request->session()->write(SESSION_FROM_ORDER, true);

        return $this->redirect('fail');
    }

    /**
     * Bot端Error处理
     * @param $response
     * @throws \Exception
     */
    private function _handleError($response)
    {
        $error_message = null;

        if (@$response['result'] === false) {
            $error_message = $response['message'];
        }
        // TODO send Mail
        throw new BotException($error_message);
    }
}
