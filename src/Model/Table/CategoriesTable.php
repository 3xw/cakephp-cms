<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Categories Model
*
* @property \Trois\Cms\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $ParentCategories
* @property \Trois\Cms\Model\Table\CategoriesTable&\Cake\ORM\Association\HasMany $ChildCategories
* @property \Trois\Cms\Model\Table\FaqsTable&\Cake\ORM\Association\BelongsToMany $Faqs
*
* @method \Trois\Cms\Model\Entity\Category newEmptyEntity()
* @method \Trois\Cms\Model\Entity\Category newEntity(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Category[] newEntities(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Category get($primaryKey, $options = [])
* @method \Trois\Cms\Model\Entity\Category findOrCreate($search, ?callable $callback = null, $options = [])
* @method \Trois\Cms\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Category[] patchEntities(iterable $entities, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Category|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\Category saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
*
* @mixin \Cake\ORM\Behavior\TimestampBehavior
*/
class CategoriesTable extends Table
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

    $this->setTable('categories');
    $this->setDisplayField('name');
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
      'fields' => ['name']
    ]);

    $this->belongsTo('ParentCategories', [
      'className' => 'Trois/Cms.Categories',
      'foreignKey' => 'parent_id',
    ]);
    $this->hasMany('ChildCategories', [
      'className' => 'Trois/Cms.Categories',
      'foreignKey' => 'parent_id',
    ]);
    $this->belongsToMany('Faqs', [
      'foreignKey' => 'category_id',
      'targetForeignKey' => 'faq_id',
      'joinTable' => 'categories_faqs',
      'className' => 'Trois/Cms.Faqs',
    ]);

    $this->belongsToMany('Attachments', [
      'foreignKey' => 'category_id',
      'targetForeignKey' => 'attachment_id',
      'joinTable' => 'attachments_categories',
      'className' => 'Trois/Attachment.Attachments',
      'sort' => 'AttachmentsCategories.order ASC'
    ]);

    $this->belongsToMany('Articles', [
      'className' => 'Trois/Cms.Articles',
      'foreignKey' => 'category_id',
      'targetForeignKey' => 'article_id',
      'joinTable' => 'categories_articles'
    ]);

    $this->addBehavior('Timestamp');
    $this->addBehavior('Tree');

    // Behaviors from CMS settings...
    if($behaviors = Configure::read('Trois/Cms.Models.Categories.behaviors')) foreach ($behaviors as $behavior => $settings) $this->addBehavior($behavior, $settings);
    else $this->addBehavior(\Trois\Utils\ORM\Behavior\SluggableBehavior::class, ['field' => 'name','translate' => false]);
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
    ->scalar('name')
    ->maxLength('name', 255)
    ->requirePresence('name', 'create')
    ->notEmptyString('name');

    $validator
    ->scalar('slug')
    ->maxLength('slug', 255)
    ->requirePresence('slug', 'create')
    ->notEmptyString('slug');

    $validator
    ->scalar('category_template')
    ->maxLength('category_template', 45)
    ->notEmptyString('category_template');

    $validator
    ->scalar('meta')
    ->allowEmptyString('meta');

    $validator
    ->scalar('header')
    ->allowEmptyString('header');

    $validator
    ->scalar('body')
    ->allowEmptyString('body');

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
    $rules->add($rules->existsIn(['parent_id'], 'ParentCategories'));

    return $rules;
  }
}
