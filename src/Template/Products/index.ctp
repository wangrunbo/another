<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[] $products
 */
?>
<div>
    <?php foreach ($products as $product): ?>
        <div>
            <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $product->asin]) ?>" target="_blank">
                <img src="<?= @$product->product_image->main ?>" />
            </a>

            <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $product->asin]) ?>" target="_blank">
                <?= $product->name ?>
            </a>
        </div>
    <?php endforeach; ?>

    <?= $this->element('Pagination/products') ?>
</div>