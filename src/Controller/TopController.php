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
        $this->request->allowMethod('GET');
    }

    public function login()
    {
        $this->request->allowMethod(['GET', 'POST']);
    }

    public function logout()
    {
        $this->request->allowMethod('GET');
        $this->autoRender = false;
    }
}