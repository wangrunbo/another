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
            ['name' => '停止', 'sort' => 1],
            ['name' => '未使用', 'sort' => 2],
            ['name' => '使用中', 'sort' => 3],
            ['name' => '错误', 'sort' => 4]
        ])->saveData();

        $delivery_types = $this->table('delivery_types');
        $delivery_types->insert([
            ['name' => 'EMS', 'sort' => 1],
            ['name' => '空运', 'sort' => 2],
            ['name' => 'SAL', 'sort' => 3],
            ['name' => '船运', 'sort' => 4]
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
