<?php
/**
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface $category
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
        <?= $this->Html->link('<i class="material-icons">mode_edit</i> '.__('Edit'),['action'=>'edit', $category->id], ['class' => '','escape'=>false]) ?>
      </li>
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">delete</i> '.__('Delete'),['action'=>'delete',$category->id], ['class' => '','escape'=>false, 'confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
      </li>
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters">
  <div class="col-8 mx-auto">
    <div class="card">
      <!-- pic -->
      <?php if ($category->attachment): ?>
        <?php if ($category->attachment->type == 'image'): ?>
          <?= $this->Attachment->image(['image' => $category->attachment->path, 'profile' => $category->attachment->profile, 'width' => '1200px',  'cropratio' => '16:8'], ['class' => 'card-img-top']) ?>
        <?php endif; ?>
      <?php endif; ?>
      <!-- CONTENT -->
      <div class="card-body">
        <h2><?= h($category->name) ?></h2>
        <label><?= __('Meta') ?></label>
        <?= $category->meta; ?>
        <label><?= __('Header') ?></label>
        <?= $category->header; ?>
        <label><?= __('Body') ?></label>
        <?= $category->body; ?>
        <label><?= __('Slug') ?></label>
        <?= h($category->slug) ?>
        <label><?= __('Category Template') ?></label>
        <?= h($category->category_template) ?>
      </div>
    </div>
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
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($category->id) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Parent Id') ?></th>
                <td><?= $this->Number->format($category->parent_id) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Lft') ?></th>
                <td><?= $this->Number->format($category->lft) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Rght') ?></th>
                <td><?= $this->Number->format($category->rght) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($category->created) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($category->modified) ?></td>
              </tr>
            </table>
          </figure>
        </div>
      </div>
    </div>
  </div>
  <div class="utils--spacer-default"></div>
