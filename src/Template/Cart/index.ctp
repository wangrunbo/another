<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cart[] $cart
 */
$total = 0;
?>
<div>
    <?php foreach ($cart as $item): ?>
        <?php $total += $item->product->price * $item->quantity ?>
        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $item->product->asin]) ?>">
            <img src="<?= $item->product->product_image->main ?>" />
        </a>

        <br />

        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $item->product->asin]) ?>">
            <?= h($item->product->name) ?>
        </a>

        价格：<?= h($item->product->price) ?>

        <?= $this->form($item, ['url' => ['controller' => 'Cart', 'action' => 'quantity']]) ?>
            <p>
                数量：
                <input name="quantity" type="number" value="<?= $item->quantity ?>" min="1" step="1" onchange="initQuantity(this)" title="数量" />
                <button type="submit">变更</button>
            </p>
        <?= $this->endForm(['quantity' => null]) ?>

        <?= $this->form($item, ['url' => ['controller' => 'Cart', 'action' => 'remove']]) ?>
        <p>
            <button type="submit">删除</button>
        </p>
        <?= $this->endForm() ?>
    <?php endforeach; ?>
</div>

<div>
    总价：<?= h($total) ?>
    <?= $this->form(null, ['url' => ['controller' => 'Orders', 'action' => 'checkout']]) ?>
        <button type="submit">前往支付</button>
    <?= $this->endForm() ?>
</div>