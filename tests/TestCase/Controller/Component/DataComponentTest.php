<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\DataComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\DataComponent Test Case
 */
class DataComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\DataComponent
     */
    public $Data;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Data = new DataComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Data);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
