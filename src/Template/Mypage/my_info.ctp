<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array $errors
 * @var array $default
 */
if (!isset($default)) {
    $default = [];

    $this->setStyle('view', ['display' => 'table']);
    $this->setStyle('input', ['display' => 'none']);
} else {
    $this->setStyle('view', ['display' => 'none']);
    $this->setStyle('input', ['display' => 'table']);
}

$this->patchDefault($default, $user->toArray());
?>

<h3>基本信息</h3>
<hr>

<div id="block-view" style="display: <?= $this->getStyle('view.display') ?>;">
    <dl>
        <dt></dt>
    </dl>
</div>

<div id="block-input" style="display: <?= $this->getStyle('input.display') ?>;">
    <dl>
        <dt></dt>
    </dl>
</div>
