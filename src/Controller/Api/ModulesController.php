<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Api;

use Cake\Core\Configure;
use Trois\Cms\Controller\AppController;

/**
* Modules Controller
*
* @property \Trois\Cms\Model\Table\ModulesTable $Modules
*
* @method \Trois\Cms\Model\Entity\Module[] paginate($object = null, array $settings = [])
*/
class ModulesController extends AppController
{
  use \Crud\Controller\ControllerTrait;

  public function fetchTable(?string $alias = null, array $options = []):\Cake\Orm\Table
  {
    return $this->loadModel(Configure::read('Trois/Cms.Models.Modules'));
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
}
