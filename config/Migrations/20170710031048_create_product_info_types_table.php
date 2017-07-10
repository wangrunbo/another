<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateProductInfoTypesTable extends AbstractMigration
{
    /**
     * Up Method.
     */
    public function up()
    {
        $product_info_types = $this->table('product_info_types', ['comment' => 'MTB.商品信息类型', 'id' => false, 'primary_key' => 'id']);
        $product_info_types
            ->addColumn('id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null])
            ->addIndex(['name'], ['unique' => true])
            ->addIndex(['sort'], ['unique' => true])
            ->insert([
                ['name' => '詳細情報', 'sort' => 1],
                ['name' => '登録情報', 'sort' => 2]
            ])->create();

        $product_info = $this->table('product_info');
        $product_info
            ->addColumn('product_info_type_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'after' => 'product_id', 'comment' => 'FK.商品情报类型'])
            ->update();

        $this->execute('UPDATE product_info SET product_info.product_info_type_id=1;');

        $product_info
            ->addForeignKey('product_info_type_id', 'product_info_types', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();
    }

    /**
     * Up Method.
     */
    public function down()
    {
        $product_info = $this->table('product_info');
        $product_info
            ->dropForeignKey('product_info_type_id')
            ->removeColumn('product_info_type_id')
            ->update();

        $this->dropTable('product_info_types');
    }
}
