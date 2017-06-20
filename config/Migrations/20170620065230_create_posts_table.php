<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreatePostsTable extends AbstractMigration
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
        $posts = $this->table('posts', ['comment' => '邮寄信息']);
        $posts
            ->addColumn('number', 'string', ['limit' => 13, 'null' => false, 'comment' => '邮单号'])
            ->addColumn('delivery_type_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'comment' => 'FK.邮寄方法'])
            ->addColumn('postage', 'integer', ['limit' => 11, 'null' => false, 'comment' => '邮费'])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false, 'comment' => '收件人'])
            ->addColumn('postcode', 'string', ['limit' => 6, 'null' => false, 'comment' => '邮编'])
            ->addColumn('address', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => false, 'comment' => '地址'])
            ->addColumn('tel', 'string', ['limit' => 20, 'null' => false, 'comment' => '联系电话'])
            ->addColumn('image', 'string', ['limit' => 20, 'null' => false, 'comment' => '邮单照片文件名'])
            ->addColumn('note', 'text', ['limit' => MysqlAdapter::TEXT_REGULAR, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '生成时间'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'comment' => '修改时间'])
            ->addColumn('modifier_id', 'integer', ['limit' => 11, 'null' => true, 'default' => null, 'comment' => 'FK.最近更新者'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null, 'comment' => 'FLG.已删除'])
            ->addForeignKey('delivery_type_id', 'delivery_types', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('modifier_id', 'administrators', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addIndex(['number'], ['unique' => true])
            ->create();
    }
}
