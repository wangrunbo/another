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
            ['id' => 1, 'name' => '未支付', 'sort' => 1],
            ['id' => 2, 'name' => '交易完成', 'sort' => 2],
            ['id' => 3, 'name' => '交易失败', 'sort' => 3],
            ['id' => 4, 'name' => '交易过期', 'sort' => 4]
        ])->saveData();

        $point_calculations = $this->table('point_calculations');
        $point_calculations->insert([
            ['id' => 1, 'name' => '加算', 'sort' => 1],
            ['id' => 2, 'name' => '减算', 'sort' => 2]
        ])->saveData();

        $point_types = $this->table('point_types');
        $point_types->insert([
            ['id' => 1, 'name' => '充值', 'sort' => 1],
            ['id' => 2, 'name' => '商品购买', 'sort' => 2],
            ['id' => 3, 'name' => '运费', 'sort' => 3],
            ['id' => 4, 'name' => '运费返金', 'sort' => 4],
            ['id' => 5, 'name' => '管理员调控', 'sort' => 5]
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
