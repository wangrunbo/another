<?php
/**
 * @var \App\View\AppView $this
 * @var array $data
 */
?>

<dl>
    <dt>用户名</dt>
    <dd><?= h($data['username']) ?></dd>

    <dt>邮箱</dt>
    <dd><?= h($data['email']) ?></dd>
</dl>

<?= $this->Form->create(null, ['url' => ['controller' => 'Register', 'action' => 'complete']]) ?>
    <button type="submit">确认</button>
    <a href="<?= $this->Url->build(['controller' => 'Register', 'action' => 'index']) ?>">返回</a>
<?= $this->Form->end() ?>
