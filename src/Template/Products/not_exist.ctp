<?php
/**
 * @var \App\View\AppView $this
 * @var string $asin
 */
?>
<div>
    <p>商品未找到</p>
    <p>请<a href="<?= AMAZON_HOME_PAGE ?>" target="_blank">前往Amazon</a>进行确认</p>
    <button type="button">向管理员报告</button>
    <a href="<?= $this->Url->build('/') ?>">返回首页</a>
</div>