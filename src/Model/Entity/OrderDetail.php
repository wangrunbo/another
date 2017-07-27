<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * OrderDetail Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $asin
 * @property string $name
 * @property int $price
 * @property string $standard
 * @property string $image
 * @property int $product_type_id
 * @property \Cake\I18n\Time $sale_start_date
 * @property bool $restrict_flg
 * @property string $amazon_order_code
 * @property int $quantity
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\ProductType $product_type
 * @property \App\Model\Entity\Administrator $administrator
 *
 * @property string $product_type_name
 */
class OrderDetail extends Entity
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

    protected function _getProductTypeName()
    {
        return TableRegistry::get('ProductTypes')->get($this->product_type_id)->name;
    }
}
