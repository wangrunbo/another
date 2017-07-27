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
                <?php foreach ($order->order_details as $order_detail): ?>
                    <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'search', '?' => ['asin' => $order_detail->asin]]) ?>">
                        <img src="<?= $order_detail->image ?>" />
                    </a>
                    <br />
                    <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'search', '?' => ['asin' => $order_detail->asin]]) ?>">
                        <?= h($order_detail->name) ?>
                    </a>
                    <br />
                    <?= h($order_detail->product_type_name) ?><br />
                    <?php if (!is_null($order_detail->standard)): ?>
                        <?= h($order_detail->standard) ?><br />
                    <?php endif; ?>
                    价格：<?= h(price($order_detail->price)) ?> 日元<br />
                    数量：<?= h(price($order_detail->quantity)) ?><br />
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
