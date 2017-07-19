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

    $this->patchDefault($default, $user->toArray());

    $this->setStyle('view', ['display' => 'table']);
    $this->setStyle('input', ['display' => 'none']);
} else {
    $this->setStyle('view', ['display' => 'none']);
    $this->setStyle('input', ['display' => 'table']);
}
?>
<h3><?= h(__('Base Info')) ?></h3>
<hr />

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

    <button type="button" onclick="switchMode('input')"><?= h(__('Edit')) ?></button>
</div>

<div id="block-input" style="display: <?= $this->getStyle('input.display') ?>;">
    <?= $this->form($user) ?>
        <table>
            <tr>
                <th><?= h(__('name')) ?></th>
                <td>
                    <input name="name" type="text" value="<?= $default['name'] ?>" data-default="<?= $user->name ?>" title="<?= __('name') ?>" />
                    <?php if (isset($errors['name'])): ?>
                        <?= $this->element('validation', ['field' => 'name', 'error' => $errors['name']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('sex')) ?></th>
                <td>
                    <?php foreach ($sex as $id => $name): ?>
                        <label for="sex-<?= $id ?>">
                            <input id="sex-<?= $id ?>" name="sex" type="radio" value="<?= $id ?>" data-default="<?= $user->sex_id ?>" <?php if ($id === (int)$default['sex']): ?>checked="checked"<?php endif; ?> />
                            <?= h($name) ?>
                        </label>
                    <?php endforeach; ?>
                    <?php if (isset($errors['sex_id'])): ?>
                        <?= $this->element('validation', ['field' => 'sex', 'error' => $errors['sex_id']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('birthday')) ?></th>
                <td>
                    <input name="birthday[year]" type="text" value="<?= $default['birthday']['year'] ?>" placeholder="<?= __('year') ?>" data-default="<?= is_null($user->birthday)? '' : $user->birthday->year ?>" title="<?= __('year') ?>" />
                    <input name="birthday[month]" type="text" value="<?= $default['birthday']['month'] ?>" placeholder="<?= __('month') ?>" data-default="<?= is_null($user->birthday)? '' : $user->birthday->month ?>" title="<?= __('month') ?>" />
                    <input name="birthday[day]" type="text" value="<?= $default['birthday']['day'] ?>" placeholder="<?= __('day') ?>" data-default="<?= is_null($user->birthday)? '' : $user->birthday->day ?>" title="<?= __('day') ?>" />
                    <?php if (isset($errors['birthday'])): ?>
                        <?= $this->element('validation', ['field' => 'birthday', 'error' => $errors['birthday']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('postcode')) ?></th>
                <td>
                    <input name="postcode" type="text" value="<?= $default['postcode'] ?>" data-default="<?= $user->postcode ?>" title="<?= __('postcode') ?>" />
                    <?php if (isset($errors['postcode'])): ?>
                        <?= $this->element('validation', ['field' => 'postcode', 'error' => $errors['postcode']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('address')) ?></th>
                <td>
                    <input name="address" type="text" value="<?= $default['address'] ?>" data-default="<?= $user->address ?>" title="<?= __('address') ?>" />
                    <?php if (isset($errors['address'])): ?>
                        <?= $this->element('validation', ['field' => 'address', 'error' => $errors['address']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= h(__('tel')) ?></th>
                <td>
                    <input name="tel" type="text" value="<?= $default['tel'] ?>" data-default="<?= $user->tel ?>" title="<?= __('tel') ?>" />
                    <?php if (isset($errors['tel'])): ?>
                        <?= $this->element('validation', ['field' => 'tel', 'error' => $errors['tel']]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <button type="submit"><?= h(__('OK')) ?></button>
        <button type="button" onclick="switchMode('view'); resetForm($(this).closest('form')); clearValidationErrors($(this).closest('form'));"><?= h(__('Cancel')) ?></button>
    <?= $this->endForm(['name' => null, 'sex' => null, 'birthday.year' => null, 'birthday.month' => null, 'birthday.day' => null, 'postcode' => null, 'address' => null, 'tel' => null]) ?>
</div>
