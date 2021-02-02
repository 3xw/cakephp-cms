<?php
namespace Trois\Cms\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;
use Cake\Routing\Router;

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

  public function sections($sections = [])
  {
    $html = '';
    if(!$this->isEditable()) foreach($sections as $section) $html .= $this->getView()->element($section->template, ['ref' => 'section-'.$section->id, 'section' => $section]);
    else
    {
      $settings = Configure::read('Trois/Cms');
      foreach($sections as $section)
      {
        $sHtml = $this->getView()->element($section->template, ['ref' => 'section-'.$section->id, 'section' => $section]);
        $html .= $this->getView()->Html->tag('cms-section', $this->getView()->Html->tag('template', $sHtml, ['v-slot:content' => '']), [':original-section' => $this->jsonEncode($section), ':settings' => $this->jsonEncode($settings)]);
      }
      $html = $this->getView()->Html->tag('cms-sections', $html, [':original-sections' => $this->jsonEncode($sections)]);
    }

    return $html;
  }

  public function sectionItems($items = [])
  {
    $html = '';
    foreach($items as $item) $html .= $this->articleOrModule($item);
    if($this->isEditable())
    {
      $settings = Configure::read('Trois/Cms');
      $html = $this->getView()->Html->tag('cms-section-items', $html, [':original-section-items' => $this->jsonEncode($items)]);
    }
    return $html;
  }

  public function articleOrModule($item)
  {
    if($item->article)
    {
      $eHtml = $this->getView()->element($item->template, ['ref' => 'artcile-'.$item->article->id, 'article' => $item->article]);
      if(!$this->isEditable()) return $eHtml;
      return $this->getView()->Html->tag('cms-article', $this->getView()->Html->tag('template', $eHtml, ['v-slot:content' => '']), [':original-article' => $this->jsonEncode($item->article)]);
    }

    return $this->getView()->cell($item->module->cell, [$item->module->id]);
  }
}
