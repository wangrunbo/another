<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sex Entity
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
class Sex extends Entity
{

    /**
     * 未设定
     */
    const NOT_SET = 1;

    /**
     * 男性
     */
    const MALE = 2;

    /**
     * 女性
     */
    const FEMALE = 3;

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
