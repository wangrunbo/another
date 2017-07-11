<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductInfoTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductInfoTypesTable Test Case
 */
class ProductInfoTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductInfoTypesTable
     */
    public $ProductInfoTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.product_info_types',
        'app.product_info',
        'app.products',
        'app.product_types',
        'app.users',
        'app.sex',
        'app.account_statuses',
        'app.addresses',
        'app.administrators',
        'app.cart',
        'app.favourites',
        'app.order_details',
        'app.product_images'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProductInfoTypes') ? [] : ['className' => 'App\Model\Table\ProductInfoTypesTable'];
        $this->ProductInfoTypes = TableRegistry::get('ProductInfoTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductInfoTypes);

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
