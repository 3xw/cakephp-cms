<?php
namespace Trois\Cms\View\Helper;

use \DOMDocument;
use \DOMXPath;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

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
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadXML($html);
    list($node, $attributes) = $this->extractRemoveAttributes($dom->documentElement);
    $html = $dom->saveHTML($dom->documentElement);

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
      $html = $this->elem($entity, $entityName);
    }
    return $html;
  }

  public function extractRemoveAttributes(\DOMElement $node): Array
  {
    $attributes = [];
    $renamed = $node->ownerDocument->createElement('div');
    foreach ($node->attributes as $attribute) $attributes[$attribute->nodeName] = $attribute->nodeValue;
    while ($node->firstChild) $renamed->appendChild($node->firstChild);
    return [$node->parentNode->replaceChild($renamed, $node), $attributes];
  }

  public function cmsEditable($entity, $entityName)
  {
    // create right elmem
    $html = $entityName == 'article'? $this->elem($entity, $entityName): $this->getView()->cell($entity->cell, [$entity->id]);

    // dom stuff
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadXML($html);
    $xpath = new DOMXPath($dom);

    $e = (object) Configure::read('Trois/Cms.Editables');
    $nodes = [];
    foreach($e->suffixes as $type) foreach($xpath->query("//*/@*[name()='$e->prefix:$type']") as $domAttr) $nodes[] = (object)['type' => $type, 'domAttr' => $domAttr];
    foreach($nodes as $node) $this->cmsReplaceEditable($dom, $entity, $entityName, $node->type, $node->domAttr->ownerElement);
    return $dom->saveHTML($dom->documentElement);
  }

  public function cmsReplaceEditable($dom, $entity, $entityName, $type, $oldNode)
  {
    // copy attributes collect Field
    $attributes = [];
    foreach ($oldNode->attributes as $attr)
    {
      if($attr->nodeName == "cms:$type")
      {
        $attributes['model-store-name'] = Inflector::pluralize(Inflector::underscore($entityName));
        $attributes['model-field'] = "$attr->nodeValue";
        $attributes['model-id'] = $entity->id;
        $attributes['elem'] = strtolower($oldNode->nodeName);
        $attributes[':edit'] = 'sp.edit';
      }
      else $attributes[$attr->nodeName] = "$attr->nodeValue";
    }

    // load vue template
    $newNode = $dom->createDocumentFragment();
    try {
      $html = $this->getView()->element("editables/$type", compact('attributes'));
    } catch (\Exception $e) {
      $html = $this->getView()->element("Trois/Cms.editables/$type", compact('attributes'));
    }
    $newNode->appendXML($html);

    // replace
    $oldNode->parentNode->replaceChild($newNode, $oldNode);
  }
}
