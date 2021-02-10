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

/**
* SectionItems Model
*
* @property \Trois\Cms\Model\Table\SectionsTable&\Cake\ORM\Association\BelongsTo $Sections
*
* @method \Trois\Cms\Model\Entity\SectionItem newEmptyEntity()
* @method \Trois\Cms\Model\Entity\SectionItem newEntity(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem[] newEntities(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem get($primaryKey, $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem findOrCreate($search, ?callable $callback = null, $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem[] patchEntities(iterable $entities, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\SectionItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
*
* @mixin \Cake\ORM\Behavior\TimestampBehavior
*/
class SectionItemsTable extends Table
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

    $this->HasOne('Articles', [
      'foreignKey' => 'id',
      'bindingKey' => 'foreign_key',
      'className' => 'Trois/Cms.Articles',
      'conditions' => [
        'SectionItems.model' => 'Articles'
      ],
    ]);

    $this->HasOne('Modules', [
      'foreignKey' => 'id',
      'bindingKey' => 'foreign_key',
      'conditions' => [
        'SectionItems.model' => 'Modules'
      ],
    ]);
  }

  /*
  public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options)
  {
    foreach([$this->Articles, $this->Modules] as $Model)
    {
      $alias = $Model->getAlias();
      if($m = $Model->find()
      ->where([ "$alias.id" => $entity->foreign_key])
      ->first())
      {
        if(!$Model->delete($m))
        {
          $event->stopPropagation();
          return;
        }
      }
    }
  }
  */

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
    $rules->add($rules->existsIn(['section_id'], 'Sections'));

    return $rules;
  }
}
