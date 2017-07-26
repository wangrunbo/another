<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PointType Entity
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\PointHistory[] $point_history
 */
class PointType extends Entity
{

    const CHARGE = 1;  // 充值
    const ORDER = 2;  // 商品购买
    const POSTAGE = 3;  // 运费
    const POSTAGE_REFUND = 4;  // 运费返金
    const ADMIN_ADJUSTMENT = 5;  // 管理员调控

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
