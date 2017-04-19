<?php
/**
 * @var \App\View\AppView $this
 * @var string $field
 * @var string $message
 */
?>
<?php if (!empty($message)): ?>
    <p class="validation-error" id="<?= h("validation-$field") ?>"><?= h($message) ?></p>
<?php endif; ?>
