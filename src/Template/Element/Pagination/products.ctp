<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php if ($this->Paginator->params()): ?>
    <?php $counter = $this->Paginator->counter(); ?>
    <?php if ($this->Paginator->param('pageCount') > 1):?>
        <div>
            <ul>
                <?php if ($this->Paginator->param('prevPage')): ?>
                    <?= $this->Paginator->prev('<<<') ?>
                <?php endif; ?>
                <?= $this->Paginator->numbers() ?>
                <?php if ($this->Paginator->param('nextPage')): ?>
                    <?= $this->Paginator->next('>>>') ?>
                <?php endif; ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    <?php endif; ?>
<?php endif;?>