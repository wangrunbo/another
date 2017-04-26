<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Class ProductsController
 * @package App\Controller
 */
class ProductsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'search']);

        return parent::beforeFilter($event);
    }

    public function index()
    {

    }

    public function search()
    {
        $this->request->allowMethod('get');
        $this->autoRender = false;
    }
}
