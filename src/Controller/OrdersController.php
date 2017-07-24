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

        if ($this->request->is('post')) {
            // 同一时间同一用户只能存在一件未支付订单，重复的POST请求将清除当前所有该用户的未支付订单
            $this->Orders->deleteAll(['Orders.order_status_id' => \App\Model\Entity\OrderStatus::CASHING]);

            $order = $this->Orders->newEntity();

            if (($address_id = $this->request->getData('selected')) === '0') {
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
        }

        $addresses = $this->Addresses->find('active')
            ->where(['Addresses.user_id' => $this->Auth->user('id')])
            ->orderAsc('Addresses.created')
            ->toArray();

        $delivery_types = $this->DeliveryTypes->find('active')->combine('id', 'name')->toArray();

        $this->set(compact('addresses', 'delivery_types'));
    }

    public function buy()
    {
        dump('buy');exit;
    }
}
