<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use ArrayObject;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Sex
 * @property \Cake\ORM\Association\BelongsTo $AccountStatuses
 * @property \Cake\ORM\Association\HasMany $Addresses
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
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Validation');

        $this->belongsTo('Sex', [
            'foreignKey' => 'sex_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('AccountStatuses', [
            'foreignKey' => 'account_status_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Addresses', [
            'foreignKey' => 'user_id'
        ]);
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
                ],
                'name' => [
                    'maxLength' => 20
                ],
                'sex' => [],
                'birthday' => [
                    'min' => Time::today()->addYears(-200),
                    'max' => Time::today()
                ],
                'postcode' => [
                    'format' => '/^\d{6}$/'
                ],
                'address' => [
                    'maxLength' => 100
                ],
                'tel' => [
                    'format' => '/^\d{1,20}$/'
                ],
                'account_status' => []
            ]);
        }

        // 用户名
        if (array_key_exists('username', $data)) {

        }

        // 邮箱
        if (array_key_exists('email', $data)) {
            // 全角英数空格转半角
            $data['email'] = mb_convert_kana($data['email'], "as");
        }

        // 密码
        if (array_key_exists('password', $data)) {

        }

        // 姓名
        if (array_key_exists('name', $data)) {
            // 全角字母空格转半角
            $data['name'] = mb_convert_kana($data['name'], "rs");
        }

        // 性别
        if (array_key_exists('sex', $data)) {
            $data['sex_id'] = $data['sex'];
            unset($data['sex']);
        }

        // 生日
        if (array_key_exists('birthday', $data)) {
            if ($data['birthday'] === '') {
                $data['birthday'] = null;
            } elseif ($this->isTimeFormat($data['birthday'], 'Ymd')) {
                $data['birthday'] = Time::createFromFormat('Ymd', $data['birthday'])->setTime(0, 0);
            }
        }

        // 邮政编码
        if (array_key_exists('postcode', $data)) {
            // 全角数字转半角
            $data['postcode'] = mb_convert_kana($data['postcode'], "n");

            // 短横杠、空格删除
            $data['postcode'] = preg_replace('/[-\s]/', '', $data['postcode']);
        }

        // 地址
        if (array_key_exists('address', $data)) {

        }

        // 电话号码
        if (array_key_exists('tel', $data)) {
            // 全角数字转半角
            $data['tel'] = mb_convert_kana($data['tel'], "n");

            // 短横杠、空格删除
            $data['tel'] = preg_replace('/[-\s]/', '', $data['tel']);
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
            ->requirePresence('secret', 'create')
            ->notEmpty('secret')
            ->add('secret', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        // 姓名
        $validator
            ->requirePresence('name', 'create')
            ->allowEmpty('name')
            ->add('name', 'maxLength', [
                'rule' => ['maxLength', $this->getValidationConfig('name.maxLength')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Name cannot be longer then {length} words!', ['length' => $this->getValidationConfig('name.maxLength')])
            ]);

        // 性别
        $validator
            ->requirePresence('sex_id', 'create')
            ->add('sex_id', 'exist', [
                'rule' => ['exist', 'Sex', 'id', 'active', []],
                'provider' => 'table',
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Please select your sex!')

            ]);

        // 生日
        $validator
            ->allowEmpty('birthday')
            ->add('birthday', 'format', [
                'rule' => function ($value) {
                    return is_null($value) || $this->isTimeFormat($value);
                },
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Invalid date format!')
            ])
            ->add('birthday', 'range', [
                'rule' => ['range', $this->getValidationConfig('birthday.min'), $this->getValidationConfig('birthday.max'), []],
                'provider' => 'table',
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Invalid date format!')
            ]);

        // 邮政编码
        $validator
            ->requirePresence('postcode', 'create')
            ->allowEmpty('postcode')
            ->add('postcode', 'format', [
                'rule' => ['custom', $this->getValidationConfig('postcode.format')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Please enter 6-digit half-size number!')
            ]);

        // 地址
        $validator
            ->requirePresence('address', 'create')
            ->allowEmpty('address')
            ->add('address', 'maxLength', [
                'rule' => ['maxLength', $this->getValidationConfig('address.maxLength')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Address cannot be longer then {length} words!', ['length' => $this->getValidationConfig('address.maxLength')])
            ]);

        // 电话号码
        $validator
            ->requirePresence('tel', 'create')
            ->allowEmpty('tel')
            ->add('tel', 'format', [
                'rule' => ['custom', $this->getValidationConfig('tel.format')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Invalid tel format!')
            ]);

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
        $rules->add($rules->existsIn(['sex_id'], 'Sex'));
        $rules->add($rules->existsIn(['account_status_id'], 'AccountStatuses'));

        return $rules;
    }

    public function findAuth(Query $query, array $options)
    {
        return parent::findAll($query, $options)
            ->select(['id', 'email', 'password'])
            ->where(['Users.account_status_id' => \App\Model\Entity\AccountStatus::STATUS_GENERAL]);
    }
}
