<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FavouritesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FavouritesTable Test Case
 */
class FavouritesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FavouritesTable
     */
    public $Favourites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.favourites',
        'app.users',
        'app.sex',
        'app.user_statuses',
        'app.administrators',
        'app.addresses',
        'app.cart',
        'app.products',
        'app.product_types',
        'app.order_details',
        'app.product_images',
        'app.product_info',
        'app.product_info_types',
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
        $config = TableRegistry::exists('Favourites') ? [] : ['className' => 'App\Model\Table\FavouritesTable'];
        $this->Favourites = TableRegistry::get('Favourites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Favourites);

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
