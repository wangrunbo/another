<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PointCalculationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PointCalculationsTable Test Case
 */
class PointCalculationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PointCalculationsTable
     */
    public $PointCalculations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.point_calculations',
        'app.point_history'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PointCalculations') ? [] : ['className' => 'App\Model\Table\PointCalculationsTable'];
        $this->PointCalculations = TableRegistry::get('PointCalculations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PointCalculations);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
