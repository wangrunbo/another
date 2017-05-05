<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array $sex
 * @var array $errors
 * @var array $default
 */
if (!isset($default)) {
    $default = [
        'sex' => $user->sex_id,
        'birthday' => [
            'year' => is_null($user->birthday)? '' : $user->birthday->year,
            'month' => is_null($user->birthday)? '' : $user->birthday->month,
            'day' => is_null($user->birthday)? '' : $user->birthday->day
        ]
    ];

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
            <th><?= h(__('sex')) ?></th>
            <td><?= h($user->sex->name) ?></td>
        </tr>
        <tr>
            <th><?= h(__('birthday')) ?></th>
            <td>
                <?= h(is_null($user->birthday)? '' : $user->birthday->format(app_config('Display.format.date'))); ?>
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
                <td>
                    <?= $this->Form->control('name', ['type' => 'text', 'value' => $default['name'], 'data-default' => $user->name]) ?>
                    <?php if (isset($errors['name'])): ?>
                        <?= $this->element('validation', ['field' => 'name', 'error' => $errors['name']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('sex')) ?></th>
                <td>
                    <?= $this->Form->radio('sex', $sex, ['value' => $default['sex'], 'data-default' => $user->sex_id, 'hiddenField' => false, 'required' => false]) ?>
                    <?php if (isset($errors['sex'])): ?>
                        <?= $this->element('validation', ['field' => 'sex', 'error' => $errors['sex']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('birthday')) ?></th>
                <td>
                    <?= $this->Form->control('birthday[year]', ['type' => 'text', 'value' => $default['birthday']['year'], 'data-default' => is_null($user->birthday)? '' : $user->birthday->year, 'placeholder' => __('year')]) ?>
                    <?= $this->Form->control('birthday[month]', ['type' => 'text', 'value' => $default['birthday']['month'], 'data-default' => is_null($user->birthday)? '' : $user->birthday->month, 'placeholder' => __('month')]) ?>
                    <?= $this->Form->control('birthday[day]', ['type' => 'text', 'value' => $default['birthday']['day'], 'data-default' => is_null($user->birthday)? '' : $user->birthday->day, 'placeholder' => __('day')]) ?>
                    <?php if (isset($errors['birthday'])): ?>
                        <?= $this->element('validation', ['field' => 'birthday', 'error' => $errors['birthday']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('postcode')) ?></th>
                <td>
                    <?= $this->Form->control('postcode', ['type' => 'text', 'value' => $default['postcode'], 'data-default' => $user->postcode]) ?>
                    <?php if (isset($errors['postcode'])): ?>
                        <?= $this->element('validation', ['field' => 'postcode', 'error' => $errors['postcode']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('address')) ?></th>
                <td>
                    <?= $this->Form->control('address', ['type' => 'text', 'value' => $default['address'], 'data-default' => $user->address]) ?>
                    <?php if (isset($errors['address'])): ?>
                        <?= $this->element('validation', ['field' => 'address', 'error' => $errors['address']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('tel')) ?></th>
                <td>
                    <?= $this->Form->control('tel', ['type' => 'text', 'value' => $default['tel'], 'data-default' => $user->tel]) ?>
                    <?php if (isset($errors['tel'])): ?>
                        <?= $this->element('validation', ['field' => 'tel', 'error' => $errors['tel']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <button type="submit"><?= h(__('OK')) ?></button>
        <button type="button" onclick="switchMode('view'); resetForm($(this).closest('form')); clearValidationErrors($(this).closest('form'));"><?= h(__('cancel')) ?></button>
    <?= $this->Form->end() ?>
</div>
