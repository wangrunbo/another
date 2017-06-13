<?php

use Phinx\Migration\AbstractMigration;

class CreateAmazonAccountsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $amazon_accounts = $this->table('amazon_accounts', ['comment' => '亚马逊帐号']);
        $amazon_accounts
            ->addColumn('email', 'string', ['limit' => '30', 'null' => false, 'comment' => '帐号'])
            ->addColumn('password', 'string', ['limit' => 100, 'null' => false, 'comment' => '密码'])
            ->addColumn('balance', 'integer', ['limit' => 11, 'null' => false, 'default' => 0, 'comment' => '余额'])
            ->addColumn('amazon_account_status_id', 'integer', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_SMALL, 'null' => false, 'default' => 1, 'comment' => 'FK.帐号状态'])
            ->addColumn('creator_id', 'integer', ['limit' => 11, 'null' => true, 'comment' => 'FK.添加者（管理员ID）'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addColumn('modifier_id', 'integer', ['limit' => 11, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者'])
            ->addForeignKey('creator_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('modifier_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}
