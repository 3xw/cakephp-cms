<?php
namespace Trois\Cms\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use PHPHtmlParser\Dom;

class CmsHelper extends Helper
{

  public function isEditable($what = 'page')
  {
    return true;
  }

  public function page($page)
  {
    $html = $this->elem($page, 'page');

    // regular
    if(! $this->isEditable()) return $html;

    // draggable
    return $this->cmsControls($page, 'page');
  }

  public function sections($sections = [], $classes)
  {
    $html = '';

    // regular
    if(!$this->isEditable())
    {
      foreach ($sections as $section) $html .= $this->elem($section, 'section');
      return $this->getView()->Html->tag('div', $html, ['class' => $classes]);
    }

    // draggable
    $ids = [];
    foreach ($sections as $section)
    {
      $ids[] = $section->id;
      $html .= $this->cmsControls($section, 'section');
    }
    $attributes = [
      'class' => $classes,
      'model-store-name' => 'sections',
      'model-field' => 'order',
      ':model-ids' => json_encode($ids)
    ];
    return $this->getView()->Html->tag('cms-draggable', $html, $attributes);
  }

  public function sectionItems($items = [], $classes)
  {
    $html = '';
    $ids = [];
    foreach($items as $item)
    {
      $ids[] = $item->id;
      $html .= $this->articleOrModule($item);
    }

    // regular
    if(! $this->isEditable()) return $html;

    // draggable
    $attributes = [
      'class' => $classes,
      'model-store-name' => 'section_items',
      'model-field' => 'order',
      ':model-ids' => json_encode($ids)
    ];
    return $this->getView()->Html->tag('cms-draggable', $html, $attributes);
  }

  public function articleOrModule($item)
  {
    if($item->article)
    {
      // global
      $item->article->set('template', $item->template);

      // regular
      if(! $this->isEditable())  return $this->elem($item->article, 'article');

      // cmsize
      return $this->cmsControls($item->article, 'article', $item);
    }

    // regular
    if(! $this->isEditable()) return $this->getView()->cell($item->module->cell, [$item->module->id]);

    // cmsize
    return $this->cmsControls($item->module, 'module', $item);
  }

  public function elem($entity, $entityName)
  {
    $attributes = [
      'model-store-name' => Inflector::pluralize(Inflector::underscore($entityName)),
      'model-id' =>$entity->id
    ];
    return $this->getView()->element($entity->template, ["$entityName" => $entity]);
  }

  public function cmsControls($entity, $entityName, $sectionItem = null)
  {
    // create cms inner html
    $html = $this->getCmsInnerHtml($entity, $entityName);

    // extract element & attributes
    $dom = new Dom;
    $dom->loadStr($html);
    $elem = $dom->find('*')[0];
    $attributes = $elem->getAttributes();
    $html = "<div>$elem->innerHtml</div>";

    // attr
    $attributes = array_merge($attributes,[
      ':settings' => json_encode(Configure::read('Trois/Cms')),
      'model-store-name' => Inflector::pluralize(Inflector::underscore($entityName)),
      'model-id' => $entity->id
    ]);
    if($sectionItem) $attributes['section-item-id'] = $sectionItem->id;

    $html = $this->getView()->Html->tag('template', $html, ['v-slot:default' => "sp"]);
    return  $this->getView()->Html->tag('cms-'.$entityName, $html, $attributes );
  }

  public function getCmsInnerHtml($entity, $entityName)
  {
    switch($entityName)
    {
      case 'article':
      case 'module';
      $html =  $this->cmsEditable($entity, $entityName);
      break;

      default:
      $html = $this->cmsEditable($entity, $entityName);
    }
    return $html;
  }

  public function cmsEditable($entity, $entityName)
  {
    // create right elmem
    $html = $entityName == 'module'? $this->getView()->cell($entity->cell, [$entity->id]): $this->elem($entity, $entityName);

    // dom stuff
    $dom = new Dom;
    $dom->loadStr($html);

    // findReplace
    $e = (object) Configure::read('Trois/Cms.Editables');
    foreach($e->suffixes as $type) foreach($dom->find("*[$e->prefix:$type]") as $node) $this->cmsReplaceEditable($e->prefix, $type, $node, $entity, $entityName);

    return $dom->outerHtml;
  }

  public function cmsReplaceEditable($prefix, $type, $node, $entity, $entityName)
  {
    // find replace attribute
    $field = $node->getAttribute("$prefix:$type");
    $node->removeAttribute("$prefix:$type");

    // copy attributes collect Field
    $attributes = array_merge(
      $node->getAttributes(),
      [
        'model-store-name' => Inflector::pluralize(Inflector::underscore($entityName)),
        'model-field' => $field,
        'model-id' => $entity->id,
        'elem' => $node->getTag()->name(),
        ':edit' => 'sp.edit'
      ]
    );

    // load vue template
    try {
      $html = $this->getView()->element("editables/$type", compact('attributes','entity','entityName','field'));
    } catch (\Exception $e) {
      $html = $this->getView()->element("Trois/Cms.editables/$type", compact('attributes','entity','entityName','field'));
    }
    if(empty($html)) return;
    $newNode = (new Dom)->loadStr($html)->find('*')[0];

    // replace
    $parent = $node->getParent();
    $parent->replaceChild($node->id(),$newNode);
  }
}
