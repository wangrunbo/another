<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Class MypageController
 * @package App\Controller
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\AddressesTable $Addresses
 */
class MypageController extends AppController
{

    public function index()
    {
        $this->request->allowMethod('get');

//        $user = $this->Users->get($this->Auth->user('id'));
    }
}
