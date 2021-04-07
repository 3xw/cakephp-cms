<?php
declare(strict_types=1);

namespace Trois\Cms\Controller;

use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\Http\Exception\NotFoundException;
use Trois\Cms\Controller\AppController;

/**
* Pages Controller
*
* @property \Trois\Cms\Model\Table\PagesTable $Pages
*
* @method \Trois\Cms\Model\Entity\Page[] paginate($object = null, array $settings = [])
*/
class PagesController extends AppController
{
  public function initialize():void
  {
    parent::initialize();
    $this->loadModel(Configure::read('Trois/Cms.Models.Pages'));
  }

  public function view( ...$slug)
  {
    // if empty $image
    if(empty($slug)){ throw new NotFoundException(); }
    $slug = implode("/", $slug);

    $this->loadModel('Trois/Cms.Pages');

    $lng = I18n::getLocale();
    $slugField = $lng == 'fr_CH'? 'Pages.slug' : 'Pages_slug_translation.content';
    if(property_exists($this->Pages, 'setLocale')) $this->Pages->setLocale($lng);

    if(!$page = $this->Pages->find()
    ->where(["$slugField IN" => [$slug, "/$slug"]])
    ->contain([
      'ParentPages',
      'ChildPages',
      'Attachments',
      'Sections' => [
        'SectionItems' => [
          'Articles' => ['Attachments', 'Metas'],
          'Modules'
        ]
      ]
    ])
    ->first()) throw new NotFoundException();

    $this->set('title', $page->title);
    $this->set('meta', $page->meta);
    $this->set(compact('page'));

  }
}
