<?php

use Phinx\Migration\AbstractMigration;

class AddForeignKeyToTables1 extends AbstractMigration
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
        $user = $this->table('users');

        $this->execute('UPDATE users SET user_status_id=1, sex_id=1;');

        $user
            ->addForeignKey('user_status_id', 'user_statuses', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('sex_id', 'sex', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();
    }
}
