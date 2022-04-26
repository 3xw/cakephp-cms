<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Api\Pages\Sections;

use Cake\Core\Configure;
use Trois\Cms\Controller\AppController;

/**
* SectionItems Controller
*
* @property \Trois\Cms\Model\Table\SectionItemsTable $SectionItems
*
* @method \Trois\Cms\Model\Entity\SectionItem[] paginate($object = null, array $settings = [])
*/
class SectionItemsController extends AppController
{
  use \Crud\Controller\ControllerTrait;

  public function fetchTable(?string $alias = null, array $options = []):\Cake\Orm\Table
  {
    return $this->loadModel(Configure::read('Trois/Cms.Models.SectionItems'));
  }

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
          //'api.success.data.entity' => ['id','profile','path','type','subtype','name','size','fullpath', 'date'],
          'api.error.exception' => [
            'type' => 'validate',
            'class' => 'Trois\Attachment\Crud\Error\Exception\ValidationException'
          ],
        ],
        'edit' => [
          'className' => 'Crud.Edit',//'Trois/Utils.Edit',
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

  public function index()
  {
    $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event)
    {
      $event->getSubject()->query
      ->matching('Sections', function ($q) {
        return $q->where(['Sections.id' => $this->request->getParam('section_id')]);
      });
    });

    return $this->Crud->execute();
  }

  public function view($id)
  {
    $this->Crud->on('beforeFind', function(\Cake\Event\Event $event) {
      $event->getSubject()->query
      ->matching('Sections', function ($q) {
        return $q->contain(['Articles' => ['Metas'], 'Modules'])->where(['Sections.id' => $this->request->getParam('section_id')]);
      });
    });
    return $this->Crud->execute();
  }

  public function add()
  {
    $this->Crud->on('beforeMarshal', function(\Cake\Event\Event $event)
    {
      $event->getSubject()->data['section'] = [['id' => $this->request->getParam('section_id')]];
    });

    return $this->Crud->execute();
  }
}
