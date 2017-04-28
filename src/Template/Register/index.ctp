<?php
/**
 * @var \App\View\AppView $this
 * @var array $errors
 * @var array|null $default
 */
if (!isset($default)) {
    $default = [
        'username' => '',
        'email' => ''
    ];
}

$this->title(__('Register'))
?>
<h3><?= h(__('Register')) ?></h3>
<?= $this->Form->create() ?>
    <dl>
        <dt><?= h(__('username')) ?></dt>
        <dd>
            <input type="text" title="<?= h(__('username')) ?>" name="username" value="<?= $default['username'] ?>" />
            <?php if (isset($errors['username'])): ?>
                <?= $this->element('validation', ['field' => 'username', 'error' => $errors['username']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('email')) ?></dt>
        <dd>
            <input type="text" title="<?= h(__('email')) ?>" name="email" value="<?= $default['email'] ?>" />
            <?php if (isset($errors['email'])): ?>
                <?= $this->element('validation', ['field' => 'email', 'error' => $errors['email']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('password')) ?></dt>
        <dd>
            <input type="password" title="<?= h(__('password')) ?>" name="password" value="" />
            <?php if (isset($errors['password'])): ?>
                <?= $this->element('validation', ['field' => 'password', 'error' => $errors['password']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('password_confirm')) ?></dt>
        <dd>
            <input type="password" title="<?= h(__('password_confirm')) ?>" name="password_confirm" value="" />
            <?php if (isset($errors['password_confirm'])): ?>
                <?= $this->element('validation', ['field' => 'password_confirm', 'error' => $errors['password_confirm']]) ?>
            <?php endif; ?>
        </dd>
    </dl>
    <button type="submit"><?= h(__('OK')) ?></button>
<?= $this->Form->end() ?>
