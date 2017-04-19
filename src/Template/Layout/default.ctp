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
        <?= h($this->fetch('title')) ?>
    </title>

    <link rel="shortcut icon" href="">
    <?= $this->Html->css('main.css') ?>
    <?= $this->fetch('css') ?>

    <?= $this->Html->script('https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js') ?>
    <?= $this->Html->script('main') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
<header id="header">
    <div>
        <a href="http://61.152.73.26/HD/another/me.html">
            <img src="<?= $this->Url->image('logo.png') ?>" alt="<?= h(SITE) ?>" height="60px" title="<?= h(SITE) ?>">
        </a>
        <ul>
            <li><a href="<?= $this->Url->build('/') ?>" title="首页">首页</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Register', 'action' => 'index']) ?>" title="注册">注册</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Top', 'action' => 'login']) ?>" title="登录">登录</a></li>
        </ul>
    </div>
</header>

<div id="main">
    <?= $this->Flash->render() ?>

    <?= $this->fetch('content') ?>
</div>

<footer>
    <div>
        <ul>
            <li>NO Copyright ©2017 No Rights Reserved</li>
            <li><a href="http://www.baidu.com">百度</a></li>
        </ul>
    </div>
</footer>
</body>
</html>
