<?php

use Phinx\Migration\AbstractMigration;

class CreateSexTable extends AbstractMigration
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
        $sex = $this->table('sex');
        $sex
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null])
            ->addIndex(['name'], ['unique' => true])
            ->addIndex(['sort'], ['unique' => true])
            ->create();

        $sex->insert([
            ['name' => '未设定', 'sort' => 1],
            ['name' => '男', 'sort' => 2],
            ['name' => '女', 'sort' => 3]
        ])->save();

        $user = $this->table('users');
        $user
            ->addColumn('sex_id', 'integer', ['null' => false, 'after' => 'name'])
            ->save();

        $this->execute('UPDATE users SET sex_id=1');

        $user
            ->addForeignKey('sex_id', 'sex', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->save();
    }
}
