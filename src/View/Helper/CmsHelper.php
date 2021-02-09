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
    return $this->cmsElem($page, 'page', $html);
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
    foreach ($sections as $section) $html .= $this->cmsElem($section, 'section', $this->elem($section, 'section'));
    return $this->getView()->Html->tag('cms-sections', $html, [':sections' => json_encode($sections), 'class' => $classes]);
  }

  public function sectionItems($items = [], $classes)
  {
    $html = '';
    foreach($items as $item) $html .= $this->articleOrModule($item);

    // regular
    if(! $this->isEditable()) return $html;

    // draggable
    return $this->getView()->Html->tag('cms-section-items', $html, [':section-items' => json_encode($items), 'class' => $classes]);
  }

  public function articleOrModule($item)
  {
    if($item->article)
    {
      // regular
      if(! $this->isEditable())  return $this->elem($item->article, 'article');

      // draggable
      $item->article->set('template', $item->template);
      return $this->cmsElem($item->article, 'article', $this->cmsEditable($item->article, 'article'));
    }
    return $this->getView()->cell($item->module->cell, [$item->module->id]);
  }

  public function elem($entity, $entityName)
  {
    return $this->getView()->element($entity->template, ["$entityName" => $entity]);
  }

  public function cmsElem($entity, $entityName, $slot)
  {
    $settings = Configure::read('Trois/Cms');
    return  $this->getView()->Html->tag(
      'cms-'.$entityName,
      $this->getView()->Html->tag('template', $slot, ['v-slot:default' => "sp"]),
      [':original-'.Inflector::dasherize($entityName) => json_encode($entity),':settings' => json_encode($settings)]
    );
  }

  public function cmsEditable($entity, $entityName)
  {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($this->elem($entity, $entityName));
    $xpath = new DOMXPath($dom);

    $e = (object) Configure::read('Trois/Cms.Editables');
    $nodes = [];
    foreach($e->suffixes as $type) foreach($xpath->query("//*/@*[name()='$e->prefix:$type']") as $domAttr) $nodes[] = (object)['type' => $type, 'domAttr' => $domAttr];
    foreach($nodes as $node) $this->domReplace($dom, $entity, $entityName, $node->type, $node->domAttr->ownerElement);
    return $dom->saveHTML($dom->documentElement);
  }

  public function domReplace($dom, $entity, $entityName, $type, $oldNode)
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
        $attributes['should-be'] = 'cms-h3';
        $attributes[':edit'] = 'sp.edit';
      }
      else $attributes[$attr->nodeName] = "$attr->nodeValue";
    }

    // load vue template
    $newNode = $dom->createDocumentFragment();
    $newNode->appendXML($this->getView()->element("editables/$type", compact('attributes')));

    // replace
    $oldNode->parentNode->replaceChild($newNode, $oldNode);
  }
}
