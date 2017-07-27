<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div>
    <?php foreach ($order->order_details as $order_detail): ?>
        <img src="<?= $order_detail->image ?>" />
        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $order_detail->asin]) ?>">
            <?= h($order_detail->name) ?>
        </a>
        <br />
        <?= h(price($order_detail->price)) ?> 日元<br />
        数量：<?= h($order_detail->quantity) ?><br />
        <?= h($order_detail->standard) ?><br />
        <?= h($order_detail->product_type_name) ?><br />
        <?php if (!is_null($order_detail->sale_start_date)): ?>
            开始贩卖日：<?= h($order_detail->sale_start_date->format(app_config('Display.format.date'))) ?>
        <?php endif; ?>
        <hr />
    <?php endforeach; ?>

    <div>
        小计；<?= h(price($order->total_price - $order->amazon_postage)) ?>
        运费；<?= h(price($order->amazon_postage + 0)) ?> <!-- TODO 运费 -->
        合计；<?= h(price($order->total)) ?>
    </div>

    <?= $this->form($order, ['url' => ['controller' => 'Orders', 'action' => 'buy']]) ?>
        <button type="submit">确认支付</button>
        <a href="<?= $this->Url->build(['controller' => 'Cart', 'action' => 'index']) ?>">返回购物车</a>
    <?= $this->endForm() ?>
</div>