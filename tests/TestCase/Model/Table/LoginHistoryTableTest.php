<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoginHistoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoginHistoryTable Test Case
 */
class LoginHistoryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LoginHistoryTable
     */
    public $LoginHistory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.login_history',
        'app.users',
        'app.sex',
        'app.user_statuses',
        'app.administrators',
        'app.addresses',
        'app.cart',
        'app.products',
        'app.product_types',
        'app.order_details',
        'app.favourites',
        'app.product_images',
        'app.product_info',
        'app.product_info_types',
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
        $config = TableRegistry::exists('LoginHistory') ? [] : ['className' => 'App\Model\Table\LoginHistoryTable'];
        $this->LoginHistory = TableRegistry::get('LoginHistory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LoginHistory);

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
