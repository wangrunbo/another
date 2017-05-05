<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $secret
 * @property string $name
 * @property int $sex_id
 * @property \Cake\I18n\Time $birthday
 * @property string $postcode
 * @property string $address
 * @property string $tel
 * @property int $account_status_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 *
 * @property \App\Model\Entity\Sex $sex
 * @property \App\Model\Entity\AccountStatus $account_status
 * @property \App\Model\Entity\Address[] $addresses
 */
class User extends Entity
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
        'password',
        'secret'
    ];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    public function updateSecret()
    {
        while (true) {
            $this->secret = random();

            if (TableRegistry::get($this->getSource())->find()->where(['secret' => $this->secret])->isEmpty()) {
                break;
            }
        }

        return $this;
    }
}
