<?php
/**
 * @var \App\View\AppView $this
 * @var array $default
 * @var string $error
 */

$this->title(__('Login'))
?>
<h3><?= h(__('Login')) ?></h3>

<?php if (isset($error)): ?>
    <div>
        <p><?= h($error) ?></p>
    </div>
<?php endif; ?>

<?= $this->Form->create() ?>
    <?= $this->Form->control('email', ['type' => 'text', 'value' => @$default['email'], 'placeholder' => __('email')]) ?>
    <?= $this->Form->control('password', ['type' => 'password', 'value' => "", 'placeholder' => __('password')]) ?>
    <button type="submit"><?= h(__('login')) ?></button>
<?= $this->Form->end() ?>
