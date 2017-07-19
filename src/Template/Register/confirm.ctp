<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->title(__('Confirm Register Information'));
?>
<h3><?= h(__('Confirm Register Information')) ?></h3>
<?= $this->form(null, ['url' => ['controller' => 'Register', 'action' => 'inactive']]) ?>
    <dl>
        <dt><?= h(__('username')) ?></dt>
        <dd>
            <?= h($user->username) ?>
        </dd>

        <dt><?= h(__('email')) ?></dt>
        <dd>
            <?= h($user->email) ?>
        </dd>
    </dl>
    <button type="submit"><?= h(__('OK')) ?></button>
    <a href="<?= $this->Url->build(['controller' => 'Register', 'action' => 'index']) ?>">返回</a>

    <input name="username" type="hidden" value="<?= $user->username ?>" />
    <input name="email" type="hidden" value="<?= $user->email ?>" />
    <input name="password" type="hidden" value="<?= $user->password ?>" />
<?= $this->endForm(['username' => $user->username, 'email' => $user->email, 'password' => $user->password]) ?>