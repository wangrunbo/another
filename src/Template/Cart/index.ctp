<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cart[] $cart
 */
?>
<div>
    <?php foreach ($cart as $item): ?>
        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $item->product->asin]) ?>">
            <img src="<?= $item->product->product_image->main ?>" />
        </a>

        <br />

        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $item->product->asin]) ?>">
            <?= $item->product->name ?>
        </a>

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