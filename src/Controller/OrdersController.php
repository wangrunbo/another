<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 * @property \App\Model\Table\OrderDetailsTable $OrderDetails
 * @property \App\Model\Table\CartTable $Cart
 * @property \App\Model\Table\AddressesTable $Addresses
 * @property \App\Model\Table\DeliveryTypesTable $DeliveryTypes
 * @property \App\Model\Table\PointHistoryTable $PointHistory
 */
class OrdersController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('OrderDetails');
        $this->loadModel('Cart');
    }

    public function checkout()
    {
        $this->request->allowMethod(['get', 'post']);

        $this->loadModel('Addresses');
        $this->loadModel('DeliveryTypes');

        /** @var \App\Model\Entity\Cart[] $cart */
        $cart = $this->Cart->find()
            ->where(['Cart.user_id' => $this->Auth->user('id')])
            ->contain(['Products' => ['ProductImages']])
            ->orderAsc('Cart.created')
            ->toArray();

        if (empty($cart)) throw new NotFoundException();

        // 未支付订单，如果存在将自动填写地址
        $Cashing = $this->Orders->find()->where([
            'Orders.order_status_id' => \App\Model\Entity\OrderStatus::CASHING,
            'Orders.user_id' => $this->Auth->user('id')
        ]);

        if ($this->request->is('post')) {
            // 同一时间同一用户只能存在一件未支付订单，重复的POST请求将清除当前所有该用户的未支付订单
            foreach ($Cashing->toArray() as $cashing) {
                $this->Orders->delete($cashing);
            }

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
            }

            $this->Data->completion($order);

            if ($order = $this->Orders->save($order)) {
                // TODO send Request

                $order->total_price = 0;  // TODO
                $order->amazon_postage = 0;  // TODO

                if ($this->Orders->save($order)) {
                    // 确认画面
                    $this->set(compact('order'));

                    return $this->render('view');
                } else {
                    throw new BadRequestException();
                }
            } else {
                throw new BadRequestException();
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

        /** @var \App\Model\Entity\Order $order */
        $order = $this->Orders->find('active')->where([
            'Orders.user_id' => $this->Auth->user('id'),
            'Orders.id' => $id,
            'Orders.order_status_id' => \App\Model\Entity\OrderStatus::CASHING
        ])->first();

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
            $this->fail($order);
        }

        // TODO send Request
        $result = true;

        if (!$result) {
            // 失败返款
            $this->PointHistory->deleteAll(['PointHistory.order_id' => $order->id]);

            $this->fail($order);
        }

        $order->order_status_id = \App\Model\Entity\OrderStatus::FINISH;
        $this->Orders->save($order);

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

    public function error()
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
    private function fail(\App\Model\Entity\Order $order)
    {
        $order->order_status_id = \App\Model\Entity\OrderStatus::FAIL;
        $this->Orders->save($order);

        $this->request->session()->write(SESSION_FROM_ORDER, true);

        return $this->redirect('error');
    }
}
