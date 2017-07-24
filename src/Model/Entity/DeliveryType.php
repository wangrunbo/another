<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryType Entity
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Post[] $posts
 */
class DeliveryType extends Entity
{

    const EMS = 1;  // EMS
    const AIR = 2;  // 空运
    const SAL = 3;  // SAL
    const SEA = 4;  // 海运

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
