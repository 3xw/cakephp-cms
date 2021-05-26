<?php
/**
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface $page
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
        <?= $this->Html->link('<i class="material-icons">mode_edit</i> '.__('Edit'),['action'=>'edit', $page->id], ['class' => '','escape'=>false]) ?>
      </li>
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">delete</i> '.__('Delete'),['action'=>'delete',$page->id], ['class' => '','escape'=>false, 'confirm' => __('Are you sure you want to delete # {0}?', $page->id)]) ?>
      </li>
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters g-0">
  <div class="col-8 mx-auto">
    <div class="card">
      <!-- pic -->
      <?php if ($page->attachment): ?>
        <?php if ($page->attachment->type == 'image'): ?>
          <?= $this->Attachment->image(['image' => $page->attachment->path, 'profile' => $page->attachment->profile, 'width' => '1200px',  'cropratio' => '16:8'], ['class' => 'card-img-top']) ?>
        <?php endif; ?>
      <?php endif; ?>
      <!-- CONTENT -->
      <div class="card-body">
        <h2><?= h($page->title) ?></h2>
        <label><?= __('Header') ?></label>
        <?= $page->header; ?>
        <label><?= __('Body') ?></label>
        <?= $page->body; ?>
        <label><?= __('Parent Id') ?></label>
        <?= h($page->parent_id) ?>
        <label><?= __('Slug') ?></label>
        <?= h($page->slug) ?>
        <label><?= __('Meta') ?></label>
        <?= h($page->meta) ?>
        <label><?= __('Template') ?></label>
        <?= h($page->template) ?>
      </div>
    </div>
    <?php if (!empty($page->attachments)): ?>
      <div class="card  mt-4">
        <div class="card-header">
          <h4 class="card-title"><?= __('Related Attachments')?></h4>
        </div>
        <div class="card-body">
          <figure class="figure figure--table">
            <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
              <thead>
                <tr>
                  <th scope="col"><?= __('Id') ?></th>
                  <th scope="col"><?= __('Profile') ?></th>
                  <th scope="col"><?= __('Type') ?></th>
                  <th scope="col"><?= __('Subtype') ?></th>
                  <th scope="col"><?= __('Name') ?></th>
                  <th scope="col"><?= __('Size') ?></th>
                  <th scope="col"><?= __('Md5') ?></th>
                  <th scope="col"><?= __('Path') ?></th>
                  <th scope="col"><?= __('Embed') ?></th>
                  <th scope="col"><?= __('Title') ?></th>
                  <th scope="col"><?= __('Date') ?></th>
                  <th scope="col"><?= __('Description') ?></th>
                  <th scope="col"><?= __('Author') ?></th>
                  <th scope="col"><?= __('Copyright') ?></th>
                  <th scope="col"><?= __('Width') ?></th>
                  <th scope="col"><?= __('Height') ?></th>
                  <th scope="col"><?= __('Duration') ?></th>
                  <th scope="col"><?= __('Meta') ?></th>
                  <th scope="col"><?= __('User Id') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($page->attachments as $attachments): ?>
                  <tr>
                    <td><?= h($attachments->id) ?></td>
                    <td><?= h($attachments->profile) ?></td>
                    <td><?= h($attachments->type) ?></td>
                    <td><?= h($attachments->subtype) ?></td>
                    <td><?= h($attachments->name) ?></td>
                    <td><?= h($attachments->size) ?></td>
                    <td><?= h($attachments->md5) ?></td>
                    <td><?= h($attachments->path) ?></td>
                    <td><?= h($attachments->embed) ?></td>
                    <td><?= h($attachments->title) ?></td>
                    <td><?= h($attachments->date) ?></td>
                    <td><?= h($attachments->description) ?></td>
                    <td><?= h($attachments->author) ?></td>
                    <td><?= h($attachments->copyright) ?></td>
                    <td><?= h($attachments->width) ?></td>
                    <td><?= h($attachments->height) ?></td>
                    <td><?= h($attachments->duration) ?></td>
                    <td><?= h($attachments->meta) ?></td>
                    <td><?= h($attachments->user_id) ?></td>
                    <td data-title="actions" class="actions" class="text-right">
                      <div class="btn-group">
                        <?= $this->Html->link(__('View'), ['controller' => 'Attachments', 'action' => 'view', $attachments->id]) ?>
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
    <?php if (!empty($page->child_pages)): ?>
      <div class="card  mt-4">
        <div class="card-header">
          <h4 class="card-title"><?= __('Related Pages')?></h4>
        </div>
        <div class="card-body">
          <figure class="figure figure--table">
            <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
              <thead>
                <tr>
                  <th scope="col"><?= __('Id') ?></th>
                  <th scope="col"><?= __('Parent Id') ?></th>
                  <th scope="col"><?= __('Lft') ?></th>
                  <th scope="col"><?= __('Rght') ?></th>
                  <th scope="col"><?= __('Title') ?></th>
                  <th scope="col"><?= __('Slug') ?></th>
                  <th scope="col"><?= __('Meta') ?></th>
                  <th scope="col"><?= __('Template') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($page->child_pages as $childPages): ?>
                  <tr>
                    <td><?= h($childPages->id) ?></td>
                    <td><?= h($childPages->parent_id) ?></td>
                    <td><?= h($childPages->lft) ?></td>
                    <td><?= h($childPages->rght) ?></td>
                    <td><?= h($childPages->title) ?></td>
                    <td><?= h($childPages->slug) ?></td>
                    <td><?= h($childPages->meta) ?></td>
                    <td><?= h($childPages->template) ?></td>
                    <td data-title="actions" class="actions" class="text-right">
                      <div class="btn-group">
                        <?= $this->Html->link(__('View'), ['controller' => 'Pages', 'action' => 'view', $childPages->id]) ?>
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
    <?php if (!empty($page->sections)): ?>
      <div class="card  mt-4">
        <div class="card-header">
          <h4 class="card-title"><?= __('Related Sections')?></h4>
        </div>
        <div class="card-body">
          <figure class="figure figure--table">
            <table id="datatables" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
              <thead>
                <tr>
                  <th scope="col"><?= __('Id') ?></th>
                  <th scope="col"><?= __('Page Id') ?></th>
                  <th scope="col"><?= __('Template') ?></th>
                  <th scope="col"><?= __('Order') ?></th>
                  <th class="actions"><?= __('Actions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($page->sections as $sections): ?>
                  <tr>
                    <td><?= h($sections->id) ?></td>
                    <td><?= h($sections->page_id) ?></td>
                    <td><?= h($sections->template) ?></td>
                    <td><?= h($sections->order) ?></td>
                    <td data-title="actions" class="actions" class="text-right">
                      <div class="btn-group">
                        <?= $this->Html->link(__('View'), ['controller' => 'Sections', 'action' => 'view', $sections->id]) ?>
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
                <th scope="row"><?= __('Parent Page') ?></th>
                <td><?= $page->has('parent_page') ? $this->Html->link($page->parent_page->title, ['controller' => 'Pages', 'action' => 'view', $page->parent_page->id]) : '' ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($page->id) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Lft') ?></th>
                <td><?= $this->Number->format($page->lft) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Rght') ?></th>
                <td><?= $this->Number->format($page->rght) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($page->created) ?></td>
              </tr>
              <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($page->modified) ?></td>
              </tr>
            </table>
          </figure>
        </div>
      </div>
    </div>
  </div>
  <div class="utils--spacer-default"></div>
