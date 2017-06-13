<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateAmazonAccountStatusesTable extends AbstractMigration
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
        $amazon_account_statuses = $this->table('amazon_account_statuses', ['comment' => 'MTB.亚马逊帐号状态', 'id' => false, 'primary_key' => 'id']);
        $amazon_account_statuses
            ->addColumn('id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null])
            ->addIndex(['name'], ['unique' => true])
            ->addIndex(['sort'], ['unique' => true])
            ->create();
    }
}
