<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;

/**
 * History Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class HistoryController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Orders');
    }

    public function index()
    {
        $this->request->allowMethod('get');

        $orders = $this->Orders->find('active')
            ->where(function (QueryExpression $exp, Query $q) {
                return $exp
                    ->eq('Orders.user_id', $this->Auth->user('id'))
                    ->or_([
                        $q->newExpr()->eq('Orders.order_status_id', \App\Model\Entity\OrderStatus::FINISH),
                        $q->newExpr()->eq('Orders.order_status_id', \App\Model\Entity\OrderStatus::FAIL)
                    ]);
            })
            ->contain(['OrderDetails'])
            ->orderDesc('Orders.finish')
            ->toArray();

        $this->set(compact('orders'));
    }
}
