<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderDetailsFixture
 *
 */
class OrderDetailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'order_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK.交易信息', 'precision' => null, 'autoIncrement' => null],
        'product_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK.商品信息', 'precision' => null, 'autoIncrement' => null],
        'asin' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'ASIN code', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '商品名', 'precision' => null, 'fixed' => null],
        'price' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '商品Amazon价格', 'precision' => null, 'autoIncrement' => null],
        'standard' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '商品规格', 'precision' => null],
        'image' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '商品图片', 'precision' => null],
        'product_type_id' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK.商品类型', 'precision' => null, 'autoIncrement' => null],
        'sale_start_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '贩卖开始日期', 'precision' => null],
        'restrict_flg' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => 'FLG.成人商品', 'precision' => null],
        'amazon_order_code' => ['type' => 'string', 'length' => 19, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Amazon注文番号', 'precision' => null, 'fixed' => null],
        'quantity' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '商品数量', 'precision' => null, 'autoIncrement' => null],
        'note' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '备注', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间', 'precision' => null],
        'updated' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间', 'precision' => null],
        'modifier_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'FLG.已删除', 'precision' => null],
        '_indexes' => [
            'order_id' => ['type' => 'index', 'columns' => ['order_id'], 'length' => []],
            'product_id' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
            'product_type_id' => ['type' => 'index', 'columns' => ['product_type_id'], 'length' => []],
            'modifier_id' => ['type' => 'index', 'columns' => ['modifier_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'order_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['order_id'], 'references' => ['orders', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'order_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['product_id'], 'references' => ['products', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'order_details_ibfk_3' => ['type' => 'foreign', 'columns' => ['product_type_id'], 'references' => ['product_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'order_details_ibfk_4' => ['type' => 'foreign', 'columns' => ['modifier_id'], 'references' => ['administrators', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'order_id' => 1,
            'product_id' => 1,
            'asin' => 'Lorem ip',
            'name' => 'Lorem ipsum dolor sit amet',
            'price' => 1,
            'standard' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'image' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'product_type_id' => 1,
            'sale_start_date' => '2017-07-24 16:01:43',
            'restrict_flg' => 1,
            'amazon_order_code' => 'Lorem ipsum dolor',
            'quantity' => 1,
            'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => 1500883303,
            'updated' => 1500883303,
            'modifier_id' => 1,
            'deleted' => 1500883303
        ],
    ];
}
