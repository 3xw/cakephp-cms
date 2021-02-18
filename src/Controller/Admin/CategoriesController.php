<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Admin;

use Trois\Cms\Controller\AppController;

/**
* Categories Controller
*
*
* @method \App\Model\Entity\Category[] paginate($object = null, array $settings = [])
*/
class CategoriesController extends AppController
{
  public function initialize():void
  {
    parent::initialize();
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
    $query = $this->Categories->find('search', ['search' => $this->request->getQuery()])
    ->order(['Categories.lft' => 'ASC'])
    ->contain(['ParentCategories']);

    if (!empty($this->request->getQuery('q'))) {
      if (!$query->count()) {
        $this->Flash->error(__('No result.'));
      }else{
        $this->Flash->success($query->count()." ".__('result(s).'));
      }
      $this->set('q',$this->request->getQuery('q'));
    }
    $categories = $this->paginate($query);
    $this->set(compact('categories'));
  }

  public function moveUp($id = null)
  {
    $category = $this->Categories->get($id);
    $this->Categories->moveUp($category);

    return $this->redirect(['action' => 'index']);
  }

  public function moveDown($id = null)
  {
    $category = $this->Categories->get($id);
    $this->Categories->moveDown($category);

    return $this->redirect(['action' => 'index']);
  }

  /**
  * View method
  *
  * @param string|null $id Category id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $category = $this->Categories->get($id, [
      'contain' => []
    ]);

    $this->set('category', $category);
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add()
  {
    $category = $this->Categories->newEmptyEntity();
    if ($this->request->is('post')) {
      $category = $this->Categories->patchEntity($category, $this->request->getData());
      if ($this->Categories->save($category)) {
        $this->Flash->success(__('The category has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The category could not be saved. Please, try again.'));
    }

    $categories = $this->Categories->find('list', ['limit' => 200]);
    $this->set(compact('category', 'categories'));
  }

  /**
  * Edit method
  *
  * @param string|null $id Category id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $category = $this->Categories->get($id, [
      'contain' => ['Attachments']
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $category = $this->Categories->patchEntity($category, $this->request->getData());
      if ($this->Categories->save($category)) {
        $this->Flash->success(__('The category has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The category could not be saved. Please, try again.'));
    }
    $categories = $this->Categories->find('list', ['limit' => 200]);
    $this->set(compact('category', 'categories'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Category id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $category = $this->Categories->get($id);
    if ($this->Categories->delete($category)) {
      $this->Flash->success(__('The category has been deleted.'));
    } else {
      $this->Flash->error(__('The category could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
