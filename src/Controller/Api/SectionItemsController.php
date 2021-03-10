<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Api;

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

  public function initialize():void
  {
    parent::initialize();
    $this->loadModel(Configure::read('Trois/Cms.Models.SectionItems'));
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
}
