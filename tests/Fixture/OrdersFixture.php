<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 *
 */
class OrdersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK.会员', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '收件人', 'precision' => null, 'fixed' => null],
        'postcode' => ['type' => 'string', 'length' => 6, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '邮编', 'precision' => null, 'fixed' => null],
        'address' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '地址', 'precision' => null],
        'tel' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '联系电话', 'precision' => null, 'fixed' => null],
        'total_price' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'Amazon付款总价（包含运费）', 'precision' => null, 'autoIncrement' => null],
        'amazon_postage' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'Amazon运费', 'precision' => null, 'autoIncrement' => null],
        'delivery_type_id' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK.希望的邮寄方法', 'precision' => null, 'autoIncrement' => null],
        'order_status_id' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => 'FK.交易状态', 'precision' => null, 'autoIncrement' => null],
        'finish' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '交易完成时间', 'precision' => null],
        'post_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK.邮寄信息', 'precision' => null, 'autoIncrement' => null],
        'note' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '备注', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间', 'precision' => null],
        'updated' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间', 'precision' => null],
        'modifier_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'FLG.已删除', 'precision' => null],
        '_indexes' => [
            'modifier_id' => ['type' => 'index', 'columns' => ['modifier_id'], 'length' => []],
            'order_status_id' => ['type' => 'index', 'columns' => ['order_status_id'], 'length' => []],
            'post_id' => ['type' => 'index', 'columns' => ['post_id'], 'length' => []],
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'delivery_type_id' => ['type' => 'index', 'columns' => ['delivery_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'orders_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'orders_ibfk_2' => ['type' => 'foreign', 'columns' => ['modifier_id'], 'references' => ['administrators', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'orders_ibfk_3' => ['type' => 'foreign', 'columns' => ['order_status_id'], 'references' => ['order_statuses', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'orders_ibfk_4' => ['type' => 'foreign', 'columns' => ['post_id'], 'references' => ['posts', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'orders_ibfk_5' => ['type' => 'foreign', 'columns' => ['delivery_type_id'], 'references' => ['delivery_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'user_id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'postcode' => 'Lore',
            'address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'tel' => 'Lorem ipsum dolor ',
            'total_price' => 1,
            'amazon_postage' => 1,
            'delivery_type_id' => 1,
            'order_status_id' => 1,
            'finish' => 1501059728,
            'post_id' => 1,
            'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => 1501059728,
            'updated' => 1501059728,
            'modifier_id' => 1,
            'deleted' => 1501059728
        ],
    ];
}
