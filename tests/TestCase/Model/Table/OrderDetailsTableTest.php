<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderDetailsTable Test Case
 */
class OrderDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderDetailsTable
     */
    public $OrderDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.order_details',
        'app.orders',
        'app.users',
        'app.sex',
        'app.user_statuses',
        'app.administrators',
        'app.addresses',
        'app.cart',
        'app.products',
        'app.product_types',
        'app.favourites',
        'app.product_images',
        'app.product_info',
        'app.product_info_types',
        'app.login_history',
        'app.point_history',
        'app.point_types',
        'app.delivery_types',
        'app.posts',
        'app.order_statuses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrderDetails') ? [] : ['className' => 'App\Model\Table\OrderDetailsTable'];
        $this->OrderDetails = TableRegistry::get('OrderDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderDetails);

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
