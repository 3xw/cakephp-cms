<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Api;

use Trois\Cms\Controller\AppController;

/**
* Sections Controller
*
* @property \Trois\Cms\Model\Table\SectionsTable $Sections
*
* @method \Trois\Cms\Model\Entity\Section[] paginate($object = null, array $settings = [])
*/
class SectionsController extends AppController
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
          'className' => 'Crud.Add',
          //'api.success.data.entity' => ['id','profile','path','type','subtype','name','size','fullpath', 'date'],
          'api.error.exception' => [
            'type' => 'validate',
            'class' => 'Trois\Attachment\Crud\Error\Exception\ValidationException'
          ],
        ],
        'edit' => [
          'className' => 'Crud.Edit',
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
        'SectionItems' => [
          'Articles' => ['Attachments'],
          'Modules'
        ]
      ]);
    });
    return $this->Crud->execute();
  }
}
