<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Trois\Utils\ORM\Traits\AssocationsTrait;

/**
* Metas Model
*
* @method \Trois\Cms\Model\Entity\Meta newEmptyEntity()
* @method \Trois\Cms\Model\Entity\Meta newEntity(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Meta[] newEntities(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Meta get($primaryKey, $options = [])
* @method \Trois\Cms\Model\Entity\Meta findOrCreate($search, ?callable $callback = null, $options = [])
* @method \Trois\Cms\Model\Entity\Meta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Meta[] patchEntities(iterable $entities, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Meta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\Meta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\Meta[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Meta[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Meta[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Meta[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
*/
class MetasTable extends Table
{
  use AssocationsTrait;
  /**
  * Initialize method
  *
  * @param array $config The configuration for the Table.
  * @return void
  */
  public function initialize(array $config): void
  {
    parent::initialize($config);

    $this->setTable('metas');
    $this->setDisplayField('value');
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

    $this->HasOneMultiBindings('Articles', [
      'className' => 'Trois/Cms.Articles',
      'foreignKey' => 'id',
      'bindingKey' => 'foreign_key',
      'multiBindings' => [
        'Metas.model' => 'Articles',
      ],
      'dependent' => true,
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
    ->allowEmptyString('id', null, 'create');

    $validator
    ->scalar('model')
    ->maxLength('model', 255)
    ->requirePresence('model', 'create')
    ->notEmptyString('model');

    $validator
    ->scalar('foreign_key')
    ->requirePresence('foreign_key', 'create')
    ->notEmptyString('foreign_key');

    $validator
    ->scalar('key')
    ->maxLength('key', 255)
    ->requirePresence('key', 'create')
    ->notEmptyString('key');

    return $validator;
  }
}
