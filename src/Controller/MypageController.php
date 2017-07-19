<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Network\Exception\BadRequestException;
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
                $this->Data->reduction($user);
                $result['default']['birthday'] = $this->request->getData('birthday');

                $this->set($result);
            }
        }

        $sex = $this->Sex->find('active')->select(['id', 'name'])->combine('id', 'name')->toArray();
        $this->set(compact('user', 'sex'));
    }

    public function myAddresses($id = null)
    {
        $this->request->allowMethod(['get', 'post', 'put']);
        $this->loadModel('Addresses');

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            if (is_null($id)) {
                // 新建地址
                $address = $this->Addresses->newEntity();
            } else {
                // 地址编辑
                $address = $this->Addresses->find('all', [
                    'conditions' => [
                        'Addresses.id' => $id,
                        'Addresses.user_id' => $this->Auth->user('id')
                    ]
                ])->first();

                if (is_null($address)) {
                    throw new BadRequestException();
                }

                $this->set('target', $address->id);
            }

            $result = $this->Data->validate($data, $address, function () use ($address, $data) {
                if ($address->isNew()) {
                    $address->user_id = $this->Auth->user('id');
                    $this->Data->completion($address, [
                        'ignore' => array_keys($data)
                    ]);
                }
            });

            if (empty($result['errors'])) {
                $this->Addresses->save($address);
                return $this->redirect(['action' => 'myAddresses']);
            } else {
                $this->set($result);
            }
        }

        $addresses = $this->Addresses->find('all', [
            'conditions' => [
                'Addresses.user_id' => $this->Auth->user('id')
            ],
            'select' => ['label', 'name', 'postcode', 'address', 'tel']
        ])->toArray();

        $this->set(compact('addresses'));
    }

    public function deleteAddress($id = null)
    {
        $this->request->allowMethod('put');
        $this->autoRender = false;
        $this->loadModel('Addresses');

        if (is_null($id)) {
            throw new BadRequestException();
        }

        $address = $this->Addresses->find('all', [
            'conditions' => [
                'Addresses.id' => $id,
                'Addresses.user_id' => $this->Auth->user('id')
            ]
        ])->first();

        if (is_null($address)) {
            throw new BadRequestException();
        }

        $this->Addresses->delete($address);

        return $this->redirect(['action' => 'myAddresses']);
    }
}
