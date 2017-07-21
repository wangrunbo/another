<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PointHistoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PointHistoryTable Test Case
 */
class PointHistoryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PointHistoryTable
     */
    public $PointHistory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.point_history',
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
        'app.login_history',
        'app.orders',
        'app.order_statuses',
        'app.posts',
        'app.point_calculations',
        'app.point_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PointHistory') ? [] : ['className' => 'App\Model\Table\PointHistoryTable'];
        $this->PointHistory = TableRegistry::get('PointHistory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PointHistory);

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
