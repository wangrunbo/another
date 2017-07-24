<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class AddRemoveInfoAndDescriptionFieldsFromOrderDetailsTable extends AbstractMigration
{
    /**
     * Up Method.
     */
    public function up()
    {
        $order_details = $this->table('order_details');
        $order_details
            ->removeColumn('info')
            ->removeColumn('description')
            ->update();
    }

    /**
     * Down Method.
     */
    public function down()
    {
        $order_details = $this->table('order_details');
        $order_details
            ->addColumn('info', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'after' => 'sale_start_date', 'comment' => '商品信息'])
            ->addColumn('description', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'after' => 'info', 'comment' => '管理者添加的商品描述'])
            ->update();
    }
}
