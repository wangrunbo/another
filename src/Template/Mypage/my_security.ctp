<?php
/**
 * @var \App\View\AppView $this
 * @var string $target
 * @var array $errors
 * @var array $default
 */
$blocks = ['password'];
foreach ($blocks as $block) {
    if (isset($default) && $block === $target) {
        $this->setStyle("{$block}.view", ['display' => 'none']);
        $this->setStyle("{$block}.input", ['display' => 'table']);
    } else {
        $this->setStyle("{$block}.view", ['display' => 'table']);
        $this->setStyle("{$block}.input", ['display' => 'none']);
    }
}
?>
<div id="block-password">
    <div class="block-view" style="display: <?= $this->getStyle('password.view.display') ?>">
        <button type="button" onclick="switchMode('input', $('#block-password'))">修改密码</button>
    </div>

    <div class="block-input" style="display: <?= $this->getStyle('password.input.display') ?>">
        <?= $this->form(null, ['url' => ['controller' => 'Mypage', 'action' => 'mySecurity', 'changePassword']]) ?>
            <dl>
                <dt>原密码</dt>
                <dd>
                    <input name="former_password" type="password" title="<?= __('former_password') ?>" />
                    <?php if (isset($errors['former_password'])): ?>
                        <?= $this->element('validation', ['field' => 'former_password', 'error' => $errors['former_password']]) ?>
                    <?php endif; ?>
                </dd>
                <dt>新密码</dt>
                <dd>
                    <input name="password" type="password" title="<?= __('password') ?>" />
                    <?php if (isset($errors['password'])): ?>
                        <?= $this->element('validation', ['field' => 'password', 'error' => $errors['password']]) ?>
                    <?php endif; ?>
                </dd>
                <dt>密码确认</dt>
                <dd>
                    <input name="password_confirm" type="password" title="<?= __('password_confirm') ?>" />
                    <?php if (isset($errors['password_confirm'])): ?>
                        <?= $this->element('validation', ['field' => 'password_confirm', 'error' => $errors['password_confirm']]) ?>
                    <?php endif; ?>
                </dd>
            </dl>

            <input name="action" type="hidden" value="changePassword" />
            <button type="submit"><?= h(__('OK')) ?></button>
            <button type="button" onclick="switchMode('view', $('#block-password')); resetForm($(this).closest('form')); clearValidationErrors($(this).closest('form'));"><?= h(__('Cancel')) ?></button>
        <?= $this->endForm(['former_password' => null, 'password' => null, 'password_confirm' => null, 'action' => 'changePassword']); ?>
    </div>
</div>