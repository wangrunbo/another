<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PointHistory Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $point
 * @property int $point_calculation_id
 * @property int $point_type_id
 * @property int $order_id
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\PointCalculation $point_calculation
 * @property \App\Model\Entity\PointType $point_type
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Administrator $administrator
 */
class PointHistory extends Entity
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
