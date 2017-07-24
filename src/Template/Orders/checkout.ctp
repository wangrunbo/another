<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Address[] $addresses
 * @var array $delivery_types
 * @var array $default
 */
if (!isset($default)) {
    $default = ['delivery' => \App\Model\Entity\DeliveryType::EMS];
}
?>
<?= $this->form() ?>
    <div>
        <h4>地址选择</h4>
        <div>
            <input name="selected" type="hidden" value="0" />
            <?php foreach ($addresses as $address): ?>
                <div>
                    <label for="address-<?= $address->id ?>">
                        <input id="address-<?= $address->id ?>" name="selected" type="radio" value="<?= $address->id ?>" />
                        <?= h($address->label) ?>
                    </label>
                    <div>
                        <?= h($address->name) ?><br />
                        <?= h($address->postcode) ?> <?= h($address->address) ?><br />
                        <?= h($address->tel) ?>
                    </div>
                </div>
                <hr />
            <?php endforeach; ?>
        </div>

        <div>
            <table>
                <tr>
                    <th><?= h(__('name')) ?></th>
                    <td>
                        <input name="name" type="text" value="<?= @$default['name'] ?>" title="<?= __('name') ?>" />
                        <?php if (isset($errors['name'])): ?>
                            <?= $this->element('validation', ['field' => 'name', 'error' => $errors['name']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= h(__('postcode')) ?></th>
                    <td>
                        <input name="postcode" type="text" value="<?= @$default['postcode'] ?>" title="<?= __('postcode') ?>" />
                        <?php if (isset($errors['postcode'])): ?>
                            <?= $this->element('validation', ['field' => 'postcode', 'error' => $errors['postcode']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= h(__('address')) ?></th>
                    <td>
                        <input name="address" type="text" value="<?= @$default['address'] ?>" title="<?= __('address') ?>" />
                        <?php if (isset($errors['address'])): ?>
                            <?= $this->element('validation', ['field' => 'address', 'error' => $errors['address']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= h(__('tel')) ?></th>
                    <td>
                        <input name="tel" type="text" value="<?= @$default['tel'] ?>" title="<?= __('tel') ?>" />
                        <?php if (isset($errors['tel'])): ?>
                            <?= $this->element('validation', ['field' => 'tel', 'error' => $errors['tel']]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div>
        <h4>邮寄方式</h4>
        <?php foreach ($delivery_types as $id => $name): ?>
            <label for="delivery-<?= $id ?>">
                <input id="delivery-<?= $id ?>" name="delivery" type="radio" value="<?= $id ?>" <?php if ($id === (int)$default['delivery']): ?>checked<?php endif; ?> />
                <?= h($name) ?>
            </label>
        <?php endforeach; ?>
    </div>

    <button type="submit">下一步</button>
    <a href="<?= $this->Url->build(['controller' => 'Cart', 'action' => 'index']) ?>">返回购物车</a>
<?= $this->endForm(['selected' => null, 'name' => null, 'postcode' => null, 'address' => null, 'tel' => null, 'delivery' => null]) ?>