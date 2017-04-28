<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Class MypageController
 * @package App\Controller
 * @property \App\Model\Table\AddressesTable $Addresses
 */
class MypageController extends AppController
{

    public function index()
    {
        $this->request->allowMethod('get');

        $user = $this->Users->get($this->Auth->user('id'));

        $this->set(compact('user'));
    }

    public function myInfo()
    {
        $this->request->allowMethod(['get', 'post']);

        $user = $this->Users->get($this->Auth->user('id'));

        if ($this->request->is('post')) {
            $result = $this->Data->validate($this->request->getData(), $user);

            if (empty($result['errors'])) {
                $this->Users->save($user);
                return $this->redirect(['action' => 'myInfo']);
            } else {
                $this->set($result);
            }
        }

        $this->set(compact('user'));
    }

    public function myAddresses($id = null)
    {
        $this->request->allowMethod(['get', 'post']);

        $this->loadModel('Addresses');

        $addresses = $this->Addresses->find('all', [
            'conditions' => [
                'Addresses.user_id' => $this->Auth->user('id')
            ],
            'select' => ['name', 'postcode', 'address', 'tel']
        ])->toArray();

        $this->set(compact('addresses'));
    }
}
