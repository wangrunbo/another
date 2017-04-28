<?php
/**
 * @var \App\View\AppView $this
 * @var array $data
 */
$this->title(__('Register Complete'))
?>
<div>
    <h3><?= h(__('Register Complete')) ?></h3>
    <p>请妥善保管您的帐号与密码</p>
    <p>如有疑问，请<a href="<?= $this->Url->build(['controller' => 'contact', 'action' => 'index']) ?>">点击这里</a></p>
    <p>
        请<a href="<?= $this->Url->build(['controller' => 'Mypage', 'action' => 'myInfo']) ?>">前往个人主页</a>完善您的个人信息
    </p>
</div>
