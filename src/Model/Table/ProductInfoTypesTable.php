<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductInfoTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $ProductInfo
 *
 * @method \App\Model\Entity\ProductInfoType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductInfoType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProductInfoType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductInfoType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductInfoType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductInfoType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductInfoType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \App\Model\Behavior\SoftDeleteBehavior
 */
class ProductInfoTypesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('product_info_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('SoftDelete');

        $this->hasMany('ProductInfo', [
            'foreignKey' => 'product_info_type_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('sort')
            ->requirePresence('sort', 'create')
            ->notEmpty('sort')
            ->add('sort', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->isUnique(['sort']));

        return $rules;
    }
}
