<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Event\Event;
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
 * @property \Cake\ORM\Association\HasMany $ProductImages
 * @property \Cake\ORM\Association\HasMany $ProductInfo
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

    protected $_rules = [
        'price' => [
            'min' => 0
        ]
    ];

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
        $this->hasMany('ProductImages', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('ProductInfo', [
            'foreignKey' => 'product_id'
        ]);
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        $this->setValidationConfig([
            'price' => [
                'min' => 0
            ]
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
            ->notEmpty('asin')
            ->add('asin', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->notEmpty('name');

        $validator
            ->integer('price')
            ->notEmpty('price');

        $validator
            ->allowEmpty('standard');

        $validator
            ->dateTime('sale_start_date')
            ->allowEmpty('sale_start_date');

        $validator
            ->boolean('stock_flg')
            ->notEmpty('stock_flg');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('introduction');

        $validator
            ->boolean('blacklist_flg')
            ->notEmpty('blacklist_flg');

        $validator
            ->integer('bought_times')
            ->notEmpty('bought_times');

        $validator
            ->integer('searched_times')
            ->notEmpty('searched_times');

        $validator
            ->boolean('restrict_flg')
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
