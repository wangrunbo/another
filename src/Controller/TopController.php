<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

/**
 * Class TopController
 * @package App\Controller
 *
 * @property \App\Model\Table\LoginHistoryTable $LoginHistory
 */
class TopController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'login', 'logout']);

        return parent::beforeFilter($event);
    }

    public function index()
    {
        $this->request->allowMethod('get');
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {

            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                // 记录登录历史
                $this->loadModel('LoginHistory');

                $user_agent= $this->request->getHeader('User-Agent')[0];
                $login_history = $this->LoginHistory->newEntity([
                    'user_id' => $this->Auth->user('id'),
                    'time' => Time::now(),
                    'ip' => $this->request->clientIp(),
                    'os' => $this->LoginHistory->getOS($user_agent),
                    'browser' => $this->LoginHistory->getBrowser($user_agent),
                    'user_agent' => $user_agent,
                    'language' => \Cake\I18n\I18n::locale()
                ]);
                $this->LoginHistory->save($login_history);

                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $default = $this->request->getData();

                if (in_array('', $default)) {
                    $error = __d('message', 'Please enter your email and password');
                } else {
                    $error = __d('message', 'Email or password incorrect');
                }

                $this->set(compact('error', 'default'));
            }
        }
    }

    public function logout()
    {
        $this->request->allowMethod('get');
        $this->autoRender = false;

        return $this->redirect($this->Auth->logout());
    }
}