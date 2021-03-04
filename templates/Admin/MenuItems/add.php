<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MenuItem $menuItem
 */
?>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters">
  <div class="col-11 mx-auto">
    <div class="card">
      <?= $this->Form->create($menuItem) ?>
      <?php $this->Form->setTemplates(['dateWidget' => "{{day}}{{month}}{{year}}{{hour}}{{minute}}"]);?>
      <div class="card-header">
        <h2><?= __('Add Menu Item') ?></h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-8">
            <?= $this->Form->control('label',['class'=>'form-control']);?>
            <?= $this->Form->control('page', ['empty' => ' ', 'type' => 'select', 'options' => $pages, 'class'=>'form-control menu-item__page-select' , 'data-model' => 'Pages']);?>
            <?= $this->Form->control('model',['type' => 'hidden', 'class'=>'form-control menu-item__model']);?>
            <? // $this->Form->control('foreign_key',['class'=>'menu-item__foreign_key']);?>
            <?= $this->Form->control('url',['class'=>'form-control menu-item__page-url']);?>
            <?= $this->Form->control('target',['type' => 'select', 'empty' => false, 'options' => ['_self' => 'Défaut', '_blank' => 'Nouvelle page'], 'class'=>'form-control']);?>
          </div>
          <div class="col-sm-4">
            <?= $this->Form->control('active', ['class'=>'form-control']);?>
            <?= $this->Form->control('class', ['type' => 'text', 'class'=>'form-control']);?>
            <?= $this->Form->control('parent_id', ['options' => $parentMenuItems, 'empty' => true, 'class'=>'form-control']);?>
            <?= $this->Form->control('menu_id', ['options' => $menus, 'value' => $menu_id, 'class'=>'form-control']);?>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="text-right">
          <div class="btn-group">
            <?= $this->Html->link(__('Cancel'), $referer, ['class' => 'btn btn-danger btn-fill']) ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-info btn-fill']) ?>
          </div>
        </div>
      </div>
      <?= $this->Form->end() ?>
  </div>
</div>
</div>
<div class="utils--spacer-default"></div>
