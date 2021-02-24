<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
* Pages Model
*
* @property \Trois\Cms\Model\Table\PagesTable&\Cake\ORM\Association\BelongsTo $ParentPages
* @property \Trois\Cms\Model\Table\PagesTable&\Cake\ORM\Association\HasMany $ChildPages
* @property \Trois\Cms\Model\Table\SectionsTable&\Cake\ORM\Association\HasMany $Sections
* @property \Trois\Cms\Model\Table\AttachmentsTable&\Cake\ORM\Association\BelongsToMany $Attachments
*
* @method \Trois\Cms\Model\Entity\Page newEmptyEntity()
* @method \Trois\Cms\Model\Entity\Page newEntity(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Page[] newEntities(array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Page get($primaryKey, $options = [])
* @method \Trois\Cms\Model\Entity\Page findOrCreate($search, ?callable $callback = null, $options = [])
* @method \Trois\Cms\Model\Entity\Page patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Page[] patchEntities(iterable $entities, array $data, array $options = [])
* @method \Trois\Cms\Model\Entity\Page|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\Page saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
* @method \Trois\Cms\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
* @method \Trois\Cms\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
*
* @mixin \Cake\ORM\Behavior\TreeBehavior
*/
class PagesTable extends Table
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

    $this->setTable('pages');
    $this->setDisplayField('title');
    $this->setPrimaryKey('id');

    $this->belongsTo('ParentPages', [
      'className' => 'Trois/Cms.Pages',
      'foreignKey' => 'parent_id',
    ]);
    $this->hasMany('ChildPages', [
      'className' => 'Trois/Cms.Pages',
      'foreignKey' => 'parent_id',
      'sort' => ['ChildPages.lft' => 'ASC']
    ]);
    $this->hasMany('Sections', [
      'className' => 'Trois/Cms.Sections',
      'foreignKey' => 'page_id',
      'className' => 'Trois/Cms.Sections',
      'sort' => ['Sections.order' => 'ASC']
    ]);
    $this->belongsToMany('Attachments', [
      'className' => 'Trois/Attachment.Attachments',
      'foreignKey' => 'page_id',
      'targetForeignKey' => 'attachment_id',
      'joinTable' => 'attachments_pages',
    ]);

    // vendor behaviors
    $this->addBehavior('Search.Search');
    $this->searchManager()
    ->add('q', 'Search.Like', [
      'before' => true,
      'after' => true,
      'mode' => 'or',
      'comparison' => 'LIKE',
      'wildcardAny' => '*',
      'wildcardOne' => '?',
      'fields' => ['title','meta','header','body']
    ]);

    // native behaviors
    $this->addBehavior('Timestamp');
    $this->addBehavior('Tree');

    // Behaviors from CMS settings...
    if($behaviors = Configure::read('Trois/Cms.Models.Pages.behaviors')) foreach ($behaviors as $behavior => $settings) $this->addBehavior($behavior, $settings);
    else $this->addBehavior(\Trois\Utils\ORM\Behavior\SluggableBehavior::class, ['field' => 'title','translate' => false]);
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
    ->scalar('title')
    ->maxLength('title', 255)
    ->requirePresence('title', 'create')
    ->notEmptyString('title');

    $validator
    ->scalar('slug')
    ->maxLength('slug', 255)
    ->requirePresence('slug', 'create')
    ->notEmptyString('slug');

    $validator
    ->scalar('meta')
    ->maxLength('meta', 255)
    ->allowEmptyString('meta');

    $validator
    ->scalar('header')
    ->allowEmptyString('header');

    $validator
    ->scalar('body')
    ->allowEmptyString('body');

    $validator
    ->scalar('page_template')
    ->maxLength('page_template', 255)
    ->notEmptyString('page_template');

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
    $rules->add($rules->existsIn(['parent_id'], 'ParentPages'));

    return $rules;
  }
}
