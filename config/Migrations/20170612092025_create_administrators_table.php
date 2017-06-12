<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateAdministratorsTable extends AbstractMigration
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
        $administrators = $this->table('administrators', ['comment' => '管理员']);
        $administrators
            ->addColumn('password', 'string', ['limit' => 20, 'null' => false, 'comment' => '密码'])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => true, 'comment' => '姓名'])
            ->addColumn('email', 'string', ['limit' => 100, 'null' => false, 'comment' => '邮箱'])
            ->addColumn('sex_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'default' => 1, 'comment' => 'FK.性别'])
            ->addColumn('birthday', 'datetime', ['null' => true, 'comment' => '生日'])
            ->addColumn('postcode', 'string', ['limit' => 6, 'null' => true, 'comment' => '邮编'])
            ->addColumn('address', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'comment' => '地址'])
            ->addColumn('tel', 'string', ['limit' => 20, 'null' => true, 'comment' => '手机'])
            ->addColumn('note', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null, 'comment' => 'FLG.已删除'])
            ->addForeignKey('sex_id', 'sex', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
