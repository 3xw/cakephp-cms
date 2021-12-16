<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Admin;

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Trois\Cms\Controller\AppController;

/**
 * MenuItems Controller
 *
 * @property \App\Model\Table\MenuItemsTable $MenuItems
 *
 * @method \App\Model\Entity\MenuItem[] paginate($object = null, array $settings = [])
 */
class MenuItemsController extends AppController
{
  public function initialize():void
  {
    parent::initialize();
    $this->loadModel(Configure::read('Trois/Cms.Models.MenuItems'));
    $this->loadComponent('Search.Search', [
      'actions' => ['index']
    ]);
  }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $query = $this->MenuItems->find('search', ['search' => $this->request->getQuery()])->contain(['ParentMenuItems', 'Menus']);
        if (!empty($this->request->getQuery('q'))) {
          if (!$query->count()) {
            $this->Flash->error(__('No result.'));
          }else{
            $this->Flash->success($query->count()." ".__('result(s).'));
          }
          $this->set('q',$this->request->getQuery('q'));
        }
        $menuItems = $this->paginate($query);
        $this->set(compact('menuItems'));
    }

    public function moveUp($id, $menu_id = null)
    {
      $menuItems = $this->MenuItems->get($id);
      $this->MenuItems->moveUp($menuItems);

      if($menu_id){
        return $this->redirect(['controller' => 'Menus', 'action' => 'view', $menu_id]);
      }else{
        return $this->redirect(['action' => 'index']);
      }
      Cache::delete('menus');

      return $this->redirect(['action' => 'index']);
    }

    public function moveDown($id, $menu_id = null)
    {
      $menuItems = $this->MenuItems->get($id);
      $this->MenuItems->moveDown($menuItems);

      if($menu_id){
        return $this->redirect(['controller' => 'Menus', 'action' => 'view', $menu_id]);
      }else{
        return $this->redirect(['action' => 'index']);
      }
      Cache::delete('menus');

      return $this->redirect(['action' => 'index']);
    }

    public function toggleActive($id, $menu_id = null)
    {
      $menuItems = $this->MenuItems->get($id);
      $menuItems->active = !$menuItems->active;

      if($this->MenuItems->save($menuItems)){
        Cache::delete('menus');
        if($menu_id){
          return $this->redirect(['controller' => 'Menus', 'action' => 'view', $menu_id]);
        }else{
          return $this->redirect(['action' => 'index']);
        }
      }
    }

    /**
     * View method 
     *
     * @param string|null $id Menu Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menuItem = $this->MenuItems->get($id, [
            'contain' => ['ParentMenuItems', 'Menus', 'ChildMenuItems']
        ]);

        $this->set('menuItem', $menuItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($menu_id = null)
    {
        $menuItem = $this->MenuItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $menuItem = $this->MenuItems->patchEntity($menuItem, $this->request->getData());
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success(__('The menu item has been saved.'));
                if($menu_id){
                  return $this->redirect(['controller' => 'Menus', 'action' => 'view', $menu_id]);
                }else{
                  return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
        }
        $parentMenuItems = $this->MenuItems->ParentMenuItems->find('treeList', [
          'keyPath' => 'id',
          'valuePath' => 'label',
          'spacer' => ' - '
        ])
        ->where(['ParentMenuItems.menu_id' => $menu_id]);
        $menus = $this->MenuItems->Menus->find('list', ['limit' => 200]);

        $this->loadModel('Pages');
        $pages = $this->MenuItems->Pages->find(($this->Pages->behaviors()->Tree)? 'treeList' : 'list', [
            'keyPath' => 'slug',
            'valuePath' => 'title',
            'keyField' => 'slug',
            'valueField' => 'title',
            'spacer' => ' - '
        ]);
        $this->set(compact('menuItem', 'parentMenuItems', 'menus', 'pages', 'menu_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $menu_id = null)
    {
        $menuItem = $this->MenuItems->get($id, [
            'contain' => ['ParentMenuItems', 'Pages', 'Menus']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menuItem = $this->MenuItems->patchEntity($menuItem, $this->request->getData());
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success(__('The menu item has been saved.'));

                if($menu_id){
                  return $this->redirect(['controller' => 'Menus', 'action' => 'view', $menu_id]);
                }else{
                  return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
        }
        $parentMenuItems = $this->MenuItems->ParentMenuItems->find('treeList', [
          'keyPath' => 'id',
          'valuePath' => 'label',
          'spacer' => ' - '
        ])
        ->where(['ParentMenuItems.menu_id' => $menu_id]);
        $menus = $this->MenuItems->Menus->find('list', ['limit' => 200]);
        $this->loadModel('Pages');
        $pages = $this->MenuItems->Pages->find(($this->Pages->behaviors()->Tree)? 'treeList' : 'list', [
            'keyPath' => 'slug',
            'valuePath' => 'title',
            'keyField' => 'slug',
            'valueField' => 'title',
            'spacer' => ' - '
        ]);
        $this->set(compact('menuItem', 'parentMenuItems', 'menus', 'pages', 'menu_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $menu_id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menuItem = $this->MenuItems->get($id);
        if ($this->MenuItems->delete($menuItem)) {
            $this->Flash->success(__('The menu item has been deleted.'));
        } else {
            $this->Flash->error(__('The menu item could not be deleted. Please, try again.'));
        }

        if($menu_id){
          return $this->redirect(['controller' => 'Menus', 'action' => 'view', $menu_id]);
        }else{
          return $this->redirect(['action' => 'index']);
        }
    }
}
