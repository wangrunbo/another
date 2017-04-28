<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div>
    <ul>
        <li><a href="<?= $this->Url->build(['action' => 'index']) ?>">我的主页</a></li>
        <li><a href="<?= $this->Url->build(['action' => 'myInfo']) ?>">基本信息</a></li>
        <li><a href="<?= $this->Url->build(['action' => 'myAddresses']) ?>">地址</a></li>
        <li><a href="<?= $this->Url->build(['action' => 'myMessage']) ?>">私信</a></li>
        <li><a href="<?= $this->Url->build(['action' => 'mySecurity']) ?>">帐号安全</a></li>
    </ul>
</div>
