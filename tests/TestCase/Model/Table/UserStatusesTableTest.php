<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserStatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserStatusesTable Test Case
 */
class UserStatusesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserStatusesTable
     */
    public $UserStatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_statuses',
        'app.users',
        'app.sex',
        'app.administrators',
        'app.addresses',
        'app.cart',
        'app.favourites',
        'app.login_history',
        'app.orders',
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
        $config = TableRegistry::exists('UserStatuses') ? [] : ['className' => 'App\Model\Table\UserStatusesTable'];
        $this->UserStatuses = TableRegistry::get('UserStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserStatuses);

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
