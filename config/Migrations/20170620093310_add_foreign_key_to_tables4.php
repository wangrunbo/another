<?php

use Phinx\Migration\AbstractMigration;

class AddForeignKeyToTables4 extends AbstractMigration
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
        $point_history = $this->table('point_history');

        $this->execute(
            'UPDATE orders, point_history 
            SET orders.order_status_id=4, orders.post_id=NULL, point_history.point_calculation_id=2, point_history.point_type_id=2;'
        );

        $orders
            ->addForeignKey('order_status_id', 'order_statuses', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('post_id', 'posts', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();

        $point_history
            ->addForeignKey('point_calculation_id', 'point_calculations', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('point_type_id', 'point_types', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();
    }
}
