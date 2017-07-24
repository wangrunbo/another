<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class AddRemovePointCalculations extends AbstractMigration
{
    /**
     * Up Method.
     */
    public function up()
    {
        $point_history = $this->table('point_history');
        $point_history
            ->dropForeignKey('point_calculation_id')
            ->removeColumn('point_calculation_id')
            ->update();

        $point_calculations = $this->table('point_calculations');
        $point_calculations->drop();
    }

    /**
     * Down Method.
     */
    public function down()
    {
        $point_calculations = $this->table('point_calculations', ['comment' => 'MTB.点数计算', 'id' => false, 'primary_key' => 'id']);
        $point_calculations
            ->addColumn('id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted', 'timestamp', ['null' => true, 'default' => null])
            ->addIndex(['name'], ['unique' => true])
            ->addIndex(['sort'], ['unique' => true])
            ->create();

        $point_calculations->insert([
            ['name' => '加算', 'sort' => 1],
            ['name' => '减算', 'sort' => 2]
        ])->saveData();

        $point_history = $this->table('point_history');
        $point_history
            ->addColumn('point_calculation_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'after' => 'point', 'comment' => 'FK.点数计算(加算/减算)'])
            ->update();

        $this->execute('UPDATE point_history SET point_history.point_calculation_id=2;');

        $point_history
            ->addForeignKey('point_calculation_id', 'point_calculations', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->update();
    }
}
