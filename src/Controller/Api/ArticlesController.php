<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Api;

use Cake\Core\Configure;
use Trois\Cms\Controller\AppController;

/**
* Articles Controller
*
* @property \Trois\Cms\Model\Table\ArticlesTable $Articles
*
* @method \Trois\Cms\Model\Entity\Article[] paginate($object = null, array $settings = [])
*/
class ArticlesController extends AppController
{
  use \Crud\Controller\ControllerTrait;

  public function initialize():void
  {
    parent::initialize();
    $this->loadModel(Configure::read('Trois/Cms.Models.Articles'));
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

  public function index()
  {
    $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
      $event->getSubject()->query
      ->contain([
        'SectionItems'
      ]);
    });
    return $this->Crud->execute();
  }
}
