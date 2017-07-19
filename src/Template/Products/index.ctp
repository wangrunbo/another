<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[] $products
 */
?>
<div>
    <?php foreach ($products as $product): ?>
        <div>
            <img src="<?= @$product->product_image->main ?>" />
            <p>
                <?= $product->name ?>
            </p>
        </div>
    <?php endforeach; ?>

    <?= $this->element('Pagination/products') ?>
</div>