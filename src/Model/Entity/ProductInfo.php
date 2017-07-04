<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductInfo Entity
 *
 * @property int $id
 * @property int $product_id
 * @property string $label
 * @property string $content
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Administrator $administrator
 */
class ProductInfo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
