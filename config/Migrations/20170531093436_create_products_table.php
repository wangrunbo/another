<?php

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
        $users = $this->table('products', ['comment' => '商品']);
        $users
            ->addColumn('asin', 'string', ['limit' => 10, 'null' => false, 'comment' => 'ASIN code'])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false, 'comment' => '商品名'])
            ->addColumn('price', 'integer', ['limit' => 11, 'null' => false, 'comment' => '商品Amazon价格'])
            ->addColumn('type', 'integer', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_SMALL, 'null' => false, 'comment' => 'FK.商品类型'])
            ->addColumn('sale_start_date', 'datetime', ['null' => true, 'comment' => '贩卖开始日期'])
            ->addColumn('stock_flg', 'boolean', ['null' => false, 'comment' => '库存状态'])
            ->addColumn('standard', 'text', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_REGULAR, 'null' => true, 'comment' => '商品规格'])
            ->addColumn('info', 'text', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_REGULAR, 'null' => true, 'comment' => '商品信息'])

            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null, 'comment' => 'FLG.已删除'])
            ->addIndex(['asin'], ['unique' => true])
            ->create();
    }
}
