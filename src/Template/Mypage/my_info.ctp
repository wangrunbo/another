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

    <button type="button" onclick="switchMode('input')"><?= h(__('edit')) ?></button>
</div>

<div id="block-input" style="display: <?= $this->getStyle('input.display') ?>;">
    <?= $this->Form->create($user) ?>
        <table>
            <tr>
                <th><?= h(__('name')) ?></th>
                <td><?= $this->Form->control('name', ['type' => 'text', 'value' => $default['name'], 'data-value' => $default['name'], 'label' => false]) ?></td>
            </tr>
            <tr>
                <th><?= h(__('birthday')) ?></th>
                <td>
                    <?= $this->Form->control('birthday[year]', ['type' => 'text', 'value' => empty($default['birthday']) ? '' : $default['birthday']->format('Y'), 'data-value' => empty($default['birthday']) ? '' : $default['birthday']->format('Y'), 'placeholder' => __('year'), 'label' => false]) ?>
                    <?= $this->Form->control('birthday[month]', ['type' => 'text', 'value' => empty($default['birthday']) ? '' : $default['birthday']->format('m'), 'data-value' => empty($default['birthday']) ? '' : $default['birthday']->format('m'), 'placeholder' => __('month'), 'label' => false]) ?>
                    <?= $this->Form->control('birthday[day]', ['type' => 'text', 'value' => empty($default['birthday']) ? '' : $default['birthday']->format('d'), 'data-value' => empty($default['birthday']) ? '' : $default['birthday']->format('d'), 'placeholder' => __('day'), 'label' => false]) ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('postcode')) ?></th>
                <td><?= $this->Form->control('postcode', ['type' => 'text', 'value' => $default['postcode'], 'data-value' => $default['postcode'], 'label' => false]) ?></td>
            </tr>
            <tr>
                <th><?= h(__('address')) ?></th>
                <td><?= $this->Form->control('address', ['type' => 'text', 'value' => $default['address'], 'data-value' => $default['address'], 'label' => false]) ?></td>
            </tr>
            <tr>
                <th><?= h(__('tel')) ?></th>
                <td><?= $this->Form->control('tel', ['type' => 'text', 'value' => $default['tel'], 'data-value' => $default['tel'], 'label' => false]) ?></td>
            </tr>
        </table>

        <button type="submit"><?= h(__('OK')) ?></button>
        <button type="button" onclick="switchMode('view'); resetForm($(this).closest('form'));"><?= h(__('cancel')) ?></button>
    <?= $this->Form->end() ?>
</div>
