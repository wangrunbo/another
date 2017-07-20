<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $postcode
 * @property string $address
 * @property string $tel
 * @property int $total_price
 * @property int $amazon_postage
 * @property int $order_status_id
 * @property int $post_id
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\OrderStatus $order_status
 * @property \App\Model\Entity\Post $post
 * @property \App\Model\Entity\Administrator $administrator
 * @property \App\Model\Entity\OrderDetail[] $order_details
 * @property \App\Model\Entity\PointHistory[] $point_history
 */
class Order extends Entity
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
