<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderStatus Entity
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Order[] $orders
 */
class OrderStatus extends Entity
{

    const CASHING = 1;  // 未支付
    const FINISH = 2;  // 交易完成
    const FAIL = 3;  // 交易失败
    const TIME_OUT = 4;  // 交易超时

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
