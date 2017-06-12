<?php

use Phinx\Migration\AbstractMigration;

class AddForeignKeyToTables2 extends AbstractMigration
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
        $user = $this->table('users');
        $addresses = $this->table('addresses');
        $products = $this->table('products', ['comment' => '商品']);
        $administrators = $this->table('administrators');

        $this->execute(
            'UPDATE users, addresses, products, administrators 
            SET users.modifier_id=NULL, addresses.modifier_id=NULL,
            products.product_type_id=1, products.searcher_id=NULL, products.creator_id=NULL, products.modifier_id=NULL,
            administrators.sex_id=1;'
        );

        $user
            ->addForeignKey('modifier_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();

        $addresses
            ->addForeignKey('modifier_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();

        $products
            ->addForeignKey('product_type_id', 'product_types', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('searcher_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('creator_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('modifier_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();

        $administrators
            ->addForeignKey('sex_id', 'sex', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();
    }
}
