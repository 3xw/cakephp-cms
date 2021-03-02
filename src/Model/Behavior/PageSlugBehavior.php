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

class PageSlugBehavior extends Behavior
{
  protected $_defaultConfig = [
    'field' => 'title',
    'fields' => [],
    'slug' => 'slug',
    'replacement' => '-',
    'max_length' => 1000,
    'connection_name' => 'default',
    'translate' => false,
    'translationTable' => 'i18n',
    'base_locale_not_in_i18n' => 'fr_CH'
  ];

  public function buildValidator(Event $event, Validator $validator, $name)
  {
    $config = $this->getConfig();
    $slug = $config['slug'];
    $validator->requirePresence($slug, false)->allowEmptyString($slug);
  }

  public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
  {
    if(!empty($entity->slug)) return;

    $slug = strtolower(Text::slug($entity->title, '-'));
    $parentSlug = !$entity->parent_id? '': $this->getTable()->get($entity->parent_id)->slug;
    $slug = "$parentSlug/$slug";

    $entity->slug = $this->_deduplicate_slug($entity->id?? -1, $slug, 'slug', null);
  }

  private function _deduplicate_slug($id, $slug, $field, $locale = null)
  {
    $config = $this->getConfig();

    $tableName = ( $locale )? $config['translationTable'] : $this->_table->getTable();
    $f = ($locale)? 'content' : $field;

    if($locale)
    {
      $query = "SELECT $f AS `slug`, CONVERT(REPLACE($f, '$slug-', ''), UNSIGNED INTEGER) AS `dupes` FROM $tableName "
        ."WHERE $f LIKE '$slug%' AND locale = '$locale' AND model = '".$this->_table->getAlias()."' AND foreign_key != $id AND field = '$field' "
        ."ORDER BY `dupes` DESC LIMIT 1 OFFSET 0";
    }else{
      $query = "SELECT $f AS `slug`, CONVERT(REPLACE($f, '$slug-', ''), UNSIGNED INTEGER) AS `dupes` FROM $tableName "
        ."WHERE $f LIKE '$slug%' AND id != $id "
        ."ORDER BY `dupes` DESC  LIMIT 1 OFFSET 0";
    }

    $conn = ConnectionManager::get($config['connection_name']);
    $result = $conn->execute($query);
    $dupes = $result->fetchAll('assoc');
    //debug(count($dupes));
    if
    (0 === count($dupes)){ return $slug; }
    else
    {
      $last = $dupes[0]['dupes'];
      $number =  (int) $last;
      $number++;

      $dupes = $config['replacement'].$number;
      $new_suffix_length = strlen($dupes);
      $slug_length = strlen($slug);
      $max_length = $config['max_length'];

      if ($new_suffix_length + $slug_length > $max_length) {
          $replace_at = -1 * $new_suffix_length;
      } else {
          $replace_at = $slug_length;
      }

      return substr_replace($slug, $dupes, $replace_at);
    }
  }
}
