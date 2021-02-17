<?php
$html = $this->element('Trois/Tinymce.tinymce',[
  'attributes' => [
    ':entity' => 'sp.entity'
  ],
  'field' => $field,
  'value' => $entity->{$field},
  'init' => [
    'external_plugins' => [
      //'attachment' => $this->Url->build('/attachment/js/Plugins/tinymce/plugin.min.js', ['fullBase' => true]),
    ],
    'attachment_settings' => $this->Attachment->setup('body',[
      'types' => [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'image/jpeg',
        'image/png',
        'image/gif',
        'embed/youtube',
        'embed/vimeo'
      ],
      'atags' => [],
      'restrictions' => [
        Trois\Attachment\View\Helper\AttachmentHelper::TAG_OR_RESTRICTED,
        Trois\Attachment\View\Helper\AttachmentHelper::TYPES_RESTRICTED
      ],
    ])
  ]
]);
$html = $this->Html->tag('template', $html, ['v-slot:default' => "sp"]);
echo $this->Html->tag('cms-editable-slot', $html, $attributes);
?>
