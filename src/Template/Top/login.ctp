<?php
/**
 * @var \App\View\AppView $this
 * @var array $default
 * @var string $error
 */
if (!isset($default)) {
    $default = [
        'email' => ''
    ];
}
?>
<h3>登录</h3>

<?php if (isset($error)): ?>
    <div>
        <p><?= h($error) ?></p>
    </div>
<?php endif; ?>

<?= $this->Form->create() ?>
    <dl>
        <dt>邮箱</dt>
        <dd>
            <input type="text" title="邮箱" name="email" value="<?= $default['email'] ?>" />
        </dd>

        <dt>密码</dt>
        <dd>
            <input type="password" title="密码" name="password" value="" />
        </dd>
    </dl>
    <button type="submit">登录</button>
<?= $this->Form->end() ?>
