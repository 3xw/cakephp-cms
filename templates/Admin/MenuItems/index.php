<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\MenuItem[]|\Cake\Collection\CollectionInterface $menuItems
*/
?>
<nav class="navbar navbar-expand-lg">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">add</i> '.__('Add'),['action'=>'add'], ['class' => '','escape'=>false]) ?>
      </li>
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters g-0">
  <div class="col-11 mx-auto ">
    <!-- LIST ELEMENT -->
    <div class="card">

      <div class="card-header">
        <h2 class="card-title">
          <?= __('Menu Items')?> <small><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></small>
        </h2>
        <?= $this->Form->create(null, ['novalidate', 'class'=>'', 'role'=>'search']) ?>
        <?= $this->Form->input('q', ['class'=>'form-control', 'placeholder'=>__('Search...'), 'label'=>false]) ?>
        <?= $this->Form->end() ?>
        <?php if (isset($q)): ?>
            Search value : <?= $this->Html->link($q.'<i class="material-icons">cancel</i>',['action'=>'index'], ['escape'=>false])?>
            <div class="utils--spacer-semi"></div>
        <?php endif; ?>
      </div>
      <!-- START CONTEMT -->
      <div class="card-body">
        <figure class="figure figure--table">
          <table id="datatables" class="table table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
            <thead class="thead-default">
              <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('label') ?></th>
                <th scope="col"><?= $this->Paginator->sort('model') ?></th>
                <th scope="col"><?= $this->Paginator->sort('foreign_key') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('target') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('left') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rght') ?></th>
                <th scope="col"><?= $this->Paginator->sort('menu_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($menuItems as $menuItem): ?>
              <tr>
                <td><?= $this->Number->format($menuItem->id) ?></td>
                <td><?= h($menuItem->created) ?></td>
                <td><?= h($menuItem->modified) ?></td>
                <td><?= ($menuItem->active) ? __('Yes') : __('No')?></td>
                <td><?= h($menuItem->label) ?></td>
                <td><?= h($menuItem->model) ?></td>
                <td><?= h($menuItem->foreign_key) ?></td>
                <td><?= h($menuItem->url) ?></td>
                <td><?= h($menuItem->target) ?></td>
                <td><?= $menuItem->has('parent_menu_item') ? $this->Html->link($menuItem->parent_menu_item->id, ['controller' => 'MenuItems', 'action' => 'view', $menuItem->parent_menu_item->id]) : '' ?></td>
                <td><?= $this->Number->format($menuItem->left) ?></td>
                <td><?= $this->Number->format($menuItem->rght) ?></td>
                <td><?= $menuItem->has('menu') ? $this->Html->link($menuItem->menu->name, ['controller' => 'Menus', 'action' => 'view', $menuItem->menu->id]) : '' ?></td>
                <td data-title="actions" class="actions" class="text-right">
                  <div class="btn-group">
                    <?= $this->Html->link('<i class="material-icons">visibility</i>', ['action' => 'view', $menuItem->id],['class' => 'btn btn-xs btn-simple btn-info btn-icon edit','escape' => false]) ?>
                    <?= $this->Html->link('<i class="material-icons">mode_edit</i>', ['action' => 'edit', $menuItem->id], ['class' => 'btn btn-xs btn-simple btn-warning btn-icon edit','escape' => false]) ?>
                    <?= $this->Form->postLink('<i class="material-icons">delete</i>', ['action' => 'delete', $menuItem->id], ['class' => 'btn btn-xs btn-simple btn-danger btn-icon remove','escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?',  $menuItem->id)]) ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </figure>
      </div>
      <!-- END CONTEMT -->
      <!-- START FOOTER -->
      <div class="card-footer">
        <div class="row no-gutters g-0">
          <div class="col-6">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
          </div>
          <div class="col-6">
          <nav aria-label="pagination">
            <ul class="pagination justify-content-end">
              <?= $this->Paginator->first('<< ' . __('first'),['class'=>'btn '])?>
              <?= $this->Paginator->prev('< ' . __('previous')) ?>
              <?= $this->Paginator->numbers() ?>
              <?= $this->Paginator->next(__('next') . ' >') ?>
              <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- END FOOTER -->
  </div><!-- end content-->
</div><!-- end card-->
</div><!-- end col-xs-12-->
