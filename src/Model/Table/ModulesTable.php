<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modules Model
 *
 * @property \Trois\Cms\Model\Table\ModuleItemsTable&\Cake\ORM\Association\HasMany $ModuleItems
 *
 * @method \Trois\Cms\Model\Entity\Module newEmptyEntity()
 * @method \Trois\Cms\Model\Entity\Module newEntity(array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Module[] newEntities(array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Module get($primaryKey, $options = [])
 * @method \Trois\Cms\Model\Entity\Module findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Trois\Cms\Model\Entity\Module patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Module[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Module|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Trois\Cms\Model\Entity\Module saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Trois\Cms\Model\Entity\Module[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Module[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Module[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Module[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ModulesTable extends Table
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

        $this->setTable('modules');
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
        $this->addBehavior('Timestamp');

        $this->hasMany('ModuleItems', [
            'foreignKey' => 'module_id',
            'className' => 'Trois/Cms.ModuleItems',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('module_template')
            ->maxLength('module_template', 255)
            ->notEmptyString('module_template');

        return $validator;
    }
}
