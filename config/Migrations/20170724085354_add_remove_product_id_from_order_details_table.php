<?php

use Phinx\Migration\AbstractMigration;

class AddRemoveProductIdFromOrderDetailsTable extends AbstractMigration
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
    public function up()
    {
        $order_details = $this->table('order_details');
        $order_details
            ->dropForeignKey('product_id')
            ->removeColumn('product_id')
            ->update();
    }

    public function down()
    {
        $order_details = $this->table('order_details');
        $order_details
            ->addColumn('product_id', 'integer', ['limit' => 11, 'null' => false, 'after' => 'order_id', 'comment' => 'FK.商品信息'])
            ->update();

        $data = $this->fetchRow('SELECT id FROM products;');
        if ($data) {
            $this->execute('UPDATE order_details SET product_id='.$data['id']);
        }

        $order_details
            ->addForeignKey('product_id', 'products', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();
    }
}
