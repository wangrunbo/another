<?php
/**
 * @var \App\View\AppView $this
 * @var array $errors
 * @var array $default
 */
?>
<h3>用户注册</h3>
<?= $this->Form->create() ?>
    <dl>
        <dt>用户名</dt>
        <dd>
            <input type="text" title="邮箱" name="username" />
            <?php if (isset($errors['username'])): ?>
                <?= $this->element('validation', ['field' => 'username', 'message' => $errors['username']]) ?>
            <?php endif; ?>
        </dd>

        <dt>邮箱</dt>
        <dd>
            <input type="text" title="邮箱" name="email" />
            <?php if (isset($errors['email'])): ?>
                <?= $this->element('validation', ['field' => 'email', 'message' => $errors['email']]) ?>
            <?php endif; ?>
        </dd>

        <dt>密码</dt>
        <dd>
            <input type="password" title="密码" name="password" />
            <?php if (isset($errors['password'])): ?>
                <?= $this->element('validation', ['field' => 'password', 'message' => $errors['password']]) ?>
            <?php endif; ?>
        </dd>

        <dt>密码确认</dt>
        <dd>
            <input type="password" title="密码确认" name="password_confirm" />
            <?php if (isset($errors['password_confirm'])): ?>
                <?= $this->element('validation', ['field' => 'password_confirm', 'message' => $errors['password_confirm']]) ?>
            <?php endif; ?>
        </dd>
    </dl>
    <button type="submit">确认</button>
    <button type="button">返回</button>
<?= $this->Form->end() ?>
