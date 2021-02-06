<?php
namespace Trois\Cms\View\Helper;

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
      return $this->cmsElem($item->article, 'article', $this->elem($item, 'article'));
    }
    return $this->getView()->cell($item->module->cell, [$item->module->id]);
  }

  public function elem($itm, $kind)
  {
    return $this->getView()->element($itm->template, ['key' => "$kind-$itm->id", "$kind" => $itm]);
  }

  public function cmsElem($itm, $kind, $slot)
  {
    $settings = Configure::read('Trois/Cms');
    return  $this->getView()->Html->tag('cms-'.$kind, $slot, [':original-'.Inflector::dasherize($kind) => json_encode($itm),':settings' => json_encode($settings)]);
  }
}
