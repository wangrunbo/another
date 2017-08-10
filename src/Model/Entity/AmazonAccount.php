<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AmazonAccount Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int $balance
 * @property int $amazon_account_status_id
 * @property int $creator_id
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 *
 * @property \App\Model\Entity\AmazonAccountStatus $amazon_account_status
 * @property \App\Model\Entity\Administrator $administrator
 */
class AmazonAccount extends Entity
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

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
