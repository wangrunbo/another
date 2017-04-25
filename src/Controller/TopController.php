<?php
/**
 * Created by PhpStorm.
 * User: wangrunbo
 * Date: 17/04/19
 * Time: 14:17
 */

namespace App\Controller;


use Cake\Event\Event;

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
                $error = __('Email or password incorrect');
                $default = $this->request->getData();
                foreach ($default as $key => $value) {
                    if (empty($value)) {
                        $error = __('Please enter your email and password');
                        break;
                    }
                }

                $this->set(compact('error', 'default'));
            }
        }
    }

    public function logout()
    {
        $this->request->allowMethod('get');
        $this->autoRender = false;
    }
}