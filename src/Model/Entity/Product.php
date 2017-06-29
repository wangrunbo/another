<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $asin
 * @property string $name
 * @property int $price
 * @property string $standard
 * @property string $image
 * @property int $product_type_id
 * @property \Cake\I18n\Time $sale_start_date
 * @property bool $stock_flg
 * @property string $info
 * @property string $description
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
}
