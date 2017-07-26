<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PointTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PointTypesTable Test Case
 */
class PointTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PointTypesTable
     */
    public $PointTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.point_types',
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
        'app.orders',
        'app.delivery_types',
        'app.posts',
        'app.order_statuses',
        'app.favourites',
        'app.product_images',
        'app.product_info',
        'app.product_info_types',
        'app.login_history'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PointTypes') ? [] : ['className' => 'App\Model\Table\PointTypesTable'];
        $this->PointTypes = TableRegistry::get('PointTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PointTypes);

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
