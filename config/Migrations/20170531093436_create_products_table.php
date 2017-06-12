<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateProductsTable extends AbstractMigration
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
        $products = $this->table('products', ['comment' => '商品']);
        $products
            ->addColumn('asin', 'string', ['limit' => 10, 'null' => false, 'comment' => 'ASIN code'])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false, 'comment' => '商品名'])
            ->addColumn('price', 'integer', ['limit' => 11, 'null' => false, 'comment' => '商品Amazon价格'])
            ->addColumn('product_type_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'comment' => 'FK.商品类型'])
            ->addColumn('sale_start_date', 'datetime', ['null' => true, 'comment' => '贩卖开始日期'])
            ->addColumn('stock_flg', 'boolean', ['null' => false, 'default' => true, 'comment' => '库存状态'])
            ->addColumn('standard', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'comment' => '商品规格'])
            ->addColumn('info', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'comment' => '商品信息'])
            ->addColumn('description', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'comment' => '管理者添加的商品描述'])
            ->addColumn('searcher_id', 'integer', ['limit' => 11, 'null' => true, 'comment' => 'FK.添加者（用户ID）'])
            ->addColumn('creator_id', 'integer', ['limit' => 11, 'null' => true, 'comment' => 'FK.添加者（管理员ID）'])
            ->addColumn('blacklist_flg', 'boolean', ['null' => false, 'default' => false, 'comment' => 'FLG.黑名单'])
            ->addColumn('bought_times', 'integer', ['limit' => 11, 'null' => false, 'default' => 0, 'comment' => '购买次数'])
            ->addColumn('searched_times', 'integer', ['limit' => 11, 'null' => false, 'default' => 0, 'comment' => '检索次数'])
            ->addColumn('restrict_flg', 'boolean', ['null' => false, 'default' => false, 'comment' => 'FLG.成人商品'])
            ->addColumn('note', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addColumn('modifier_id', 'integer', ['limit' => 11, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null, 'comment' => 'FLG.已删除'])
            ->addForeignKey('searcher_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addIndex(['asin'], ['unique' => true])
            ->create();
    }
}
