<?php
/**
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface $article
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
        <?= $this->Html->link('<i class="material-icons">mode_edit</i> '.__('Edit'),['action'=>'edit', $article->id], ['class' => '','escape'=>false]) ?>
      </li>
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">delete</i> '.__('Delete'),['action'=>'delete',$article->id], ['class' => '','escape'=>false, 'confirm' => __('Are you sure you want to delete # {0}?', $article->id)]) ?>
      </li>
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters">
  <div class="col-8 mx-auto">
    <div class="card">
      <!-- pic -->
      <?php if ($article->attachment): ?>
        <?php if ($article->attachment->type == 'image'): ?>
          <?= $this->Attachment->image(['image' => $article->attachment->path, 'profile' => $article->attachment->profile, 'width' => '1200px',  'cropratio' => '16:8'], ['class' => 'card-img-top']) ?>
        <?php endif; ?>
      <?php endif; ?>
      <!-- CONTENT -->
      <div class="card-body">
        <h2><?= h($article->title) ?></h2>
        <label><?= __('Header') ?></label>
        <?= $article->header; ?>
        <label><?= __('Body') ?></label>
        <?= $article->body; ?>
        <label><?= __('Status') ?></label>
        <?= h($article->status) ?>
        <label><?= __('Slug') ?></label>
        <?= h($article->slug) ?>
        <label><?= __('Meta') ?></label>
        <?= h($article->meta) ?>
        <label><?= __('User Id') ?></label>
        <?= h($article->user_id) ?>
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
                <td><?= $this->Number->format($article->id) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($article->created) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($article->modified) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Publish Date') ?></th>
                <td><?= h($article->publish_date) ?></td>
              </tr>
            </table>
          </figure>
        </div>
      </div>
    </div>
  </div>
  <div class="utils--spacer-default"></div>
