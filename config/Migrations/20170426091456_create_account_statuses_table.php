<?php

use Phinx\Migration\AbstractMigration;

class CreateAccountStatusesTable extends AbstractMigration
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
        $account_statuses = $this->table('account_statuses');
        $account_statuses
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null])
            ->addIndex(['name'], ['unique' => true])
            ->addIndex(['sort'], ['unique' => true])
            ->create();

        $account_statuses->insert([
            ['name' => '未激活', 'sort' => 1],
            ['name' => '一般会员', 'sort' => 2],
            ['name' => '锁定', 'sort' => 3],
            ['name' => '删除', 'sort' => 4]
        ])->save();

        $user = $this->table('users');
        $user
            ->addColumn('account_status_id', 'integer', ['null' => false])
            ->save();

        $this->execute('UPDATE users SET account_status_id=1');

        $user
            ->addForeignKey('account_status_id', 'account_statuses', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->save();
    }
}
