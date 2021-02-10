<?php
namespace Trois\Cms\Model\Behavior;

use ArrayObject;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;

/**
* DeleteRelated behavior
*/
class DeleteRelatedSectionItemBehavior extends Behavior
{
  public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options)
  {
    $SectionItems = TableRegistry::getTableLocator()->get('Trois/Cms.SectionItems');
    if($si = $SectionItems->find()
    ->where([
      'SectionItems.model' => $this->getTable()->getAlias(),
      'SectionItems.foreign_key' => $entity->id
    ])
    ->first())
    {
      if(!$SectionItems->delete($si))
      {
        $event->stopPropagation();
        return;
      }
    }
  }
}
