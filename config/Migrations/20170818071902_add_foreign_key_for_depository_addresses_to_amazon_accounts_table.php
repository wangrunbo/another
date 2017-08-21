<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class AddForeignKeyForDepositoryAddressesToAmazonAccountsTable extends AbstractMigration
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
        $this->execute('TRUNCATE TABLE amazon_accounts');

        $amazon_account = $this->table('amazon_accounts');
        $amazon_account
            ->addColumn('depository_address_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'after' => 'balance', 'comment' => 'FK.保管地址'])
            ->addForeignKey('depository_address_id', 'depository_addresses', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();
    }
}
