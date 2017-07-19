<?php
/**
 * @var \App\View\AppView $this
 * @var array $errors
 * @var array $default
 */
if (!isset($default)) {
    $default = $this->request->session()->check(SESSION_DEFAULT)?
        $this->request->session()->consume(SESSION_DEFAULT) :
        ['username' => '', 'email' => ''];
}

$this->title(__('Register'))
?>
<h3><?= h(__('Register')) ?></h3>
<?= $this->form() ?>
    <dl>
        <dt><?= h(__('username')) ?></dt>
        <dd>
            <input name="username" type="text" value="<?= $default['username'] ?>" title="<?= __('username') ?>" />
            <?php if (isset($errors['username'])): ?>
                <?= $this->element('validation', ['field' => 'username', 'error' => $errors['username']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('email')) ?></dt>
        <dd>
            <input name="email" type="text" value="<?= $default['email'] ?>" title="<?= __('email') ?>" />
            <?php if (isset($errors['email'])): ?>
                <?= $this->element('validation', ['field' => 'email', 'error' => $errors['email']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('password')) ?></dt>
        <dd>
            <input name="password" type="password" title="<?= __('password') ?>" />
            <?php if (isset($errors['password'])): ?>
                <?= $this->element('validation', ['field' => 'password', 'error' => $errors['password']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('password_confirm')) ?></dt>
        <dd>
            <input name="password_confirm" type="password" title="<?= __('password_confirm') ?>" />
            <?php if (isset($errors['password_confirm'])): ?>
                <?= $this->element('validation', ['field' => 'password_confirm', 'error' => $errors['password_confirm']]) ?>
            <?php endif; ?>
        </dd>
    </dl>
    <button type="submit"><?= h(__('OK')) ?></button>
<?= $this->endForm(['username' => null, 'email' => null, 'password' => null, 'password_confirm' => null]) ?>