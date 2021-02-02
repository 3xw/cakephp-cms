<?php
declare(strict_types=1);

namespace Trois\Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Articles Model
 *
 * @property \Trois\Cms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Trois\Cms\Model\Table\AttachmentsTable&\Cake\ORM\Association\BelongsToMany $Attachments
 *
 * @method \Trois\Cms\Model\Entity\Article newEmptyEntity()
 * @method \Trois\Cms\Model\Entity\Article newEntity(array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Article[] newEntities(array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Article get($primaryKey, $options = [])
 * @method \Trois\Cms\Model\Entity\Article findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Trois\Cms\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Article[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Trois\Cms\Model\Entity\Article|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Trois\Cms\Model\Entity\Article saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Trois\Cms\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Trois\Cms\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ArticlesTable extends Table
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

        $this->setTable('articles');
        $this->setDisplayField('title');
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
            'fields' => ['title']
        ]);
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Trois/Cms.Users',
        ]);
        $this->belongsToMany('Attachments', [
            'foreignKey' => 'article_id',
            'targetForeignKey' => 'attachment_id',
            'joinTable' => 'attachments_articles',
            'className' => 'Trois/Attachment.Attachments',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('status')
            ->maxLength('status', 45)
            ->notEmptyString('status');

        $validator
            ->dateTime('publish_date')
            ->requirePresence('publish_date', 'create')
            ->notEmptyDateTime('publish_date');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}