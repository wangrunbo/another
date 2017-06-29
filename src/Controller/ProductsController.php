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
        return $this->redirect(['action' => 'view', 'QWERASDFZX']);
    }

    public function view($asin = null)
    {
        $this->request->allowMethod('get');
        if (is_null($asin)) throw new NotFoundException();

        dump($asin);exit;
    }

    public function search()
    {
        $this->request->allowMethod('get');
        $this->autoRender = false;
        $this->loadComponent('Amazon');

        $search = $this->request->getQuery('s');
        $asin = $search;

        $Product = $this->Products->find('active')->where(['Products.asin' => $asin]);

        if ($Product->isEmpty()) {
            // achive amazon
            $product = $this->Amazon->get($asin);
            dump($product);exit;

            if (!is_null($product)) {
                $result = $this->Products->save($product, ['validate' => 'curl']);

                if ($result === false) {
                    // TODO send mail
                }
            }
        }

        return $this->redirect(['action' => 'view', $asin]);
    }
}
