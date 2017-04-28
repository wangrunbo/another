<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Class TopController
 * @package App\Controller
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