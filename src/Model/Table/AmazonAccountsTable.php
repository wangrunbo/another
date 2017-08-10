<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AmazonAccounts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $AmazonAccountStatuses
 * @property \Cake\ORM\Association\BelongsTo $Administrators
 * @property \Cake\ORM\Association\BelongsTo $Administrators
 *
 * @method \App\Model\Entity\AmazonAccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\AmazonAccount newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AmazonAccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AmazonAccount|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AmazonAccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AmazonAccount[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AmazonAccount findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AmazonAccountsTable extends Table
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

        $this->setTable('amazon_accounts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('AmazonAccountStatuses', [
            'foreignKey' => 'amazon_account_status_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Administrators', [
            'foreignKey' => 'creator_id'
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->integer('balance')
            ->requirePresence('balance', 'create')
            ->notEmpty('balance');

        $validator
            ->allowEmpty('note');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['amazon_account_status_id'], 'AmazonAccountStatuses'));
        $rules->add($rules->existsIn(['creator_id'], 'Administrators'));
        $rules->add($rules->existsIn(['modifier_id'], 'Administrators'));

        return $rules;
    }
}
