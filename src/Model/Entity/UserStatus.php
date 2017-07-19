<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserStatus Entity
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\User[] $users
 */
class UserStatus extends Entity
{

    /**
     * 未激活
     */
    const STATUS_INACTIVE = 1;

    /**
     * 一般会员
     */
    const STATUS_GENERAL = 2;

    /**
     * 锁定
     */
    const STATUS_LOCKED = 3;

    /**
     * 删除
     */
    const STATUS_DELETED = 4;


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
