<?php
/**
 * @var \App\View\AppView $this
 */
$this->title('交易失败');
$this->Html->script('Orders/exception', ['block' => true]);
?>
<div>
    <p>该交易已过期</p>
    <p>将在<span id="counter"><?= h(REDIRECT_COUNTER) ?></span>秒后返回购物车</p>
    <p>如果页面没有自动跳转，请<a href="<?= $this->Url->build(['controller' => 'Cart', 'action' => 'index']) ?>" id="link-cart">点击这里</a></p>
</div>