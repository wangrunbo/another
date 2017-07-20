<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;
use function PHPSTORM_META\type;

/**
 * Class CartController
 * @package App\Controller
 * @property \App\Model\Table\CartTable $Cart
 * @property \App\Model\Table\ProductsTable $Products
 */
class CartController extends AppController
{
    public function beforeFilter(Event $event)
    {
        return parent::beforeFilter($event);
    }

    public function index()
    {
        $this->request->allowMethod('get');

        $cart = $this->Cart->find()
            ->where([
                'user_id' => $this->Auth->user('id')
            ])
            ->contain(['Products'])
            ->orderDesc('Cart.created')
            ->toArray();

        $this->set(compact('cart'));
    }

    /**
     * 商品加入购物车
     *
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        $this->request->allowMethod(['ajax', 'post']);
        $this->autoRender = false;

        $this->loadModel('Products');

        $asin = $this->request->getData('asin');
        $quantity = $this->request->getData('quantity');

        if (!$this->Cart->isNaturalNumber($quantity)) {
            $quantity = 1;
        }

        $product = $this->Products->find('active')->select('Products.id')->where([
            'asin' => $asin
        ])->first();

        if ($this->request->is('ajax')) {

        } else {
            if (!is_null($product)) {
                /** @var \App\Model\Entity\Cart $cart */
                $cart = $this->Cart->find()->where([
                    'user_id' => $this->Auth->user('id'),
                    'product_id' => $product->id
                ])->first();

                if (is_null($cart)) {
                    $cart = $this->Cart->newEntity([
                        'user_id' => $this->Auth->user('id'),
                        'product_id' => $product->id,
                        'quantity' => $quantity
                    ]);
                    $this->Data->completion($cart);
                } else {
                    $cart->quantity += $quantity;
                }

                if ($this->Cart->save($cart)) {
                    $this->_success(__('Successfully added product to cart.'));
                } else {
                    $this->_error(__('Fail to added product to cart!'));
                }

                $this->_set(compact('quantity'));
            }

            return $this->redirect(['controller' => 'Products', 'action' => 'view', $asin]);
        }
    }

    public function quantity($id = null)
    {
        $this->request->allowMethod(['ajax', 'put']);
        $this->autoRender = false;

        /** @var \App\Model\Entity\Cart $cart */
        $cart = $this->Cart->find()->where([
            'Cart.id' => $id,
            'user_id' => $this->Auth->user('id')
        ])->first();

        if (is_null($cart)) throw new BadRequestException();

        $this->Cart->patchEntity($cart, ['quantity' => $this->request->getData('quantity')]);

        $this->Cart->save($cart);

        return $this->redirect(['action' => 'index']);
    }
}
