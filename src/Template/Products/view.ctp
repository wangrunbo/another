<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div>
    <div>
        <?php foreach ($product->product_images as $product_image): ?>
            <div>
                <img src="<?= $product_image->sub ?>" />
            </div>

            <div>
                <img src="<?= $product_image->main ?>" />
            </div>
        <?php endforeach; ?>
    </div>

    <div>
        商品名：<?= $product->name ?>
        ASIN：<?= $product->asin ?>
        价格：<?= $product->price ?>日元

        <?php if (!is_null($product->standard)): ?>
            <?= $product->standard ?>
        <?php endif; ?>

        <?php if (!empty($product->product_info)): ?>
            商品信息：
            <table>
                <?php foreach ($product->product_info as $product_info): ?>
                    <tr>
                        <th><?= $product_info->label ?></th>
                        <td><?= $product_info->content ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <?php if (!is_null($product->description)): ?>
            商品介绍：<?= $product->description ?>
        <?php endif; ?>

        <?php if (!is_null($product->introduction)): ?>
            推荐：<?= $product->introduction ?>
        <?php endif; ?>
    </div>

    <a href="<?= AMAZON_PRODUCT_PAGE_1.$product->asin.AMAZON_PRODUCT_PAGE_2 ?>">去Amazon确认</a>
</div>