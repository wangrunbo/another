<?php
/**
 * Created by PhpStorm.
 * User: wangrunbo
 * Date: 17/04/19
 * Time: 18:15
 */

namespace App\Controller;


use Cake\Event\Event;

class RegisterController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow();

        return parent::beforeFilter($event);
    }

    public function index()
    {
        $this->request->allowMethod(['GET', 'POST']);

        if ($this->request->is('POST')) {
            dump($this->request->getData());
        }
    }
}