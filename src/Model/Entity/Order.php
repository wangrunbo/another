<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $postcode
 * @property string $address
 * @property string $tel
 * @property string $amazon_account
 * @property int $total_price
 * @property int $amazon_postage
 * @property int $delivery_type_id
 * @property int $order_status_id
 * @property \Cake\I18n\Time $finish
 * @property int $post_id
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $updated
 * @property int $modifier_id
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\DeliveryType $delivery_type
 * @property \App\Model\Entity\OrderStatus $order_status
 * @property \App\Model\Entity\Post $post
 * @property \App\Model\Entity\Administrator $administrator
 * @property \App\Model\Entity\OrderDetail[] $order_details
 * @property \App\Model\Entity\PointHistory[] $point_history
 *
 * @property int $postage 运费
 * @property int $total 总价（亚马逊小计 + 亚马逊运费 + 运费）
 */
class Order extends Entity
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

    protected function _getPostage()
    {
        if ($this->isFreeShipping()) {
            $postage = 0;
        } else {
            $Post = TableRegistry::get('Posts')->find('active')->where(['Posts.id' => $this->post_id]);

            if ($Post->isEmpty()) {
                // 商品尚未发送，取默认邮费
                $postage = 0;
            } else {
                $postage = $Post->first()->postage;
            }
        }

        return $postage;
    }

    protected function _getTotal()
    {
        return $this->total_price + $this->postage;
    }

    /**
     * 该交易是否免运费
     *
     * @return bool
     */
    public function isFreeShipping()
    {
        return false;
    }
}
