<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Class RegisterController
 * @package App\Controller
 * @property \App\Model\Table\UsersTable $Users
 */
class RegisterController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Users');
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow();

        return parent::beforeFilter($event);
    }

    /**
     * @return \Cake\Http\Response
     */
    public function index()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {
            $user = $this->Users->newEntity();

            $result = $this->Data->validate($this->request->getData(), $user, function () use ($user) {
                $user->updateSecret();
                $user->account_status_id = \App\Model\Entity\AccountStatus::STATUS_GENERAL;
                $this->Data->completion($user);
            });

            if (empty($result['errors'])) {
                if ($this->Users->save($user)) {
                    $this->Auth->setUser($user->toArray());

                    return $this->render('inactive');
                } else {
                    $this->Flash->error(__('The server is busy!! Please try later.'));
                }
            }

            $this->set($result);
        }
    }
}