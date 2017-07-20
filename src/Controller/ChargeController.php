<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Class ChargeController
 * @package App\Controller
 */
class ChargeController extends AppController
{
    public function beforeFilter(Event $event)
    {
        return parent::beforeFilter($event);
    }

    public function index()
    {
        $this->request->allowMethod('get');

    }
}
