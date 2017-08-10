<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AmazonAccountsFixture
 *
 */
class AmazonAccountsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'email' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '帐号', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '密码', 'precision' => null, 'fixed' => null],
        'balance' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '余额', 'precision' => null, 'autoIncrement' => null],
        'amazon_account_status_id' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => 'FK.帐号状态', 'precision' => null, 'autoIncrement' => null],
        'creator_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK.添加者（管理员ID）', 'precision' => null, 'autoIncrement' => null],
        'note' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '备注', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间', 'precision' => null],
        'updated' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间', 'precision' => null],
        'modifier_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'creator_id' => ['type' => 'index', 'columns' => ['creator_id'], 'length' => []],
            'modifier_id' => ['type' => 'index', 'columns' => ['modifier_id'], 'length' => []],
            'amazon_account_status_id' => ['type' => 'index', 'columns' => ['amazon_account_status_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'email' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
            'amazon_accounts_ibfk_1' => ['type' => 'foreign', 'columns' => ['creator_id'], 'references' => ['administrators', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'amazon_accounts_ibfk_2' => ['type' => 'foreign', 'columns' => ['modifier_id'], 'references' => ['administrators', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'amazon_accounts_ibfk_3' => ['type' => 'foreign', 'columns' => ['amazon_account_status_id'], 'references' => ['amazon_account_statuses', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'email' => 'Lorem ipsum dolor sit amet',
            'password' => 'Lorem ipsum dolor sit amet',
            'balance' => 1,
            'amazon_account_status_id' => 1,
            'creator_id' => 1,
            'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => 1502264982,
            'updated' => 1502264982,
            'modifier_id' => 1
        ],
    ];
}
