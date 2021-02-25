<?php
$html = $this->element('Trois/Tinymce.tinymce',[
  'attributes' => [
    ':entity' => 'sp.entity',
    ':set-filed' => 'sp.setFiled'
  ],
  'field' => $field,
  'value' => $entity->{$field},
  'init' => [
    'plugins' => [ 'attachment'],
    'attachment_settings' => $this->Attachment->setup($field,[
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
