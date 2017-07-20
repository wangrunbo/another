<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{

    public function checkout()
    {
        $this->request->allowMethod(['get', 'post']);

        
    }

    public function buy()
    {
        dump('buy');exit;
    }
}
