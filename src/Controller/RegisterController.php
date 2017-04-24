<?php
/**
 * Created by PhpStorm.
 * User: wangrunbo
 * Date: 17/04/19
 * Time: 18:15
 */

namespace App\Controller;


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
            $user = $this->Users->newEntity()->updateSecret();

            $result = $this->Data->validate($this->request->getData(), $user);

            if (empty($result['errors'])) {
                $user->created = Time::now();
                $user->updated = Time::now();
                if ($this->Users->save($user)) {
                    return $this->render('complete');
                } else {
                    $this->Flash->error(__('The server is busy!! Please try later.'));
                }
            }

            $this->set($result);
        }
    }
}