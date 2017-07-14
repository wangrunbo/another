<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $asin
 * @property string $name
 * @property int $price
 * @property string $standard
 * @property int $product_type_id
 * @property \Cake\I18n\Time $sale_start_date
 * @property bool $stock_flg
 * @property string $description
 * @property string $introduction
 * @property int $searcher_id
 * @property int $creator_id
 * @property bool $blacklist_flg
 * @property int $bought_times
 * @property int $searched_times
 * @property bool $restrict_flg
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\ProductType $product_type
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Administrator $administrator
 * @property \App\Model\Entity\Cart[] $cart
 * @property \App\Model\Entity\Favourite[] $favourites
 * @property \App\Model\Entity\OrderDetail[] $order_details
 * @property \App\Model\Entity\ProductImage[] $product_images
 * @property \App\Model\Entity\ProductInfo[] $product_info
 *
 * @property array $grouped_info
 */
class Product extends Entity
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

    /**
     * 将商品情报以商品情报类型进行分组
     */
    protected function _getGroupedInfo()
    {
        if (!$this->has('product_info')) {
            TableRegistry::get('Products')->loadInto($this, ['ProductInfo']);
        }

        $info = [];
        foreach ($this->product_info as $product_info) {
            if (!array_key_exists($product_info->type, $info)) {
                $info[$product_info->type] = [];
            }

            $info[$product_info->type][] = $product_info;
        }

        return $info;
    }
}
