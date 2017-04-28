<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div>
    <ul>
        <li><a href="<?= $this->Url->build(['action' => 'index']) ?>"><?= h(__('Mypage')) ?></a></li>
        <li><a href="<?= $this->Url->build(['action' => 'myInfo']) ?>"><?= h(__('Base Info')) ?></a></li>
        <li><a href="<?= $this->Url->build(['action' => 'myAddresses']) ?>"><?= h(__('Addresses')) ?></a></li>
        <li><a href="<?= $this->Url->build(['action' => 'myMessage']) ?>"><?= h(__('Private Messages')) ?></a></li>
        <li><a href="<?= $this->Url->build(['action' => 'mySecurity']) ?>"><?= h(__('Account Security')) ?></a></li>
        <li><a href="<?= $this->Url->build(['controller' => 'Top', 'action' => 'logout']) ?>"><?= h(__('Logout')) ?></a></li>
    </ul>
</div>
