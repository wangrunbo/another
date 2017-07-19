<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 * @property \App\Controller\Component\DataComponent $Data
 * @property \App\Model\Table\UsersTable Users
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Users');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginAction' => [
                'controller' => 'Top',
                'action' => 'login',
                'plugin' => null
            ],
            'loginRedirect' => '/',
            'logoutRedirect' => '/',
            'storage' => [
                'className' => 'Session',
                'key' => SESSION_LOGIN,
            ],
            'authenticate' => [
                'Basic' => ['userModel' => 'Users'],
                'Form' => [
                    'userModel' => 'Users',
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    'finder' => 'auth'
                ]
            ],
            'authError' => false,
            'ajaxLogin' => false
        ]);

        $this->loadComponent('Data');

        $this->paginate = app_config('Display.pagination.default');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * 权限控制
     *
     * @param null|array $user
     * @return bool
     */
    public function isAuthorized($user = null)
    {
        if ($this->Users->get($user['id'])->user_status_id === \App\Model\Entity\UserStatus::STATUS_DELETED) {
            $this->Auth->logout();
        }

        return true;
    }
}
