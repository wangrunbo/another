<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductTypesTable Test Case
 */
class ProductTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductTypesTable
     */
    public $ProductTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.product_types',
        'app.order_details',
        'app.products',
        'app.users',
        'app.sex',
        'app.account_statuses',
        'app.addresses',
        'app.administrators',
        'app.cart',
        'app.favourites',
        'app.product_images',
        'app.product_info',
        'app.product_info_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProductTypes') ? [] : ['className' => 'App\Model\Table\ProductTypesTable'];
        $this->ProductTypes = TableRegistry::get('ProductTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductTypes);

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
