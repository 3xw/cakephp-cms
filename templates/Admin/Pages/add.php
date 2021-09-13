<?php
use Cake\Core\Configure;
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
      <?= $this->Form->create($page) ?>
      <?php $this->Form->setTemplates(['dateWidget' => "{{day}}{{month}}{{year}}{{hour}}{{minute}}"]);?>
      <div class="card-header">
        <h2><?= __('Add Page') ?></h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-8">
            <?php
            if(Configure::read('Trois/Cms.Settings.translate'))
            {
              echo $this->element('locale',['fields' => [
                'title',
                'meta',
                'header' => [
                  'element' => 'Trois/Tinymce.tinymce',
                  'value' => '',
                  'init' => [
                    'attachment_settings' => []
                  ]
                ],
                'body' => [
                  'element' => 'Trois/Tinymce.tinymce',
                  'value' => '',
                  'init' => [
                    'attachment_settings' => []
                  ]
                ],
              ], 'labels' => ['Title','Meta', 'Header','Body']]);
            }
            else
            {
              echo $this->Form->control('title',['class'=>'form-control']);
              echo $this->Form->control('meta',['class'=>'form-control']);
              echo $this->element('Trois/Tinymce.tinymce',[
                'field' => 'header',
                'value' => '',
                'init' => [
                  'label' => __('Header')
                ]
              ]);
              echo $this->element('Trois/Tinymce.tinymce',[
                'field' => 'body',
                'value' => '',
                'init' => [
                  'label' => __('Body')
                ]
              ]);
            }
            ?>

            <?= $this->Form->control('template',['class'=>'form-control']);?>
            <?= $this->Attachment->input('Attachments',[
              'label' => __('Medias'),
              'attachments' => [],
            ]);?>
          </div>
          <div class="col-sm-4">
            <?= $this->Form->control('parent_id', ['options' => $parentPages, 'empty' => true, 'class'=>'form-control']);?>
            <?= $this->Form->control('private',['class'=>'form-control']);?>
            <?= $this->Form->control('published',['class'=>'form-control']);?>
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
