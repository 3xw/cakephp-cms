<?php
/**
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $categories
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
          <?= __('Categories')?> <small><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></small>
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
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_template') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
              <tr>
                <td><?= $this->Number->format($category->id) ?></td>
                <td><?= (($category->parent_category)? ' - ' : '' ).h($category->name) ?></td>
                <td><?= h($category->slug) ?></td>
                <td><?= h($category->category_template) ?></td>
                <td><?= ($category->parent_category)? $category->parent_category->name : '' ?></td>
                <td data-title="actions" class="actions" class="text-right">
                  <div class="btn-group">
                    <?= $this->Html->link('<i class="material-icons">keyboard_arrow_up</i>', ['action' => 'moveUp', $category->id],['class' => 'btn btn-xs btn-simple btn-info btn-icon edit','escape' => false]) ?>
                    <?= $this->Html->link('<i class="material-icons">keyboard_arrow_down</i>', ['action' => 'moveDown', $category->id],['class' => 'btn btn-xs btn-simple btn-info btn-icon edit','escape' => false]) ?>
                    <?= $this->Html->link('<i class="material-icons">visibility</i>', ['action' => 'view', $category->id],['class' => 'btn btn-xs btn-simple btn-info btn-icon edit','escape' => false]) ?>
                    <?= $this->Html->link('<i class="material-icons">mode_edit</i>', ['action' => 'edit', $category->id], ['class' => 'btn btn-xs btn-simple btn-warning btn-icon edit','escape' => false]) ?>
                    <?= $this->Form->postLink('<i class="material-icons">delete</i>', ['action' => 'delete', $category->id], ['class' => 'btn btn-xs btn-simple btn-danger btn-icon remove','escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?',  $category->id)]) ?>
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
