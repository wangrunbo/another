<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

/**
 * Class ProductsController
 * @package App\Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 * @property \App\Controller\Component\AmazonComponent $Amazon
 */
class ProductsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'search', 'view']);

        return parent::beforeFilter($event);
    }

    public function index()
    {
        return $this->render('not_exist');
    }

    /**
     * 商品检索结果
     *
     * @param string|null $asin
     * @return \Cake\Http\Response
     */
    public function view($asin = null)
    {
        $this->request->allowMethod('get');
        if (is_null($asin)) throw new NotFoundException();

        $Product = $this->Products->find('active')
            ->where(['asin' => $asin])
            ->contain(['ProductTypes', 'ProductImages', 'ProductInfo' => ['ProductInfoTypes']]);

        if ($Product->isEmpty()) {
            $this->set(compact('asin'));

            return $this->render('not_exist');
        }

        /** @var \App\Model\Entity\Product $product */
        $product = $Product->first();

        $product->searched_times += 1;

        $this->Products->save($product);

        $this->set(compact('product'));
    }

    public function search()
    {
        $this->request->allowMethod('get');
        $this->autoRender = false;
        $this->loadComponent('Amazon');

        $search = $this->request->getQuery('s');
        $asin = strtoupper($search);

        if (empty($asin)) {
            return $this->redirect(['action' => 'index']);
        }

        $Product = $this->Products->find('active')->where(['Products.asin' => $asin]);

        if ($Product->isEmpty()) {
            // 访问Amazon搜索商品
            $product = $this->Amazon->get($asin);

            if (!is_null($product)) {
                $product->searcher_id = $this->Auth->user('id');
                $result = $this->Products->save($product, ['validate' => 'curl']);

                if ($result === false) {
                    // TODO send mail
                }
            }
        }

        return $this->redirect(['action' => 'view', $asin]);
    }
}
