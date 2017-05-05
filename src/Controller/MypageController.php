<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use function PHPSTORM_META\type;

/**
 * Class MypageController
 * @package App\Controller
 * @property \App\Model\Table\AddressesTable $Addresses
 * @property \App\Model\Table\SexTable $Sex
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
        $this->request->allowMethod(['get', 'put']);
        $this->loadModel('Sex');

        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => ['Sex' => ['fields' => ['name']]]
        ]);

        if ($this->request->is('put')) {
            $data = $this->request->getData();
            $data['birthday'] = $data['birthday']['year'].$data['birthday']['month'].$data['birthday']['day'];

            $result = $this->Data->validate($data, $user);

            if (empty($result['errors'])) {
                $this->Users->save($user);
                return $this->redirect(['action' => 'myInfo']);
            } else {
                $result['default']['birthday'] = $this->request->getData('birthday');

                $this->set($result);
            }
        }

        $sex = $this->Sex->find('active')->select(['id', 'name'])->combine('id', 'name')->toArray();
        $this->set(compact('user', 'sex'));
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
