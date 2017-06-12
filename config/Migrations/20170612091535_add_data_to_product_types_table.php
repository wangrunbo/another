<?php

use Phinx\Migration\AbstractMigration;

class AddDataToProductTypesTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $product_types = $this->table('product_types');
        $product_types->insert([
            ['name' => '通常商品', 'sort' => 1],
            ['name' => '予約商品', 'sort' => 2],
            ['name' => 'あわせ買い商品', 'sort' => 3]
        ])->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM product_types;');
    }
}
