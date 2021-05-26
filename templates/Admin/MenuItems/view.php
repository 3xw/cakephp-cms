<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\MenuItem $menuItem
*/
?>
<nav class="navbar navbar-expand-lg">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">list</i> '.__('List'),['action'=>'index'], ['class' => '','escape'=>false]) ?>
      </li>
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">mode_edit</i> '.__('Edit'),['action'=>'edit', $menuItem->id], ['class' => '','escape'=>false]) ?>
      </li>
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">delete</i> '.__('Delete'),['action'=>'delete',$menuItem->id], ['class' => '','escape'=>false, 'confirm' => __('Are you sure you want to delete # {0}?', $menuItem->id)]) ?>
      </li>
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters g-0">
  <div class="col-8 mx-auto">
    <div class="card">
      <!-- pic -->
      <?php if ($menuItem->attachment): ?>
        <?php if ($menuItem->attachment->type == 'image'): ?>
          <?= $this->Attachment->image(['image' => $menuItem->attachment->path, 'profile' => $menuItem->attachment->profile, 'width' => '1200px',  'cropratio' => '16:8'], ['class' => 'card-img-top']) ?>
        <?php endif; ?>
      <?php endif; ?>
      <!-- CONTENT -->
      <div class="card-body">
        <h2><?= h($menuItem->id) ?></h2>
        <label><?= __('Label') ?></label>
        <?= h($menuItem->label) ?>
        <label><?= __('Model') ?></label>
        <?= h($menuItem->model) ?>
        <label><?= __('Foreign Key') ?></label>
        <?= h($menuItem->foreign_key) ?>
        <label><?= __('Url') ?></label>
        <?= h($menuItem->url) ?>
        <label><?= __('Target') ?></label>
        <?= h($menuItem->target) ?>
        <label><?= __('Parent Id') ?></label>
        <?= h($menuItem->parent_id) ?>
        <label><?= __('Menu Id') ?></label>
        <?= h($menuItem->menu_id) ?>
      </div>
    </div>
    <?php if (!empty($menuItem->child_menu_items)): ?>
      <div class="card  mt-4">
        <div class="card-header">
          <h4 class="card-title"><?= __('Related Menu Items')?></h4>
        </div>
        <div class="card-body">
          <figure class="figure figure--table">
            <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
              <thead>
                <tr>
                  <th scope="col"><?= __('Id') ?></th>
                  <th scope="col"><?= __('Active') ?></th>
                  <th scope="col"><?= __('Label') ?></th>
                  <th scope="col"><?= __('Model') ?></th>
                  <th scope="col"><?= __('Foreign Key') ?></th>
                  <th scope="col"><?= __('Url') ?></th>
                  <th scope="col"><?= __('Target') ?></th>
                  <th scope="col"><?= __('Parent Id') ?></th>
                  <th scope="col"><?= __('Left') ?></th>
                  <th scope="col"><?= __('Rght') ?></th>
                  <th scope="col"><?= __('Menu Id') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($menuItem->child_menu_items as $childMenuItems): ?>
                  <tr>
                    <td><?= h($childMenuItems->id) ?></td>
                    <td><?= h($childMenuItems->active) ?></td>
                    <td><?= h($childMenuItems->label) ?></td>
                    <td><?= h($childMenuItems->model) ?></td>
                    <td><?= h($childMenuItems->foreign_key) ?></td>
                    <td><?= h($childMenuItems->url) ?></td>
                    <td><?= h($childMenuItems->target) ?></td>
                    <td><?= h($childMenuItems->parent_id) ?></td>
                    <td><?= h($childMenuItems->left) ?></td>
                    <td><?= h($childMenuItems->rght) ?></td>
                    <td><?= h($childMenuItems->menu_id) ?></td>
                    <td data-title="actions" class="actions" class="text-right">
                      <div class="btn-group">
                        <?= $this->Html->link(__('View'), ['controller' => 'MenuItems', 'action' => 'view', $childMenuItems->id]) ?>
                      </td>
                    </div>
                  </tr >
                <?php endforeach; ?>
              </tbody>
            </table>
          </figure>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <div class="col-3 mx-auto">
    <div class="card">
      <div class="card-header">
        <h4><?= __('Informations')?></h4>
      </div>
      <!-- CONTENT -->
      <div class="card-body">
        <figure class="figure figure--table">
          <table class="table">
            <tbody>
              <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $menuItem->active ? __('Yes') : __('No'); ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Parent Menu Item') ?></th>
                <td><?= $menuItem->has('parent_menu_item') ? $this->Html->link($menuItem->parent_menu_item->id, ['controller' => 'MenuItems', 'action' => 'view', $menuItem->parent_menu_item->id]) : '' ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Menu') ?></th>
                <td><?= $menuItem->has('menu') ? $this->Html->link($menuItem->menu->name, ['controller' => 'Menus', 'action' => 'view', $menuItem->menu->id]) : '' ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($menuItem->id) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Left') ?></th>
                <td><?= $this->Number->format($menuItem->left) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Rght') ?></th>
                <td><?= $this->Number->format($menuItem->rght) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($menuItem->created) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($menuItem->modified) ?></td>
              </tr>
            </table>
          </figure>
        </div>
      </div>
    </div>
  </div>
  <div class="utils--spacer-default"></div>
