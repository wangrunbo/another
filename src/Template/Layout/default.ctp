<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE HTML>
<html>
<head>
    <?= $this->Html->charset() ?>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <meta name=keywords content="晖尽, Fatego, 动漫" >
    <meta name=description content="欢迎来到晖尽的个人空间，喜欢的游戏是魔兽世界与Fatego，喜欢的动漫是空之境界。">
    <link rel="icon" href="<?= $this->Url->image('favicon.ico') ?>">
    <?= $this->fetch('meta') ?>

    <title>
        <?= h(SITE) ?>
        &nbsp;|&nbsp;
        <?= h($this->title()) ?>
    </title>

    <!--[if lte IE 8]><?= $this->Html->css('ie8') ?><![endif]-->
    <!--[if lte IE 9]><?= $this->Html->css('ie9') ?><![endif]-->
    <?= $this->Html->css('main') ?>
    <?= $this->Html->css('style') ?>
    <?= $this->fetch('css') ?>

    <?= $this->Html->script('../lib/jquery.min.js') ?>
    <?= $this->Html->script('Layout/skel.min.js') ?>
    <?= $this->Html->script('Layout/util.js') ?>
    <!--[if lte IE 8]><?= $this->Html->script('Layout/ie/respond.min.js') ?><![endif]-->
    <?= $this->Html->script('Layout/main.js') ?>

    <?= $this->Html->script('script') ?>
    <?= $this->fetch('script') ?>
</head>

<body>

<div id="wrapper">
    <div id="main">
        <div class="inner">
            <header id="header">
                <a href="<?= $this->Url->build('/') ?>" class="logo"><strong>Another</strong>欢迎访问</a>
                <ul class="icons">
                    <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="#" class="icon fa-snapchat-ghost"><span class="label">Snapchat</span></a></li>
                    <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                    <li><a href="#" class="icon fa-medium"><span class="label">Medium</span></a></li>
                </ul>
            </header>

            <?= $this->fetch('navi') ?>

            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>

        </div>
    </div>

    <div id="sidebar">
        <div class="inner">

            <section id="search" class="alt">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Products', 'action' => 'search'], 'type' => 'get']) ?>
                <input id="query" name="s" type="text" placeholder="<?= h(__('ASIN')) ?>" />
                <button class="button special small" type="submit"><?= h(__('search')) ?></button>
                <?= $this->Form->end(); ?>
            </section>

            <nav id="menu">
                <header class="major">
                    <h2>会员</h2>
                </header>
                <ul>
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
                </ul>
            </nav>

            <!-- TODO -->
            <nav id="menu">
                <header class="major">
                    <h2>Menu</h2>
                </header>
                <ul>
                    <li><a href="index.html">Homepage</a></li>
                    <li><a href="generic.html">Generic</a></li>
                    <li><a href="elements.html">Elements</a></li>
                    <li>
                        <span class="opener">Submenu</span>
                        <ul>
                            <li><a href="#">Lorem Dolor</a></li>
                            <li><a href="#">Ipsum Adipiscing</a></li>
                            <li><a href="#">Tempus Magna</a></li>
                            <li><a href="#">Feugiat Veroeros</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Etiam Dolore</a></li>
                    <li><a href="#">Adipiscing</a></li>
                    <li>
                        <span class="opener">Another Submenu</span>
                        <ul>
                            <li><a href="#">Lorem Dolor</a></li>
                            <li><a href="#">Ipsum Adipiscing</a></li>
                            <li><a href="#">Tempus Magna</a></li>
                            <li><a href="#">Feugiat Veroeros</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Maximus Erat</a></li>
                    <li><a href="#">Sapien Mauris</a></li>
                    <li><a href="#">测试字体  Amet Lacinia</a></li>
                </ul>
            </nav>

            <!-- TODO -->
            <section>
                <header class="major">
                    <h2>Ante interdum</h2>
                </header>
                <div class="mini-posts">
                    <article>
                        <a href="#" class="image"><img src="<?= $this->Url->image('pic07.jpg') ?>" alt="" /></a>
                        <p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
                    </article>
                    <article>
                        <a href="#" class="image"><img src="<?= $this->Url->image('pic08.jpg') ?>" alt="" /></a>
                        <p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
                    </article>
                    <article>
                        <a href="#" class="image"><img src="<?= $this->Url->image('pic09.jpg') ?>" alt="" /></a>
                        <p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
                    </article>
                </div>
                <ul class="actions">
                    <li><a href="#" class="button">More</a></li>
                </ul>
            </section>

            <!-- TODO -->
            <section>
                <header class="major">
                    <h2>Get in touch</h2>
                </header>
                <p>Sed varius enim lorem ullamcorper dolore aliquam aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin sed aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
                <ul class="contact">
                    <li class="fa-envelope-o"><a href="#">information@untitled.tld</a></li>
                    <li class="fa-phone">(000) 000-0000</li>
                    <li class="fa-home">1234 Somewhere Road #8254<br />
                        Nashville, TN 00000-0000</li>
                </ul>
            </section>

            <footer id="footer">
                <ul>
                    <li><a href="http://www.baidu.com">百度</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Help']) ?>"><?= h(__('Help')) ?></a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Contact']) ?>"><?= h(__('Contact Us')) ?></a></li>
                </ul>
                <p class="copyright">&copy; Untitled. All rights reserved. Demo Images: <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
            </footer>

        </div>
    </div>

</div>
</body>
</html>