<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Address[] $addresses
 * @var int $target
 * @var array $errors
 * @var array $default
 */
if (count($addresses) === 0 || (isset($default) && !isset($target))) {
    $this->setStyle('address_new.input', ['display' => 'table']);
} else {
    $this->setStyle('address_new.input', ['display' => 'none']);
}
?>
<h3><?= h(__('Addresses')) ?></h3>
<hr>

<div id="block-address_new">
    <?php if (count($addresses) !== 0): ?>
        <div class="block-view" style="display: table;">
            <button type="button" onclick="switchMode('input', $('#block-address_new'));"><?= h(__('New')) ?></button>
        </div>
    <?php endif; ?>

    <div class="block-input" style="display: <?= $this->getStyle('address_new.input.display') ?>;">
        <?= $this->Form->create() ?>
            <table>
                <tr>
                    <th><?= h(__('label')) ?></th>
                    <td>
                        <?= $this->Form->control('label', ['type' => 'text', 'value' => isset($default) && !isset($target)? $default['label'] : __('new address'), 'data-default' => __('new address')]) ?>
                        <?php if (isset($errors['label']) && !isset($target)): ?>
                            <?= $this->element('validation', ['field' => 'label', 'error' => $errors['label']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= h(__('name')) ?></th>
                    <td>
                        <?= $this->Form->control('name', ['type' => 'text', 'value' => isset($default) && !isset($target)? $default['name'] : '', 'data-default' => '']) ?>
                        <?php if (isset($errors['name']) && !isset($target)): ?>
                            <?= $this->element('validation', ['field' => 'name', 'error' => $errors['name']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= h(__('postcode')) ?></th>
                    <td>
                        <?= $this->Form->control('postcode', ['type' => 'text', 'value' => isset($default) && !isset($target)? $default['postcode'] : '', 'data-default' => '']) ?>
                        <?php if (isset($errors['postcode']) && !isset($target)): ?>
                            <?= $this->element('validation', ['field' => 'postcode', 'error' => $errors['postcode']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= h(__('address')) ?></th>
                    <td>
                        <?= $this->Form->control('address', ['type' => 'text', 'value' => isset($default) && !isset($target)? $default['address'] : '', 'data-default' => '']) ?>
                        <?php if (isset($errors['address']) && !isset($target)): ?>
                            <?= $this->element('validation', ['field' => 'address', 'error' => $errors['address']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= h(__('tel')) ?></th>
                    <td>
                        <?= $this->Form->control('tel', ['type' => 'text', 'value' => isset($default) && !isset($target)? $default['tel'] : '', 'data-default' => '']) ?>
                        <?php if (isset($errors['tel']) && !isset($target)): ?>
                            <?= $this->element('validation', ['field' => 'tel', 'error' => $errors['tel']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <button type="submit"><?= h(__('OK')) ?></button>
            <?php if (count($addresses) !== 0): ?>
                <button type="button" onclick="switchMode('view', $('#block-address_new')); resetForm($(this).closest('form')); clearValidationErrors($(this).closest('form'));"><?= h(__('Cancel')) ?></button>
            <?php endif; ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php foreach ($addresses as $address): ?>
    <hr />
    <div id="block-address_<?= $address->id ?>">
        <div class="block-view" style="display: <?= isset($target) && $address->id === $target? 'none' : 'table' ?>;">
            <table>
                <tr>
                    <th colspan="2"><?= h($address->label) ?></th>
                </tr>
                <tr>
                    <th><?= h(__('name')) ?></th>
                    <td><?= h($address->name) ?></td>
                </tr>
                <tr>
                    <th><?= h(__('postcode')) ?></th>
                    <td><?= h($address->postcode) ?></td>
                </tr>
                <tr>
                    <th><?= h(__('address')) ?></th>
                    <td><?= h($address->address) ?></td>
                </tr>
                <tr>
                    <th><?= h(__('tel')) ?></th>
                    <td><?= h($address->tel) ?></td>
                </tr>
            </table>

            <button type="button" onclick="switchMode('input', $('#block-address_<?= $address->id ?>'));"><?= h(__('Edit')) ?></button>
            <?= $this->Form->create($address, ['url' => ['controller' => 'Mypage', 'action' => 'deleteAddress']]) ?>
                <button type="submit"><?= h(__('Delete')) ?></button>
            <?= $this->Form->end() ?>
        </div>

        <div class="block-input" style="display: <?= isset($target) && $address->id === $target? 'table' : 'none' ?>;">
            <?= $this->Form->create($address, ['url' => ['controller' => 'Mypage', 'action' => 'myAddresses']]) ?>
                <table>
                    <tr>
                        <th><?= h(__('label')) ?></th>
                        <td>
                            <?= $this->Form->control('label', ['type' => 'text', 'value' => isset($target) && $address->id === $target? $default['label'] : $address->label, 'data-default' => $address->label]) ?>
                            <?php if (isset($errors['label']) && isset($target) && $address->id === $target): ?>
                                <?= $this->element('validation', ['field' => 'label', 'error' => $errors['label']]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= h(__('name')) ?></th>
                        <td>
                            <?= $this->Form->control('name', ['type' => 'text', 'value' => isset($target) && $address->id === $target? $default['name'] : $address->name, 'data-default' => $address->name]) ?>
                            <?php if (isset($errors['name']) && isset($target) && $address->id === $target): ?>
                                <?= $this->element('validation', ['field' => 'name', 'error' => $errors['name']]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= h(__('postcode')) ?></th>
                        <td>
                            <?= $this->Form->control('postcode', ['type' => 'text', 'value' => isset($target) && $address->id === $target? $default['postcode'] : $address->postcode, 'data-default' => $address->postcode]) ?>
                            <?php if (isset($errors['postcode']) && isset($target) && $address->id === $target): ?>
                                <?= $this->element('validation', ['field' => 'postcode', 'error' => $errors['postcode']]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= h(__('address')) ?></th>
                        <td>
                            <?= $this->Form->control('address', ['type' => 'text', 'value' => isset($target) && $address->id === $target? $default['address'] : $address->address, 'data-default' => $address->address]) ?>
                            <?php if (isset($errors['address']) && isset($target) && $address->id === $target): ?>
                                <?= $this->element('validation', ['field' => 'address', 'error' => $errors['address']]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= h(__('tel')) ?></th>
                        <td>
                            <?= $this->Form->control('tel', ['type' => 'text', 'value' => isset($target) && $address->id === $target? $default['tel'] : $address->tel, 'data-default' => $address->tel]) ?>
                            <?php if (isset($errors['tel']) && isset($target) && $address->id === $target): ?>
                                <?= $this->element('validation', ['field' => 'tel', 'error' => $errors['tel']]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <button type="submit"><?= h(__('OK')) ?></button>
                <button type="button" onclick="switchMode('view', $('#block-address_<?= $address->id ?>')); resetForm($(this).closest('form')); clearValidationErrors($(this).closest('form'));"><?= h(__('Cancel')) ?></button>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php endforeach; ?>
