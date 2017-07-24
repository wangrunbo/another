<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class AddDeliveryTypeIdFieldToOrdersTable extends AbstractMigration
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
        $orders = $this->table('orders');
        $orders
            ->addColumn('delivery_type_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'after' => 'amazon_postage', 'comment' => 'FK.希望的邮寄方法'])
            ->update();

        $this->execute('UPDATE orders SET delivery_type_id=1;');

        $orders
            ->addForeignKey('delivery_type_id', 'delivery_types', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();
    }
}
