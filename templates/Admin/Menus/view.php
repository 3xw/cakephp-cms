<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Menu $menu
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
        <?= $this->Html->link('<i class="material-icons">mode_edit</i> '.__('Edit'),['action'=>'edit', $menu->id], ['class' => '','escape'=>false]) ?>
      </li>
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">delete</i> '.__('Delete'),['action'=>'delete',$menu->id], ['class' => '','escape'=>false, 'confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]) ?>
      </li>
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters g-0">
  <div class="col-11 mx-auto">
    <div class="card">
      <!-- pic -->
      <?php if ($menu->attachment): ?>
        <?php if ($menu->attachment->type == 'image'): ?>
          <?= $this->Attachment->image(['image' => $menu->attachment->path, 'profile' => $menu->attachment->profile, 'width' => '1200px',  'cropratio' => '16:8'], ['class' => 'card-img-top']) ?>
        <?php endif; ?>
      <?php endif; ?>
      <!-- CONTENT -->
      <div class="card-body">
        <h2><?= h($menu->name) ?></h2>
      </div>
    </div>
      <div class="card  mt-4">
        <div class="card-header d-flex justify-content-between">
          <h4 class="card-title"><?= __('Related Menu Items')?></h4>
          <?= $this->Html->link('<i class="material-icons">add</i> '.__('add'),['controller' => 'MenuItems', 'action'=>'add', $menu->id], ['class' => '','escape'=>false]) ?>

        </div>
        <div class="card-body">
          <?php if (!empty($menu->menu_items)): ?>
            <figure class="figure figure--table">
              <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                <thead>
                  <tr>
                    <!--<th scope="col"><?= __('Id') ?></th>-->
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Label') ?></th>
                    <th scope="col"><?= __('Url') ?></th>
                    <th scope="col"><?= __('Target') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($menu->menu_items as $key => $menuItems): ?>
                    <tr>
                      <!--<td><?= h($menuItems->id) ?></td>-->
                      <td><?= $this->Html->link(($menuItems->active)? '<i class="material-icons">done</i>' : '<i class="material-icons">clear</i>', ['controller' => 'MenuItems', 'action' => 'toggleActive',  $menuItems->id, $menu->id], ['escape' => false])  ?></td>
                      <td><?= !$menuItems->has('parent_menu_item')? '<strong>' : '' ?> <?= $treeList[$menuItems->id] ?><?= !$menuItems->has('parent_menu_item')? '</strong>' : '' ?></td>
                      <td title="<?= $menuItems->url ?>"><?= $this->Text->truncate($menuItems->url, 50) ?></td>
                      <td><?= h($menuItems->target) ?></td>
                      <td data-title="actions" class="actions" class="text-right">
                        <div class="btn-group">
                          <?= $this->Html->link('<i class="material-icons">keyboard_arrow_up</i>', ['controller' => 'MenuItems', 'action' => 'moveUp', $menuItems->id, $menu->id],['class' => 'btn btn-xs btn-simple btn-info btn-icon edit','escape' => false]) ?>
                          <?= $this->Html->link('<i class="material-icons">keyboard_arrow_down</i>', ['controller' => 'MenuItems','action' => 'moveDown', $menuItems->id, $menu->id],['class' => 'btn btn-xs btn-simple btn-info btn-icon edit','escape' => false]) ?>
                          <?= $this->Html->link('<i class="material-icons">mode_edit</i>', ['controller' => 'MenuItems', 'action' => 'edit', $menuItems->id, $menu->id], ['class' => 'btn btn-xs btn-simple btn-warning btn-icon edit','escape' => false]) ?>
                          <?= $this->Form->postLink('<i class="material-icons">delete</i>', ['controller' => 'MenuItems', 'action' => 'delete', $menuItems->id, $menu->id], ['class' => 'btn btn-xs btn-simple btn-danger btn-icon remove','escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?',  $menuItems->id)]) ?>
                        </td>
                      </div>
                    </tr >
                  <?php endforeach; ?>
                </tbody>
              </table>
            </figure>
          <?php endif; ?>
        </div>
      </div>
  </div>
  <div class="col-11 mx-auto">
    <div class="utils__spacer--semi"></div>
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
                <td><?= $menu->active ? __('Yes') : __('No'); ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($menu->id) ?></td>
              </tr>
            </table>
          </figure>
        </div>
      </div>
    </div>
  </div>
  <div class="utils--spacer-default"></div>
