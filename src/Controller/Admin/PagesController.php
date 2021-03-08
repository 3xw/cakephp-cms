<?php
declare(strict_types=1);

namespace Trois\Cms\Controller\Admin;

use Trois\Cms\Controller\AppController;

/**
* Pages Controller
*
* @property \App\Model\Table\PagesTable $Pages
*
* @method \App\Model\Entity\Page[] paginate($object = null, array $settings = [])
*/
class PagesController extends AppController
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
    $pages = $this->Pages->find('treeList', ['spacer' => ' - '])->toArray();

    $this->set(compact('pages'));
  }

  public function moveUp($id = null)
  {
    $page = $this->Pages->get($id);
    $this->Pages->moveUp($page);

    return $this->redirect(['action' => 'index']);
  }

  public function moveDown($id = null)
  {
    $page = $this->Pages->get($id);
    $this->Pages->moveDown($page);

    return $this->redirect(['action' => 'index']);
  }


  /**
  * View method
  *
  * @param string|null $id Page id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $page = $this->Pages->get($id, [
      'contain' => ['ParentPages', 'Attachments', 'ChildPages', 'Sections']
    ]);

    $this->set('page', $page);
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add()
  {
    $page = $this->Pages->newEmptyEntity();
    if ($this->request->is('post')) {
      $page = $this->Pages->patchEntity($page, $this->request->getData());
      if ($this->Pages->save($page)) {
        $this->Flash->success(__('The page has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      debug($page->getErrors());
      $this->Flash->error(__('The page could not be saved. Please, try again.'));
    }
    $parentPages = $this->Pages->ParentPages->find('treeList', [
      'keyPath' => 'id',
      'valuePath' => 'title',
      'spacer' => ' - '
    ]);
    $attachments = $this->Pages->Attachments->find('list');
    $this->set(compact('page', 'parentPages', 'attachments'));
  }

  /**
  * Edit method
  *
  * @param string|null $id Page id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $page = $this->Pages->get($id, [
      'contain' => ['Attachments']
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $page = $this->Pages->patchEntity($page, $this->request->getData());
      if ($this->Pages->save($page)) {
        $this->Flash->success(__('The page has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The page could not be saved. Please, try again.'));
    }
    $parentPages = $this->Pages->ParentPages->find('treeList', [
      'keyPath' => 'id',
      'valuePath' => 'title',
      'spacer' => ' - '
    ]);
    $attachments = $this->Pages->Attachments->find('list');
    $this->set(compact('page', 'parentPages', 'attachments'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Page id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $page = $this->Pages->get($id);
    if ($this->Pages->delete($page)) {
      $this->Flash->success(__('The page has been deleted.'));
    } else {
      $this->Flash->error(__('The page could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
