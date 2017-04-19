<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
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
        'validate' => true,
        'correct' => false
    ];

    /**
     * @param array $data
     * @param \Cake\Datasource\EntityInterface $entity
     * @param array $option
     * @return array
     */
    public function validate($data, $entity, $option = [])
    {
        $result = [
            'errors' => [],
            'default' => $data
        ];

        if (empty($option)) {
            $option = $this->getConfig();
        }

        TableRegistry::get($entity->getSource())->patchEntity($entity, $data, ['validate' => $option['validate']]);

        $result['errors'] = $entity->errors();

        if ($option['correct']) {
            foreach (array_keys($data) as $key) {
                if (!array_key_exists($key, $result['errors']) && $entity->has($key)) {
                    $result['default'][$key] = $entity->get($key);
                }
            }
        }

        return $result;
    }
}
