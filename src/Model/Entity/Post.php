<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property string $number
 * @property int $delivery_type_id
 * @property int $postage
 * @property string $name
 * @property string $postcode
 * @property string $address
 * @property string $tel
 * @property string $image
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\DeliveryType $delivery_type
 * @property \App\Model\Entity\Administrator $administrator
 * @property \App\Model\Entity\Order $order
 */
class Post extends Entity
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
