<?php
namespace App\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\MissingDatasourceException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\Time;
use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\ORM\Table;

/**
 * SoftDelete behavior
 */
class SoftDeleteBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function findActive(Query $query, array $options)
    {
        return $query->find('all', $options)->where([$this->getTable()->aliasField($this->getSoftDeleteField())." IS" => null]);
    }

    public function softDelete(EntityInterface $entity)
    {
        if ($entity->isNew()) {
            throw new RecordNotFoundException(__('exception', 'This record dose not exist.'));
        }

        $field = $this->getSoftDeleteField();
        if (is_null($entity->get($field))) {
            $entity->set($field, Time::now());
            $this->getTable()->save($entity);
        }

        return true;
    }

    private function getSoftDeleteField()
    {
        if (is_null($this->getTable()->getSchema()->column('deleted'))) {
            throw new MissingDatasourceException(__('exception', 'Soft delete field dose not exist.'));
        }

        return 'deleted';
    }
}
