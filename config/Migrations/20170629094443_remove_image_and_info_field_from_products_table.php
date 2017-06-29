<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class RemoveImageAndInfoFieldFromProductsTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $products = $this->table('products');
        $products
            ->removeColumn('image')
            ->removeColumn('info')
            ->update();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $products = $this->table('products');
        $products
            ->addColumn('image', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'after' => 'standard', 'comment' => '商品图片'])
            ->addColumn('info', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'after' => 'stock_flg', 'comment' => '商品信息'])
            ->update();
    }
}
