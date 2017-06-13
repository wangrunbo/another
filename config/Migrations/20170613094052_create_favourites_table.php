<?php

use Phinx\Migration\AbstractMigration;

class CreateFavouritesTable extends AbstractMigration
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
        $favourites = $this->table('favourites', ['comment' => '收藏商品']);
        $favourites
            ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => false, 'comment' => 'FK.会员'])
            ->addColumn('product_id', 'integer', ['limit' => 11, 'null' => false, 'comment' => 'FK.商品'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('product_id', 'products', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
