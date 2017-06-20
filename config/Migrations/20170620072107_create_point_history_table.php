<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreatePointHistoryTable extends AbstractMigration
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
        $point_history = $this->table('point_history', ['comment' => '余额记录']);
        $point_history
            ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => false, 'comment' => 'FK.会员'])
            ->addColumn('point', 'integer', ['limit' => 11, 'null' => false, 'comment' => '点数'])
            ->addColumn('point_calculation_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'comment' => 'FK.点数计算(加算/减算)'])
            ->addColumn('point_type_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'comment' => 'FK.点数类型'])
            ->addColumn('order_id', 'integer', ['limit' => 11, 'null' => true, 'comment' => 'FK.交易'])
            ->addColumn('note', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addColumn('modifier_id', 'integer', ['limit' => 11, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null, 'comment' => 'FLG.已删除'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('modifier_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
