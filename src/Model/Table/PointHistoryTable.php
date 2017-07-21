<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PointHistory Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $PointCalculations
 * @property \Cake\ORM\Association\BelongsTo $PointTypes
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\BelongsTo $Administrators
 *
 * @method \App\Model\Entity\PointHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\PointHistory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PointHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PointHistory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PointHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PointHistory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PointHistory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \App\Model\Behavior\SoftDeleteBehavior
 */
class PointHistoryTable extends Table
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

        $this->setTable('point_history');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('SoftDelete');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PointCalculations', [
            'foreignKey' => 'point_calculation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PointTypes', [
            'foreignKey' => 'point_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id'
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
            ->integer('point')
            ->requirePresence('point', 'create')
            ->notEmpty('point');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['point_calculation_id'], 'PointCalculations'));
        $rules->add($rules->existsIn(['point_type_id'], 'PointTypes'));
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['modifier_id'], 'Administrators'));

        return $rules;
    }
}
