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
  <div class="navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">list</i> '.__('List'),['action'=>'index'], ['class' => '','escape'=>false]) ?>
      </li>
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters g-0">
  <div class="col-11 mx-auto">
    <div class="card">
      <?= $this->Form->create($article) ?>
      <?php $this->Form->setTemplates(['dateWidget' => "{{day}}{{month}}{{year}}{{hour}}{{minute}}"]);?>
      <div class="card-header">
        <h2><?= __('Add Article') ?></h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-8">
            <?= $this->Form->control('title',['class'=>'form-control']);?>
            <?= $this->Form->control('meta',['class'=>'form-control']);?>

            <?= $this->element('Trois/Tinymce.tinymce',[
              'field' => 'header',
              'value' => '',
              'init' => [
                'label' => __('Header')
              ]
            ]) ?>
            <?= $this->element('Trois/Tinymce.tinymce',[
              'field' => 'body',
              'value' => '',
              'init' => [
                'label' => __('Body')
              ]
            ]) ?>
          </div>
          <div class="col-sm-4">
            <?= $this->Form->control('status', ['options' => ['draft' => __('Draft'), 'published' => __('Published')], 'class'=>'form-control']);?>
            <?= $this->Form->control('publish_date', ['class'=>'form-control']);?>
            <?= $this->Form->control('categories._ids', ['options' => $categories, 'class'=>'form-control']);?>

            <?= $this->Attachment->input('Attachments',
            [
              'profile' => 'default',
              'types' => ['image/png', 'image/jpg', 'image/gif'],
              'cols' => 'col-sm-6',
              'restrictions' => [
                Trois\Attachment\View\Helper\AttachmentHelper::TAG_OR_RESTRICTED,
                Trois\Attachment\View\Helper\AttachmentHelper::TYPES_RESTRICTED
              ],
              'attachments' => [],
            ]);
            ?>
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
