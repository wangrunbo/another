<?php
/**
 * @var \App\View\AppView $this
 * @var array $divergence
 */
$title = false;
?>
<div>
    <?php foreach ($divergence as $asin => $item): ?>
        <?php if ($item['price'] !== $item['amazon_price']): ?>
            <?php if (!$title): ?>
                <h2>以下商品价格发生变化</h2>
            <?php endif; ?>
            <div>
                asin: <?= $asin ?><br />
                原价：<?= $item['price'] ?><br />
                现价: <?= $item['amazon_price'] ?>
            </div>
            <?php unset($divergence[$asin]) ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php foreach ($divergence as $asin => $item): ?>
        <?php if ($item['price'] !== $item['amazon_price']): ?>
            <?php if (!$title): ?>
                <h2>以下商品在库不足</h2>
            <?php endif; ?>
            <div>
                asin: <?= $asin ?><br />
                原价：<?= $item['price'] ?><br />
                现价: <?= $item['amazon_price'] ?>
            </div>
            <?php unset($divergence[$asin]) ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?= $this->Url->build(['controller' => 'cart', 'action' => 'index']) ?>">返回购物车</a>
    <button type="button">确认购买</button>
</div>
