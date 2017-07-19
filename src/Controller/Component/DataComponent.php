<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Symfony\Component\Config\Definition\Exception\UnsetKeyException;

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
    protected $_defaultConfig = [];

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
        $options += [
            'validate' => true,
            'correct' => false,
        ];

        $result = [
            'errors' => [],
            'default' => $data
        ];

        TableRegistry::get((string)$entity->getSource())->patchEntity($entity, $data, ['validate' => $options['validate']]);

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
     * @param array|\Cake\Datasource\EntityInterface $entity
     * @param array $options
     * @return array|\Cake\Datasource\EntityInterface
     * @throws UnsetKeyException
     */
    public function completion(&$entity, $options = [])
    {
        $options += [
            'table' => null,
            'ignore' => [],
            'sort' => null
        ];

        $is_array = is_array($entity);

        if ($is_array) {
            if (is_null($options['table'])) {
                throw new UnsetKeyException(__d('exception', 'Missing argument "table" in your options.'));
            }

            $entity = TableRegistry::get($options['table'])->newEntity($entity, ['validate' => false]);
        }

        if ($options['sort'] === true || (is_null($options['sort']) && $entity->isNew())) {
            $this->autoSort($entity);
        }

        $schema = TableRegistry::get((string)$entity->getSource())->getSchema();
        foreach ($schema->columns() as $column) {
            if (
                $entity->has($column)
                || !empty($entity->getError($column))
                || in_array($column, (array)$options['ignore'])
                || in_array($column, $schema->primaryKey())
                || in_array($column, $schema->indexes())  // 避免自动插入外键
                || array_key_exists($column, $schema->defaultValues())
                || $schema->isNullable($column)
            ) {
                continue;
            }

            switch ($schema->columnType($column)) {
                case 'string':
                case 'text':
                    $value = '';
                    break;
                case 'integer':
                    $value = 0;
                    break;
                case 'boolean':
                    $value = true;
                    break;
                case 'datetime':
                case 'timestamp':
                    $value = Time::createFromTimestamp(0);
                    break;
                default:
                    $value = null;
            }

            $entity->set($column, $value);
        }

        if ($is_array) {
            $entity = $entity->toArray();
        }

        return $entity;
    }

    /**
     * Entity自动排序
     *
     * @param \Cake\Datasource\EntityInterface $entity
     * @param array $options
     */
    public function autoSort($entity, $options = [])
    {
        $table = TableRegistry::get((string)$entity->getSource());

        if (method_exists($table, 'autoSort')) {
            $table->autoSort($entity, $options);
        } else {
            $options += [];

            if (!is_null($table->getSchema()->column('sort'))) {
                $last = $table->find()->select('sort')->orderDesc('sort')->first()->sort;
                $entity->set('sort', $last + 1);
            }
        }
    }

    /**
     * Entity数据还原
     *
     * @param \Cake\ORM\Entity $entity
     * @param array $options
     */
    public function reduction($entity, $options = [])
    {
        $options += [];

        foreach ($entity->getDirty() as $field) {
            $entity->set($field, $entity->getOriginal($field));
        }
    }
}
