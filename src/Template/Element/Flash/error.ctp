<?php
/**
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<style>
    .error {
        background: red;
        cursor: pointer;
    }
</style>
<div class="message error" onclick="$(this).hide()"><?= $message ?></div>
