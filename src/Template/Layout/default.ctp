<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name=keywords content="晖尽, Fatego, 动漫" >
    <meta name=description content="欢迎来到晖尽的个人空间，喜欢的游戏是魔兽世界与Fatego，喜欢的动漫是空之境界。">
    <?= $this->fetch('meta') ?>

    <title>
        <?= h(SITE) ?>
        &nbsp;|&nbsp;
        <?= h($this->title()) ?>
    </title>

    <link rel="shortcut icon" href="">
    <?= $this->Html->css('style') ?>
    <?= $this->fetch('css') ?>

    <?= $this->Html->script('https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js') ?>
    <?= $this->Html->script('script') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
<header id="header">
    <div>
        <a href="http://61.152.73.26/HD/another/me.html">
            <img src="<?= $this->Url->image('logo.png') ?>" alt="<?= h(SITE) ?>" height="60px" title="<?= h(SITE) ?>">
        </a>
        <ul>
            <li><a href="<?= $this->Url->build('/') ?>"><?= h(__('Home')) ?></a></li>
            <?php if ($this->request->session()->check(SESSION_LOGIN)): ?>
                <li><a href="<?= $this->Url->build(['controller' => 'Mypage', 'action' => 'index']) ?>"><?= h(__('Personal Info')) ?></a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'index']) ?>"><?= h(__('Products')) ?></a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Favourites', 'action' => 'index']) ?>"><?= h(__('My Favourites')) ?></a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'History', 'action' => 'index']) ?>"><?= h(__('History')) ?></a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Charge', 'action' => 'index']) ?>"><?= h(__('Charge Center')) ?></a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Top', 'action' => 'logout']) ?>"><?= h(__('Logout')) ?></a></li>
            <?php else: ?>
                <li><a href="<?= $this->Url->build(['controller' => 'Register']) ?>"><?= h(__('Register')) ?></a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Top', 'action' => 'login']) ?>"><?= h(__('Login')) ?></a></li>
            <?php endif; ?>
            <li>
                <?= $this->Form->create(null, ['url' => ['controller' => 'Products', 'action' => 'search'], 'type' => 'get']) ?>
                    <input name="s" type="text" placeholder="<?= h(__('ASIN')) ?>" />
                    <button type="submit"><?= h(__('search')) ?></button>
                <?= $this->Form->end(); ?>
            </li>
            <li><a href="<?= $this->Url->build(['controller' => 'Cart']) ?>"><?= h(__('Cart')) ?></a></li>
        </ul>
    </div>
</header>

<!--TODO-->
<p>-------------------------------以上为头部标签-------------------------------</p>

<div id="main">
    <?= $this->fetch('navi') ?>

    <?= $this->Flash->render() ?>

    <?= $this->fetch('content') ?>
</div>

<!--TODO-->
<p>-------------------------------以下为底部标签-------------------------------</p>

<footer>
    <div>
        <ul>
            <li>NO Copyright ©2017 No Rights Reserved</li>
            <li><a href="http://www.baidu.com">百度</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Help']) ?>"><?= h(__('Help')) ?></a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Contact']) ?>"><?= h(__('Contact Us')) ?></a></li>
        </ul>
    </div>
</footer>
</body>
</html>