<?php

use Phinx\Migration\AbstractMigration;

class AddRemovePostageFieldFromOrders extends AbstractMigration
{
    /**
     * Up Method.
     */
    public function up()
    {
        $orders = $this->table('orders');
        $orders->removeColumn('amazon_postage')->update();
    }

    /**
     * Down Method.
     */
    public function down()
    {
        $orders = $this->table('orders');
        $orders
            ->addColumn('amazon_postage', 'integer', ['limit' => 11, 'null' => false, 'after' => 'total_price', 'comment' => 'Amazon运费'])
            ->update();
    }
}
