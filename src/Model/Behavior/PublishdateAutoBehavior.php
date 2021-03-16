<?php
namespace Trois\Cms\Model\Behavior;

use ArrayObject;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Datasource\ConnectionManager;
use Cake\Validation\Validator;
use Cake\Datasource\EntityInterface;

class PublishdateAutoBehavior extends Behavior
{
  protected $_defaultConfig = [
    'published' => [
      'field' => 'published',
      'values' => [true]
    ],
    'publish_date' => 'publish_date'
  ];

  public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
  {
    // check publish_date
    $pdf = $this->getConfig('publish_date');
    if($entity->{$pdf}) return;

    // set now for publish_date
    $pf = $this->getConfig('published.field');
    if(in_array($entity->{$pf}, $this->getConfig('published.values'))) $entity->{$pdf} = new \DateTime();
  }
}
