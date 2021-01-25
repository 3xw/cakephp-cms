<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sections Model
 *
 * @property \Trois\Cms\Model\Table\PagesTable&\Cake\ORM\Association\BelongsTo $Pages
 * @property \Trois\Cms\Model\Table\SectionItemsTable&\Cake\ORM\Association\HasMany $SectionItems
 *
 * @method \Trois\Cms\Model\Entity\Section newEmptyEntity()
 * @method \Trois\Cms\Model\Entity\Section newEntity(array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Section[] newEntities(array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Section get($primaryKey, $options = [])
 * @method \Trois\Cms\Model\Entity\Section findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Trois\Cms\Model\Entity\Section patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Section[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Section|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Trois\Cms\Model\Entity\Section saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Trois\Cms\Model\Entity\Section[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Section[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Section[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Section[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SectionsTable extends Table
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

        $this->setTable('sections');
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

        $this->belongsTo('Pages', [
            'foreignKey' => 'page_id',
            'joinType' => 'INNER',
            'className' => 'Trois/Cms.Pages',
        ]);
        $this->hasMany('SectionItems', [
            'foreignKey' => 'section_id',
            'className' => 'Trois/Cms.SectionItems',
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
            ->scalar('section_template')
            ->maxLength('section_template', 255)
            ->notEmptyString('section_template');

        $validator
            ->nonNegativeInteger('order')
            ->notEmptyString('order');

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
        $rules->add($rules->existsIn(['page_id'], 'Pages'));

        return $rules;
    }
}
