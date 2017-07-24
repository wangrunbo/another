<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PointHistoryFixture
 *
 */
class PointHistoryFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'point_history';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK.会员', 'precision' => null, 'autoIncrement' => null],
        'point' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '点数', 'precision' => null, 'autoIncrement' => null],
        'point_type_id' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'FK.点数类型', 'precision' => null, 'autoIncrement' => null],
        'order_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK.交易', 'precision' => null, 'autoIncrement' => null],
        'note' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '备注', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间', 'precision' => null],
        'updated' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间', 'precision' => null],
        'modifier_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'FLG.已删除', 'precision' => null],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'order_id' => ['type' => 'index', 'columns' => ['order_id'], 'length' => []],
            'modifier_id' => ['type' => 'index', 'columns' => ['modifier_id'], 'length' => []],
            'point_type_id' => ['type' => 'index', 'columns' => ['point_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'point_history_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'point_history_ibfk_2' => ['type' => 'foreign', 'columns' => ['order_id'], 'references' => ['orders', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'point_history_ibfk_3' => ['type' => 'foreign', 'columns' => ['modifier_id'], 'references' => ['administrators', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'point_history_ibfk_5' => ['type' => 'foreign', 'columns' => ['point_type_id'], 'references' => ['point_types', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'point' => 1,
            'point_type_id' => 1,
            'order_id' => 1,
            'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => 1500861132,
            'updated' => 1500861132,
            'modifier_id' => 1,
            'deleted' => 1500861132
        ],
    ];
}
