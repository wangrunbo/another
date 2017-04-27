<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountStatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountStatusesTable Test Case
 */
class AccountStatusesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountStatusesTable
     */
    public $AccountStatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.account_statuses',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AccountStatuses') ? [] : ['className' => 'App\Model\Table\AccountStatusesTable'];
        $this->AccountStatuses = TableRegistry::get('AccountStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccountStatuses);

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
