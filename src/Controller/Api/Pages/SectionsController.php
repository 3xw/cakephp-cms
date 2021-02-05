<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Api\Pages;

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
        'view' => [
          'className' => 'Crud.View',
        ],
        'add' =>[
          'className' => 'Trois/Utils.Add',
        ],
        'edit' =>[
          'className' => 'Trois/Utils.Edit',
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

  public function add()
  {
    $this->Crud->on('beforeMarshal', function(\Cake\Event\Event $event)
    {
      $event->getSubject()->data['page_id'] = $this->request->getParam('page_id');
    });

    /*
    $this->Crud->on('afterSave', function(\Cake\Event\Event $event) {
      debug($event->getSubject());
    });
    */
    
    return $this->Crud->execute();
  }

  public function edit($id)
  {
    $this->Crud->on('beforeMarshal', function(\Cake\Event\Event $event)
    {
      $event->getSubject()->data['page_id'] = $this->request->getParam('page_id');
    });

    return $this->Crud->execute();
  }
}
