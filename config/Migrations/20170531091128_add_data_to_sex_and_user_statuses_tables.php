<?php

use Phinx\Migration\AbstractMigration;

class AddDataToSexAndUserStatusesTables extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $sex = $this->table('sex');
        $sex->insert([
            ['id' => 1, 'name' => '未设定', 'sort' => 1],
            ['id' => 2, 'name' => '男', 'sort' => 2],
            ['id' => 3, 'name' => '女', 'sort' => 3]
        ])->saveData();

        $account_statuses = $this->table('user_statuses');
        $account_statuses->insert([
            ['id' => 1, 'name' => '未激活', 'sort' => 1],
            ['id' => 2, 'name' => '一般会员', 'sort' => 2],
            ['id' => 3, 'name' => '锁定', 'sort' => 3],
            ['id' => 4, 'name' => '删除', 'sort' => 4]
        ])->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE sex.*, user_statuses.* FROM sex, user_statuses;');
    }
}
