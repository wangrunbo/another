<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class DepositoryAddressesTable extends AbstractMigration
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
        $depository_addresses = $this->table('depository_addresses', ['comment' => '保管地址', 'id' => false, 'primary_key' => 'id']);
        $depository_addresses
            ->addColumn('id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false, 'comment' => '收件人'])
            ->addColumn('postcode', 'string', ['limit' => 7, 'null' => false, 'comment' => '邮编'])
            ->addColumn('address1', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => false, 'comment' => '地址1'])
            ->addColumn('address2', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => false, 'comment' => '地址2'])
            ->addColumn('company', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => false, 'comment' => '企业名'])
            ->addColumn('tel', 'string', ['limit' => 20, 'null' => false, 'comment' => '联系电话'])
            ->addColumn('note', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addColumn('modifier_id', 'integer', ['limit' => 11, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者'])
            ->addForeignKey('modifier_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
