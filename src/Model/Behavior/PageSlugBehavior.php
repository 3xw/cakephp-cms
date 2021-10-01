<?php
namespace Trois\Cms\Model\Behavior;

use ArrayObject;

use Cake\Event\Event;
use Cake\Datasource\EntityInterface;

use Trois\Utils\ORM\Behavior\SluggableBehavior;

class PageSlugBehavior extends SluggableBehavior
{
  protected $refs = [];

  protected function getParentSlug($id, $locale = null)
  {
    $entity = $this->$refs[$id];
    if(!$entity->parent_id) return '';

    $opts = $locale? ['finder' => 'translations']: [];
    $parent = $this->getTable()->get($entity->parent_id, $opts);

    return $locale? $parent->translation($locale)->{$this->getConfig('slug')}: $parent->{$this->getConfig('slug')};
  }

  public function slug(Event $event, EntityInterface $entity, $fields, $slug)
  {
    // store for later use : )
    $this->$refs[$entity->{$this->getTable()->getPrimarykey()}] = $entity;
    parent::slug($event, $entity, $fields, $slug);
  }

  public function _generate_slug($id, $value, $locale = null )
  {
    $slug = strtolower(Text::slug($value, $this->getConfig('replacement')));
    $parentSlug = $this->getParentSlug($id, $locale);
    $slug = "$parentSlug/$slug";

    if (strlen($slug) > $this->getConfig('max_length')) $slug = substr($slug, 0, $this->getConfig('max_length'));
    return $this->_deduplicate_slug($id, $slug, $field, $locale);
  }
}
