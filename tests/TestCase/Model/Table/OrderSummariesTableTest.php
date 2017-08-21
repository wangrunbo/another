<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderSummariesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderSummariesTable Test Case
 */
class OrderSummariesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderSummariesTable
     */
    public $OrderSummaries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.order_summaries',
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
        $config = TableRegistry::exists('OrderSummaries') ? [] : ['className' => 'App\Model\Table\OrderSummariesTable'];
        $this->OrderSummaries = TableRegistry::get('OrderSummaries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderSummaries);

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
