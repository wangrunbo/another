<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateOrdersTable extends AbstractMigration
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
        $orders = $this->table('orders', ['comment' => '交易信息']);
        $orders
            ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => false, 'comment' => 'FK.会员'])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false, 'comment' => '收件人'])
            ->addColumn('postcode', 'string', ['limit' => 6, 'null' => false, 'comment' => '邮编'])
            ->addColumn('address', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => false, 'comment' => '地址'])
            ->addColumn('tel', 'string', ['limit' => 20, 'null' => false, 'comment' => '联系电话'])
            ->addColumn('total_price', 'integer', ['limit' => 11, 'null' => false, 'comment' => 'Amazon付款总价（包含运费）'])
            ->addColumn('amazon_postage', 'integer', ['limit' => 11, 'null' => false, 'default' => 0, 'comment' => 'Amazon运费'])
            ->addColumn('order_status_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'default' => 1, 'comment' => 'FK.交易状态'])
            ->addColumn('post_id', 'integer', ['limit' => 11, 'null' => true, 'comment' => 'FK.邮寄信息'])
            ->addColumn('note', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addColumn('modifier_id', 'integer', ['limit' => 11, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null, 'comment' => 'FLG.已删除'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('modifier_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
