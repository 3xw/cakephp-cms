<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* ModuleItems Model
*
* @property \Trois\Cms\Model\Table\ModulesTable&\Cake\ORM\Association\BelongsTo $Modules
*
* @method \Trois\Cms\Model\Entity\ModuleItem newEmptyEntity()
* @method \Trois\Cms\Model\Entity\ModuleItem newEntity(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem[] newEntities(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem get($primaryKey, $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem findOrCreate($search, ?callable $callback = null, $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem[] patchEntities(iterable $entities, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\ModuleItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
*
* @mixin \Cake\ORM\Behavior\TimestampBehavior
*/
class ModuleItemsTable extends Table
{
  /**
  * Initialize method
  *
  * @param array $config The configuration for the Table.
  * @return void
  */
  public function initialize(array $config): void
  {
    parent::initialize($config);

    $this->setTable('module_items');
    $this->setDisplayField('id');
    $this->setPrimaryKey('id');
    $this->addBehavior('Search.Search');
    $this->searchManager()
    ->add('q', 'Search.Like', [
      'before' => true,
      'after' => true,
      'mode' => 'or',
      'comparison' => 'LIKE',
      'wildcardAny' => '*',
      'wildcardOne' => '?',
      'fields' => ['id']
    ]);
    $this->addBehavior('Timestamp');

    $this->belongsTo('Modules', [
      'foreignKey' => 'module_id',
      'joinType' => 'INNER',
      'className' => 'Trois/Cms.Modules',
    ]);
  }

  /**
  * Default validation rules.
  *
  * @param \Cake\Validation\Validator $validator Validator instance.
  * @return \Cake\Validation\Validator
  */
  public function validationDefault(Validator $validator): Validator
  {
    $validator
    ->nonNegativeInteger('id')
    ->allowEmptyString('id', null, 'create');

    $validator
    ->integer('order')
    ->notEmptyString('order');

    $validator
    ->scalar('model')
    ->maxLength('model', 45)
    ->requirePresence('model', 'create')
    ->notEmptyString('model');

    $validator
    ->scalar('foreign_key')
    ->maxLength('foreign_key', 255)
    ->requirePresence('foreign_key', 'create')
    ->notEmptyString('foreign_key');

    $validator
    ->scalar('meta')
    ->allowEmptyString('meta');

    return $validator;
  }

  /**
  * Returns a rules checker object that will be used for validating
  * application integrity.
  *
  * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
  * @return \Cake\ORM\RulesChecker
  */
  public function buildRules(RulesChecker $rules): RulesChecker
  {
    $rules->add($rules->existsIn(['module_id'], 'Modules'));

    return $rules;
  }
}
