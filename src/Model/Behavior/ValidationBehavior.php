<?php
namespace App\Model\Behavior;

use Cake\I18n\Time;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use InvalidArgumentException;

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

    /**
     * Check time format
     *
     * @param string|object $value
     * @param string $format
     * @return bool
     */
    public function isTimeFormat($value, $format = 'object')
    {
        if ($format === 'object') {
            return gettype($value) === $format && $value instanceof Time;
        } else {
            try {
                Time::createFromFormat($format, $value);
            } catch (InvalidArgumentException $e) {
                return false;
            }
        }

        return true;
    }

    ################################# rules #################################

    /**
     * Check value in between range
     *
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     * @param array $options
     * @return bool
     */
    public function range($value, $min, $max, $options = [])
    {
        $options += [
            'minEqual' => true,
            'maxEqual' => true
        ];

        if ($options['minEqual']) {
            $result1 = $value >= $min;
        } else {
            $result1 = $value > $min;
        }

        if ($options['maxEqual']) {
            $result2 = $value <= $max;
        } else {
            $result2 = $value < $max;
        }

        return $result1 && $result2;
    }

    /**
     * Check data exist in table
     *
     * @param mixed $value
     * @param string $table
     * @param string $column
     * @param string $finder
     * @param array $options
     * @return bool
     */
    public function exist($value, $table, $column, $finder, $options = [])
    {
        foreach ((array)$value as $v) {
            if (TableRegistry::get($table)
                ->find($finder, $options)
                ->where(["{$table}.{$column}" => $v])
                ->isEmpty()
            ) {
                return false;
            }
        }

        return true;
    }
}
