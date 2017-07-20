<?php
/**
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<style>
    .success {
        background: greenyellow;
        cursor: pointer;
    }
</style>
<div class="message success" onclick="$(this).hide()"><?= $message ?></div>
