<?php

use Phinx\Migration\AbstractMigration;

class AddDataToAmazonAccountStatusesAndDeliveryTypesTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $amazon_account_statuses = $this->table('amazon_account_statuses');
        $amazon_account_statuses->insert([
            ['id' => 1, 'name' => '停止', 'sort' => 1],
            ['id' => 2, 'name' => '未使用', 'sort' => 2],
            ['id' => 3, 'name' => '使用中', 'sort' => 3],
            ['id' => 4, 'name' => '错误', 'sort' => 4]
        ])->saveData();

        $delivery_types = $this->table('delivery_types');
        $delivery_types->insert([
            ['id' => 1, 'name' => 'EMS', 'sort' => 1],
            ['id' => 2, 'name' => '空运', 'sort' => 2],
            ['id' => 3, 'name' => 'SAL', 'sort' => 3],
            ['id' => 4, 'name' => '船运', 'sort' => 4]
        ])->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE amazon_account_statuses.*, delivery_types.* FROM amazon_account_statuses, delivery_types;');
    }
}
