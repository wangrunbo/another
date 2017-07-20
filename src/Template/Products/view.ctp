<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var int $quantity
 */
if (!isset($quantity)) {
    $quantity = 1;
}

$this->title($product->name);
$this->Html->script('Products/view', ['block' => true]);
?>
<div>
    <div>
        <ul>
            <?php foreach ($product->product_images as $index => $product_image): ?>
                <div>
                    <img src="<?= $product_image->sub ?>" />
                </div>
            <?php endforeach; ?>
        </ul>

        <div>
        <?php foreach ($product->product_images as $index => $product_image): ?>

                <img src="<?= $product_image->main ?>" />

        <?php endforeach; ?>
        </div>
    </div>

    <div>
        <p>商品名：<?= h($product->name) ?></p>
        <p>ASIN：<?= h($product->asin) ?></p>
        <p>价格：<?= h($product->price) ?>日元</p>
        <p>商品类型：<?= h($product->product_type->name) ?></p>

        <?php if (!is_null($product->sale_start_date)): ?>
            <p>开始贩卖日：<?= h($product->sale_start_date->format(app_config('Display.format.date'))) ?></p>
        <?php endif; ?>

        <?php if (!is_null($product->standard)): ?>
            <p><?= $product->standard ?></p>
        <?php endif; ?>

        <?php if (!empty($product->product_info)): ?>
            <hr />
            商品信息：<br />
            <?php foreach ($product->grouped_info as $info_type => $info_details): ?>
                <?= $info_type ?>
                <table>
                    <?php foreach ($info_details as $product_info): ?>
                        <tr>
                            <th><?= $product_info->label ?></th>
                            <td><?= $product_info->content ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!is_null($product->description)): ?>
            <hr />
            商品介绍：<br />
            <?= $product->description ?>
        <?php endif; ?>

        <?php if (!is_null($product->introduction)): ?>
            <hr />
            推荐：<?= $product->introduction ?>
        <?php endif; ?>
    </div>

    <div>
        <?= $this->form(null, ['url' => ['controller' => 'Cart', 'action' => 'add']]) ?>
            <input name="asin" type="hidden" value="<?= $product->asin ?>" />
            数量：
            <input name="quantity" type="number" value="<?= $quantity ?>" min="1" step="1" onchange="initQuantity(this)" title="数量" />
            <button type="submit">加入购物车</button>
        <?= $this->endForm(['asin' => $product->asin, 'quantity' => null]) ?>
    </div>

    <div>
        <a href="<?= $this->Url->build(['controller' => 'Favourites', 'action' => 'add', '?' => ['asin' => $product->asin]]) ?>" <?php if ($product->isFavourite()): ?>onclick="return false;"<?php endif; ?>>
            加入收藏
        </a>
    </div>

    <hr />

    <a href="<?= AMAZON_PRODUCT_PAGE_1.$product->asin.AMAZON_PRODUCT_PAGE_2 ?>" target="_blank">去Amazon确认</a>
</div>