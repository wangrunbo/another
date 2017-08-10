<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AmazonAccountsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AmazonAccountsTable Test Case
 */
class AmazonAccountsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AmazonAccountsTable
     */
    public $AmazonAccounts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.amazon_accounts',
        'app.amazon_account_statuses',
        'app.administrators',
        'app.sex',
        'app.users',
        'app.user_statuses',
        'app.addresses',
        'app.cart',
        'app.products',
        'app.product_types',
        'app.order_details',
        'app.orders',
        'app.delivery_types',
        'app.posts',
        'app.order_statuses',
        'app.point_history',
        'app.point_types',
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
        $config = TableRegistry::exists('AmazonAccounts') ? [] : ['className' => 'App\Model\Table\AmazonAccountsTable'];
        $this->AmazonAccounts = TableRegistry::get('AmazonAccounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AmazonAccounts);

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
