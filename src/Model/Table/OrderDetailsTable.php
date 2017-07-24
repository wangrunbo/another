<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\BelongsTo $ProductTypes
 * @property \Cake\ORM\Association\BelongsTo $Administrators
 *
 * @method \App\Model\Entity\OrderDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDetail findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderDetailsTable extends Table
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

        $this->setTable('order_details');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Administrators', [
            'foreignKey' => 'modifier_id'
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
            ->requirePresence('asin', 'create')
            ->notEmpty('asin');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('price')
            ->requirePresence('price', 'create')
            ->notEmpty('price');

        $validator
            ->allowEmpty('standard');

        $validator
            ->allowEmpty('image');

        $validator
            ->dateTime('sale_start_date')
            ->allowEmpty('sale_start_date');

        $validator
            ->boolean('restrict_flg')
            ->requirePresence('restrict_flg', 'create')
            ->notEmpty('restrict_flg');

        $validator
            ->allowEmpty('amazon_order_code');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->allowEmpty('note');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));
        $rules->add($rules->existsIn(['modifier_id'], 'Administrators'));

        return $rules;
    }
}
