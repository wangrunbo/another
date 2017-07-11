<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Administrator Entity
 *
 * @property int $id
 * @property string $password
 * @property string $name
 * @property string $email
 * @property int $sex_id
 * @property \Cake\I18n\Time $birthday
 * @property string $postcode
 * @property string $address
 * @property string $tel
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Sex $sex
 */
class Administrator extends Entity
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
