<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SexTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SexTable Test Case
 */
class SexTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SexTable
     */
    public $Sex;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sex',
        'app.users',
        'app.account_statuses',
        'app.addresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Sex') ? [] : ['className' => 'App\Model\Table\SexTable'];
        $this->Sex = TableRegistry::get('Sex', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Sex);

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
