<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div>
    <ul>
        <li><a href="<?= $this->Url->build(['action' => 'index']) ?>">我的主页</a></li>
        <li><a href="<?= $this->Url->build(['action' => 'info']) ?>">基本信息</a></li>
        <li><a href="<?= $this->Url->build(['action' => 'addresses']) ?>">地址</a></li>
        <li><a href="<?= $this->Url->build(['action' => 'message']) ?>">私信</a></li>
        <li><a href="<?= $this->Url->build(['action' => 'security']) ?>">帐号安全</a></li>
    </ul>
</div>
