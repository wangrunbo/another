<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use ArrayObject;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \App\Model\Behavior\ValidationBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Validation');
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if ($options['validate']) {
            $this->setValidationConfig([
                'username' => [
                    'maxLength' => 20
                ],
                'email' => [
                    'maxLength' => 100
                ],
                'password' => [
                    'format' => '/^(?=.*\d)(?=.*[A-Za-z])[A-Za-z0-9]{8,20}$/'
                ]
            ]);
        }

        // 用户名
        if (array_key_exists('username', $data)) {

        }

        // 邮箱
        if (array_key_exists('email', $data)) {
            // 全角英数字转半角
            $data['email'] = mb_convert_kana($data['email'], "as");
        }

        // 密码
        if (array_key_exists('password', $data)) {

        }
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

        // 用户名
        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username', __d($this->getValidationConfig('locale'), 'Username cannot be left empty!'))
            ->add('username', 'maxLength', [
                'rule' => ['maxLength', $this->getValidationConfig('username.maxLength')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Username cannot be longer then {length} words!', ['length' => $this->getValidationConfig('username.maxLength')])
            ])
            ->add('username', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'This username had been used!')
            ]);

        // 邮箱
        $validator
            ->requirePresence('email', 'create')
            ->notEmpty('email', __d($this->getValidationConfig('locale'), 'Email cannot be left empty!'))
            ->add('email', 'maxLength', [
                'rule' => ['maxLength', $this->getValidationConfig('email.maxLength')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Email cannot be longer then {length} words!', ['length' => $this->getValidationConfig('email.maxLength')])
            ])
            ->add('email', 'format', [
                'rule' => 'email',
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'This email cannot be used!')
            ])
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'This email cannot be used!')
            ]);

        // 密码
        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', __d($this->getValidationConfig('locale'), 'Password cannot be left empty!'))
            ->add('password', 'format', [
                'rule' => ['custom', $this->getValidationConfig('password.format')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Please enter 8~20-digit half-size alphanumeric characters! At least one alphabet and one numeral should be contained!')
            ]);

        // 密码确认
        $validator
            ->notEmpty('password_confirm', __d($this->getValidationConfig('locale'), 'Please entry the password again!'))
            ->add('password_confirm', 'format', [
                'rule' => ['compareWith', 'password'],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'The twice entered password is inconsistent!')
            ]);

        // 密钥
        $validator
            ->notEmpty('secret')
            ->add('secret', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['secret']));

        return $rules;
    }
}
