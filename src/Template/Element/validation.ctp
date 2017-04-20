<?php
/**
 * @var \App\View\AppView $this
 * @var string $field
 * @var array $error
 */
?>
<?php if (!empty($error)): ?>
    <?php foreach ($error as $message): ?>
        <p class="validation-error" id="<?= h("validation-$field") ?>"><?= h($message) ?></p>
    <?php endforeach; ?>
<?php endif; ?>
