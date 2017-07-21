<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;
use function PHPSTORM_META\type;

/**
 * Class MypageController
 * @package App\Controller
 * @property \App\Model\Table\AddressesTable $Addresses
 * @property \App\Model\Table\SexTable $Sex
 * @property \App\Model\Table\LoginHistoryTable $LoginHistory
 */
class MypageController extends AppController
{

    public function index()
    {
        $this->request->allowMethod('get');

        $user = $this->Users->get($this->Auth->user('id'), ['contain' => ['Addresses']]);
        dump($user);exit;

        $this->set(compact('user'));
    }

    ################################# 基本信息 #################################

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
                $this->Data->resume($user);
                $result['default']['birthday'] = $this->request->getData('birthday');

                $this->set($result);
            }
        }

        $sex = $this->Sex->find('active')->select(['id', 'name'])->combine('id', 'name')->toArray();
        $this->set(compact('user', 'sex'));
    }

    ################################# 地址信息 #################################

    /**
     * 地址信息
     *
     * @param null|int $id
     * @return \Cake\Http\Response|null
     */
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
                $address = $this->Addresses->find('active')->where([
                    'Addresses.id' => $id,
                    'Addresses.user_id' => $this->Auth->user('id')
                ])->first();

                if (is_null($address)) throw new BadRequestException();

                $this->set('target', $address->id);
            }

            $result = $this->Data->validate($data, $address, function () use ($address, $data) {
                if ($address->isNew()) {
                    $address->user_id = $this->Auth->user('id');
                    $this->Data->completion($address);
                }
            });

            if (empty($result['errors'])) {
                $this->Addresses->save($address);
                return $this->redirect(['action' => 'myAddresses']);
            } else {
                $this->set($result);
            }
        }

        $addresses = $this->Addresses->find('active')
            ->where(['Addresses.user_id' => $this->Auth->user('id')])
            ->orderAsc('Addresses.created')
            ->toArray();

        $this->set(compact('addresses'));
    }

    public function deleteAddress($id = null)
    {
        $this->request->allowMethod('put');
        $this->autoRender = false;
        if (is_null($id)) throw new BadRequestException();

        $this->loadModel('Addresses');

        $address = $this->Addresses->find('active')->where([
            'Addresses.id' => $id,
            'Addresses.user_id' => $this->Auth->user('id')
        ])->first();

        if (is_null($address)) {
            throw new BadRequestException();
        }

        $this->Addresses->softDelete($address);

        return $this->redirect(['action' => 'myAddresses']);
    }

    ################################# 私信 #################################

    public function myMessage()
    {

    }

    ################################# 账号安全 #################################

    public function mySecurity()
    {
        $this->request->allowMethod(['get', 'post']);

        $this->loadModel('LoginHistory');

        if ($this->request->is(['post'])) {
            $action = "_{$this->request->getData('action')}";

            if (is_callable([$this, $action])) {
                $this->{$action}();
            } else {
                throw new BadRequestException();
            }
        }

        $LoginHistory = $this->LoginHistory->find('active')
            ->where([
                'LoginHistory.user_id' => $this->Auth->user('id')
            ])
            ->orderDesc('LoginHistory.created');

        $login_history = $this->paginate($LoginHistory)->toArray();

        $this->set(compact('login_history'));
    }

    protected function _changePassword()
    {
        $user = $this->Users->get($this->Auth->user('id'));

        $data = [
            'former_password' => $this->request->getData('former_password'),
            'password' => $this->request->getData('password'),
            'password_confirm' => $this->request->getData('password_confirm'),
        ];

        $result = $this->Data->validate($data, $user, null, ['validate' => 'password']);

        if (empty($result['errors'])) {
            $this->Users->save($user);
            $this->Auth->setUser($user->toArray());

            return $this->redirect(['action' => 'mySecurity']);
        } else {
            $this->set('target', 'password');
            $this->set($result);
        }
    }
}
