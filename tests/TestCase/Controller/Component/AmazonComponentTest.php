<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\AmazonComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\AmazonComponent Test Case
 */
class AmazonComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\AmazonComponent
     */
    public $Amazon;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Amazon = new AmazonComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Amazon);

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
