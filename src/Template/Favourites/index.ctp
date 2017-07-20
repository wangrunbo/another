<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Favourite[] $favourites
 */
?>
<div>
    <h2>收藏商品</h2>
    <?php foreach ($favourites as $favourite): ?>
        <div>
            <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $favourite->product->asin]) ?>">
                <img src="<?= $favourite->product->product_image->main ?>" />
            </a>

            <br />

            <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $favourite->product->asin]) ?>">
                <?= $favourite->product->name ?>
            </a>

            <?= $this->form($favourite, ['url' => ['controller' => 'Favourites', 'action' => 'remove']]) ?>
                <button type="submit">取消收藏</button>
            <?= $this->endForm() ?>
        </div>
    <?php endforeach; ?>
</div>
