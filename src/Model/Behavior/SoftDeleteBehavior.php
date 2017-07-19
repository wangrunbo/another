<?php
namespace App\Model\Behavior;

use Cake\Database\Expression\QueryExpression;
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
    protected $_defaultConfig = [
        'column' => 'deleted'
    ];

    public function findActive(Query $query, array $options)
    {
        return $query->find('all', $options)->where(function (QueryExpression $exp) {
            return $exp->isNull($this->getTable()->aliasField($this->getSoftDeleteField()));
        });
    }

    /**
     * 逻辑删除
     *
     * @param EntityInterface $entity
     * @throws RecordNotFoundException
     * @return bool
     */
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

    /**
     * 逻辑删除恢复
     *
     * @param EntityInterface $entity
     * @return bool
     */
    public function resume(EntityInterface $entity)
    {
        if ($entity->isNew()) {
            throw new RecordNotFoundException(__('exception', 'This record dose not exist.'));
        }

        $field = $this->getSoftDeleteField();
        if (!is_null($entity->get($field))) {
            $entity->set($field, null);
            $this->getTable()->save($entity);
        }

        return true;
    }

    private function getSoftDeleteField()
    {
        if (is_null($this->getTable()->getSchema()->column($this->getConfig('column')))) {
            throw new MissingDatasourceException(__('exception', 'Soft delete field dose not exist.'));
        }

        return $this->getConfig('column');
    }
}
