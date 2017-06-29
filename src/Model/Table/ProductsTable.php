<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ProductTypes
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Administrators
 * @property \Cake\ORM\Association\HasMany $Cart
 * @property \Cake\ORM\Association\HasMany $Favourites
 * @property \Cake\ORM\Association\HasMany $OrderDetails
 *
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \App\Model\Behavior\SoftDeleteBehavior
 * @mixin \App\Model\Behavior\ValidationBehavior
 */
class ProductsTable extends Table
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

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('SoftDelete');
        $this->addBehavior('Validation');

        $this->belongsTo('ProductTypes', [
            'foreignKey' => 'product_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'searcher_id'
        ]);
        $this->belongsTo('Administrators', [
            'foreignKey' => 'creator_id'
        ]);
        $this->belongsTo('Administrators', [
            'foreignKey' => 'modifier_id'
        ]);
        $this->hasMany('Cart', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('Favourites', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'product_id'
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
            ->notEmpty('asin')
            ->add('asin', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
            ->boolean('stock_flg')
            ->requirePresence('stock_flg', 'create')
            ->notEmpty('stock_flg');

        $validator
            ->allowEmpty('info');

        $validator
            ->allowEmpty('description');

        $validator
            ->boolean('blacklist_flg')
            ->requirePresence('blacklist_flg', 'create')
            ->notEmpty('blacklist_flg');

        $validator
            ->integer('bought_times')
            ->requirePresence('bought_times', 'create')
            ->notEmpty('bought_times');

        $validator
            ->integer('searched_times')
            ->requirePresence('searched_times', 'create')
            ->notEmpty('searched_times');

        $validator
            ->boolean('restrict_flg')
            ->requirePresence('restrict_flg', 'create')
            ->notEmpty('restrict_flg');

        $validator
            ->allowEmpty('note');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    public function validationCurl(Validator $validator)
    {
        $validator = $this->validationDefault($validator);

        $validator
            // TODO 将0写入ValidationConfig
            // 防止正则匹配失败，价格被设置为0
            ->greaterThan('price', $this->getValidationConfig('price.min'));

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
        $rules->add($rules->isUnique(['asin']));
        $rules->add($rules->existsIn(['product_type_id'], 'ProductTypes'));
        $rules->add($rules->existsIn(['searcher_id'], 'Users'));
        $rules->add($rules->existsIn(['creator_id'], 'Administrators'));
        $rules->add($rules->existsIn(['modifier_id'], 'Administrators'));

        return $rules;
    }
}
