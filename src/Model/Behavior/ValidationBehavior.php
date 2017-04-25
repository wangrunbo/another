<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Validation behavior
 */
class ValidationBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'locale' => 'validation'
    ];


    public function setValidationConfig($key, $value = null)
    {
        $this->setConfig($key, $value);
    }

    public function getValidationConfig($key = null)
    {
        return $this->getConfig($key);
    }
}
