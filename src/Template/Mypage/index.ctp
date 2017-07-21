<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div>
    <dl>
        <dt>用户名</dt>
        <dd><?= h($user->username) ?></dd>
        <dt>余额</dt>
        <dd><?= h($user->point) ?></dd>
    </dl>
</div>
