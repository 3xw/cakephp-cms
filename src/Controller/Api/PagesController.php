<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Api;

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
  use \Crud\Controller\ControllerTrait;

  public function initialize():void
  {
    parent::initialize();
    $this->loadComponent('Crud.Crud', [
      'actions' => [
        'index' => [
          'className' => 'Crud.Index',
        ],
        'view' => [
          'className' => 'Crud.View',
        ],
        'add' =>[
          'className' => 'Trois/Utils.Add',
          'api.error.exception' => [
            'type' => 'validate',
            'class' => 'Trois\Attachment\Crud\Error\Exception\ValidationException'
          ],
        ],
        'edit' =>[
          'className' => 'Trois/Utils.Edit',
          'api.error.exception' => [
            'type' => 'validate',
            'class' => 'Trois\Attachment\Crud\Error\Exception\ValidationException'
          ],
        ],
        'delete' => [
          'className' => 'Crud.Delete',
        ]
      ],
      'listeners' => [
        //'CrudCache',
        'Crud.Api',
        'Crud.ApiPagination',
        'Crud.ApiQueryLog',
        'Crud.Search'
      ]
    ]);
  }

  public function view($id)
  {
    $this->Crud->on('beforeFind', function(\Cake\Event\Event $event) {
      $event->getSubject()->query
      ->contain([
        'Attachments',
        'Sections' => [
          'SectionItems' => [
            'Articles' => ['Attachments'],
            'Modules'
          ]
        ]
      ]);
    });
    return $this->Crud->execute();
  }
}
