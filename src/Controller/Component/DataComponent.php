<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Data component
 */
class DataComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'validate' => [
            'validate' => true,
            'correct' => false,
        ],
        'completion' => [
            'ignore' => []
        ]
    ];

    /**
     * 数据验证
     *
     * @param array $data
     * @param \Cake\Datasource\EntityInterface $entity
     * @param callable|null $callback
     * @param array $options
     * @return array
     */
    public function validate($data, $entity, callable $callback = null, $options = [])
    {
        $result = [
            'errors' => [],
            'default' => $data
        ];

        if (empty($options)) {
            $options = $this->getConfig('validate');
        }

        TableRegistry::get($entity->getSource())->patchEntity($entity, $data, ['validate' => $options['validate']]);

        if (!is_null($callback)) {
            $callback();
        }

        $result['errors'] = $entity->getErrors();

        if ($options['correct']) {
            foreach (array_keys($data) as $key) {
                if (!array_key_exists($key, $result['errors']) && $entity->has($key)) {
                    $result['default'][$key] = $entity->get($key);
                }
            }
        }

        return $result;
    }

    /**
     * Entity数据补全
     *
     * @param \Cake\Datasource\EntityInterface $entity
     * @param array $options
     */
    public function completion($entity, $options = [])
    {
        if (empty($options)) {
            $options = $this->getConfig('completion');
        }

        $schema = TableRegistry::get($entity->getSource())->getSchema();
        foreach ($schema->columns() as $column) {
            if (
                $entity->has($column)
                || in_array($column, (array)$options['ignore'])
                || in_array($column, $schema->primaryKey())
                || array_key_exists($column, $schema->defaultValues())
                || $schema->isNullable($column)
            ) {
                continue;
            }

            switch ($schema->columnType($column)) {
                case 'string':
                    $value = '';
                    break;
                case 'integer':
                    $value = 0;
                    break;
                case 'datetime':
                    $value = Time::createFromTimestamp(0);
                    break;
                default:
                    $value = null;
            }

            $entity->set($column, $value);
        }
    }
}
