<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoginHistory Entity
 *
 * @property int $id
 * @property int $user_id
 * @property \Cake\I18n\Time $time
 * @property string $ip
 * @property string $os
 * @property string $browser
 * @property string $language
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Administrator $administrator
 */
class LoginHistory extends Entity
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
        'user_agent'
    ];
}
