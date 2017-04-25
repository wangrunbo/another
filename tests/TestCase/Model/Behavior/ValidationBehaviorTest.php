<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\ValidationBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\ValidationBehavior Test Case
 */
class ValidationBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\ValidationBehavior
     */
    public $Validation;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Validation = new ValidationBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Validation);

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
