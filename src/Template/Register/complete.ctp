<?php
/**
 * @var \App\View\AppView $this
 * @var array $data
 */
$this->title('Register Complete')
?>
<div>
    <h3>注册成功</h3>
    <p>请妥善保管您的帐号与密码</p>
    <p>如有疑问，请<a href="<?= $this->Url->build(['controller' => 'contact', 'action' => 'index']) ?>">点击这里</a></p>
    <a href="<?= $this->Url->build(['controller' => 'Mypage', 'action' => 'index']) ?>">我的首页</a>
</div>
