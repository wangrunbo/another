<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderStatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderStatusesTable Test Case
 */
class OrderStatusesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderStatusesTable
     */
    public $OrderStatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.order_statuses',
        'app.orders',
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
        'app.point_history',
        'app.point_types',
        'app.posts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrderStatuses') ? [] : ['className' => 'App\Model\Table\OrderStatusesTable'];
        $this->OrderStatuses = TableRegistry::get('OrderStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderStatuses);

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
