<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\BadRequestException;

/**
 * Class RegisterController
 * @package App\Controller
 */
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

    /**
     * @return \Cake\Http\Response
     */
    public function index()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {
            $user = $this->Users->newEntity();

            $result = $this->Data->validate($this->request->getData(), $user, function () use ($user) {
                $user->generateUid();
                $user->updateSecretKey();
                $user->sex_id = \App\Model\Entity\Sex::NOT_SET;
                $user->user_status_id = \App\Model\Entity\UserStatus::STATUS_GENERAL;
                $this->Data->completion($user);
            });

            if (empty($result['errors'])) {
                $this->request->session()->write(SESSION_DEFAULT, ['username' => $user->username, 'email' => $user->email]);
                $this->set(compact('user'));

                return $this->render('confirm');
            }

            $this->set($result);
        }
    }

    public function inactive()
    {
        $this->request->allowMethod('post');

        $user = $this->Users->newEntity([
            'username' => $this->request->getData('username'),
            'email' => $this->request->getData('email')
        ]);

        $user->generateUid();
        $user->password = $this->request->getData('password');
        $user->updateSecretKey();
        $user->sex_id = \App\Model\Entity\Sex::NOT_SET;
        $user->user_status_id = \App\Model\Entity\UserStatus::STATUS_GENERAL;
        $this->Data->completion($user);

        if ($this->Users->save($user)) {
            $this->request->session()->delete(SESSION_DEFAULT);
            $this->Auth->setUser($user->toArray());
        } else {
            throw new BadRequestException();
        }
    }

    public function back()
    {

    }
}