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
 * Addresses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Administrators
 *
 * @method \App\Model\Entity\Address get($primaryKey, $options = [])
 * @method \App\Model\Entity\Address newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Address[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Address|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Address patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Address[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Address findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \App\Model\Behavior\ValidationBehavior
 * @mixin \App\Model\Behavior\SoftDeleteBehavior
 */
class AddressesTable extends Table
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

        $this->setTable('addresses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Validation');
        $this->addBehavior('SoftDelete');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Administrators', [
            'foreignKey' => 'modifier_id'
        ]);
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if ($options['validate']) {
            $this->setValidationConfig([
                'label' => [
                    'maxLength' => 20
                ],
                'name' => [
                    'maxLength' => 20
                ],
                'postcode' => [
                    'format' => '/^\d{6}$/'
                ],
                'address' => [
                    'maxLength' => 100
                ],
                'tel' => [
                    'format' => '/^\d{1,20}$/'
                ]
            ]);
        }

        // 标签
        if (array_key_exists('label', $data)) {

        }

        // 姓名
        if (array_key_exists('name', $data)) {
            // 全角字母空格转半角
            $data['name'] = mb_convert_kana($data['name'], "rs");
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

        $validator
            ->notEmpty('label', __d($this->getValidationConfig('locale'), 'Label cannot be left empty!'))
            ->add('label', 'maxLength', [
                'rule' => ['maxLength', $this->getValidationConfig('label.maxLength')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Label cannot be longer then {length} words!', ['length' => $this->getValidationConfig('label.maxLength')])
            ]);

        $validator
            ->notEmpty('name', __d($this->getValidationConfig('locale'), 'Name cannot be left empty!'))
            ->add('name', 'maxLength', [
                'rule' => ['maxLength', $this->getValidationConfig('name.maxLength')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Name cannot be longer then {length} words!', ['length' => $this->getValidationConfig('name.maxLength')])
            ]);

        $validator
            ->notEmpty('postcode', __d($this->getValidationConfig('locale'), 'Postcode cannot be left empty!'))
            ->add('postcode', 'format', [
                'rule' => ['custom', $this->getValidationConfig('postcode.format')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Please enter 6-digit half-size number!')
            ]);

        $validator
            ->notEmpty('address', __d($this->getValidationConfig('locale'), 'Address cannot be left empty!'))
            ->add('address', 'maxLength', [
                'rule' => ['maxLength', $this->getValidationConfig('address.maxLength')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Address cannot be longer then {length} words!', ['length' => $this->getValidationConfig('address.maxLength')])
            ]);

        $validator
            ->notEmpty('tel', __d($this->getValidationConfig('locale'), 'Tel cannot be left empty!'))
            ->add('tel', 'format', [
                'rule' => ['custom', $this->getValidationConfig('tel.format')],
                'last' => true,
                'message' => __d($this->getValidationConfig('locale'), 'Invalid tel format!')
            ]);

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
        $rules->add($rules->existsIn(['modifier_id'], 'Administrators'));

        return $rules;
    }
}
