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

<h3><?= h(__('Base Info')) ?></h3>
<hr>

<div id="block-view" style="display: <?= $this->getStyle('view.display') ?>;">
    <table>
        <tr>
            <th><?= h(__('name')) ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th><?= h(__('birthday')) ?></th>
            <td>
                <?= h(is_null($user->birthday) ? '' : $user->birthday->format(app_config('Display.format.date'))); ?>
            </td>
        </tr>
        <tr>
            <th><?= h(__('postcode')) ?></th>
            <td><?= h($user->postcode) ?></td>
        </tr>
        <tr>
            <th><?= h(__('address')) ?></th>
            <td><?= h($user->address) ?></td>
        </tr>
        <tr>
            <th><?= h(__('tel')) ?></th>
            <td><?= h($user->tel) ?></td>
        </tr>
    </table>
</div>

<div id="block-input" style="display: <?= $this->getStyle('input.display') ?>;">
    <table>
        <tr>
            <th><?= h(__('name')) ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th><?= h(__('birthday')) ?></th>
            <td>
                <?= h(is_null($user->birthday) ? '' : $user->birthday->format(app_config('Display.format.date'))); ?>
            </td>
        </tr>
        <tr>
            <th><?= h(__('postcode')) ?></th>
            <td><?= h($user->postcode) ?></td>
        </tr>
        <tr>
            <th><?= h(__('address')) ?></th>
            <td><?= h($user->address) ?></td>
        </tr>
        <tr>
            <th><?= h(__('tel')) ?></th>
            <td><?= h($user->tel) ?></td>
        </tr>
    </table>
</div>
