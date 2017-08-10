<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AmazonAccountStatus Entity
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\AmazonAccount[] $amazon_accounts
 */
class AmazonAccountStatus extends Entity
{

    const STOPPED = 1;  // 停止
    const IDLE = 2;  // 未使用
    const USING = 3;  // 使用中
    const ERROR = 4;  // 错误

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
