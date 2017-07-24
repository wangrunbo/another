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
        <?= h($order_detail->price) ?><br />
        <?= h($order_detail->standard) ?><br />
        <?= h($order_detail->product_type) ?><br />
        <?php if (!is_null($order_detail->sale_start_date)): ?>
            开始贩卖日：<?= h($order_detail->sale_start_date->format(app_config('Display.format.date'))) ?>
        <?php endif; ?>
        <hr />
    <?php endforeach; ?>
</div>