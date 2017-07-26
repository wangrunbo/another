<?php
/**
 * @var \App\View\AppView $this
 * @var App\Model\Entity\Order[] $orders
 */
?>
<div>
    <?php foreach ($orders as $order): ?>
        <?= h($order->finish->format(app_config('Display.format.date'))) ?>
        <div>
            <h4>地址：</h4>
            <?= h($order->name) ?><br />
            <?= h($order->postcode) ?><br />
            <?= h($order->address) ?><br />
            <?= h($order->tel) ?>
        </div>

        <div>
            <h4>交易信息：</h4>
            小计：<?= h(price($order->total_price)) ?>
            运费：<?= h(price($order->postage)) ?>
            合计：<?= h(price($order->total)) ?>
        </div>

        <div>
            <h4>详细</h4>
            <div>
                <?php ($order->order_details) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
