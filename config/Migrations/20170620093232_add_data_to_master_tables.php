<?php

use Phinx\Migration\AbstractMigration;

class AddDataToMasterTables extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $order_statuses = $this->table('order_statuses');
        $order_statuses->insert([
            ['name' => '采购中', 'sort' => 1],
            ['name' => '未支付', 'sort' => 2],
            ['name' => '支付成功', 'sort' => 3],
            ['name' => '支付失败', 'sort' => 4]
        ])->saveData();

        $point_calculations = $this->table('point_calculations');
        $point_calculations->insert([
            ['name' => '加算', 'sort' => 1],
            ['name' => '减算', 'sort' => 2]
        ])->saveData();

        $point_types = $this->table('point_types');
        $point_types->insert([
            ['name' => '充值', 'sort' => 1],
            ['name' => '商品购买', 'sort' => 2],
            ['name' => '运费', 'sort' => 3],
            ['name' => '运费返金', 'sort' => 4],
            ['name' => '管理员调控', 'sort' => 5]
        ])->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE order_statuses.*, point_calculations.*, point_types.* FROM order_statuses, point_calculations, point_types;');
    }
}
