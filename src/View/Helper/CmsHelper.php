<?php
namespace Trois\Cms\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

class CmsHelper extends Helper
{
  public function jsonEncode($data)
  {
    $escaped_data = json_encode( $data, JSON_HEX_QUOT|JSON_HEX_APOS );
    $escaped_data = str_replace("\u0022", "\\\"", $escaped_data );
    $escaped_data = str_replace("\u0027", "\\'",  $escaped_data );
    return $escaped_data;
  }

  public function isEditable($what = 'page')
  {
    return true;
  }

  public function controls($type, $item)
  {
    if(!$this->isEditable()) return '';
    $settings = Configure::read('Trois/Cms');
    return  $this->getView()->Html->tag('cms-'.$type,' ', [':original'.Inflector::dasherize($type) => json_encode($item),':settings' => json_encode($settings)]);
  }

  public function sections($sections = [])
  {
    $html = '';
    foreach ($sections as $section) $html .= $this->getView()->element($section->template, ['ref' => 'section-'.$section->id, 'section' => $section]);
    if(!$this->isEditable()) return $html;
    return $this->getView()->Html->tag('cms-sections', $html);
  }

  public function sectionItems($items = [])
  {
    $html = '';
    foreach($items as $item) $html .= $this->articleOrModule($item);
    if(! $this->isEditable()) return $html;
    return $this->getView()->Html->tag('cms-section-items', $html);
  }

  public function articleOrModule($item)
  {
    if($item->article) return $this->getView()->element($item->template, ['ref' => 'artcile-'.$item->article->id, 'article' => $item->article]);
    return $this->getView()->cell($item->module->cell, [$item->module->id]);
  }
}
