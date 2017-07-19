<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property int $id
 * @property string $uid
 * @property string $username
 * @property string $email
 * @property string $target_email
 * @property string $password
 * @property string $secret_key
 * @property string $tel_cert_code
 * @property string $name
 * @property int $sex_id
 * @property \Cake\I18n\Time $birthday
 * @property string $postcode
 * @property string $address
 * @property string $tel
 * @property int $user_status_id
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 *
 * @property \App\Model\Entity\Sex $sex
 * @property \App\Model\Entity\UserStatus $user_status
 * @property \App\Model\Entity\Administrator $administrator
 * @property \App\Model\Entity\Address[] $addresses
 * @property \App\Model\Entity\Cart[] $cart
 * @property \App\Model\Entity\Favourite[] $favourites
 * @property \App\Model\Entity\LoginHistory[] $login_history
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\PointHistory[] $point_history
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

    protected function _setPasswordConfirm($password_confirm)
    {
        return (new DefaultPasswordHasher)->hash($password_confirm);
    }

    public function updateSecretKey()
    {
        do {
            $this->secret_key = random();
        } while (!TableRegistry::get($this->getSource())->find()->where(['secret_key' => $this->secret_key])->isEmpty());

        return $this;
    }

    public function generateUid()
    {
        if ($this->isNew()) {
            do {
                $this->uid = random(12, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
            } while (!TableRegistry::get($this->getSource())->find()->where(['uid' => $this->uid])->isEmpty());
        }

        return $this;
    }
}
