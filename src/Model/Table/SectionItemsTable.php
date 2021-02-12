<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Table;

use ArrayObject;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use Trois\Utils\ORM\Traits\AssocationsTrait;

class SectionItemsTable extends Table
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

    $this->setTable('section_items');
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

    $this->belongsTo('Sections', [
      'foreignKey' => 'section_id',
      'joinType' => 'INNER',
      'className' => 'Trois/Cms.Sections',
    ]);

    $this->HasOneMultiBindings('Articles', [
      'className' => 'Trois/Cms.Articles',
      'foreignKey' => 'id',
      'bindingKey' => 'foreign_key',
      'multiBindings' => [
        'SectionItems.model' => 'Articles',
      ],
      'dependent' => true,
    ]);

    $this->HasOneMultiBindings('Modules', [
      'className' => 'Trois/Cms.Modules',
      'foreignKey' => 'id',
      'bindingKey' => 'foreign_key',
      'multiBindings' => [
        'SectionItems.model' => 'Modules',
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
    ->nonNegativeInteger('id')
    ->allowEmptyString('id', null, 'create');

    $validator
    ->scalar('order')
    ->maxLength('order', 45)
    ->notEmptyString('order');

    $validator
    ->scalar('model')
    ->maxLength('model', 45)
    //->requirePresence('model', 'create')
    ->allowEmptyString('model');

    $validator
    ->scalar('foreign_key')
    ->maxLength('foreign_key', 255)
    //->requirePresence('foreign_key', 'create')
    ->allowEmptyString('foreign_key');

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
    $rules->add($rules->existsIn(['section_id'], 'Sections'));

    return $rules;
  }
}
