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
            <?= $this->Form->control('username', ['type' => 'text', 'value' => $default['username']]) ?>
            <?php if (isset($errors['username'])): ?>
                <?= $this->element('validation', ['field' => 'username', 'error' => $errors['username']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('email')) ?></dt>
        <dd>
            <?= $this->Form->control('email', ['type' => 'text', 'value' => $default['email']]) ?>
            <?php if (isset($errors['email'])): ?>
                <?= $this->element('validation', ['field' => 'email', 'error' => $errors['email']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('password')) ?></dt>
        <dd>
            <?= $this->Form->control('password', ['type' => 'password', 'value' => '']) ?>
            <?php if (isset($errors['password'])): ?>
                <?= $this->element('validation', ['field' => 'password', 'error' => $errors['password']]) ?>
            <?php endif; ?>
        </dd>

        <dt><?= h(__('password_confirm')) ?></dt>
        <dd>
            <?= $this->Form->control('password_confirm', ['type' => 'password', 'value' => '']) ?>
            <?php if (isset($errors['password_confirm'])): ?>
                <?= $this->element('validation', ['field' => 'password_confirm', 'error' => $errors['password_confirm']]) ?>
            <?php endif; ?>
        </dd>
    </dl>
    <button type="submit"><?= h(__('OK')) ?></button>
<?= $this->Form->end() ?>
