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
  <div class="navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">list</i> '.__('List'),['action'=>'index'], ['class' => '','escape'=>false]) ?>
      </li>
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters">
  <div class="col-11 mx-auto">
    <div class="card">
      <?= $this->Form->create($menuItem) ?>
      <?php $this->Form->setTemplates(['dateWidget' => "{{day}}{{month}}{{year}}{{hour}}{{minute}}"]);?>
      <div class="card-header">
        <h2><?= __('Edit Menu Item') ?></h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-8">
            <?= $this->Form->control('label',['class'=>'form-control']);?>
            <?= $this->Form->control('model',['class'=>'form-control']);?>
            <?= $this->Form->control('foreign_key',['class'=>'form-control']);?>
            <?= $this->Form->control('url',['class'=>'form-control']);?>
            <?= $this->Form->control('target',['class'=>'form-control']);?>
          </div>
          <div class="col-sm-4">
            <?= $this->Form->control('active', ['class'=>'form-control']);?>
            <?= $this->Form->control('parent_id', ['options' => $parentMenuItems, 'empty' => true, 'class'=>'form-control']);?>
            <?= $this->Form->control('left', ['class'=>'form-control']);?>
            <?= $this->Form->control('rght', ['class'=>'form-control']);?>
            <?= $this->Form->control('menu_id', ['options' => $menus, 'class'=>'form-control']);?>
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
