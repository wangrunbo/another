<?php

use Phinx\Migration\AbstractMigration;

class AddFinishFieldToOrdersTable extends AbstractMigration
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
            ->addColumn('finish', 'timestamp', ['null' => true, 'default' => null, 'after' => 'order_status_id', 'comment' => '交易完成时间'])
            ->update();
    }
}
