<?php
$html = $this->Attachment->input(
  'Attachments',
  [
    'types' => ['application/zip', 'application/octet-stream', 'application/x-zip-compressed', 'multipart/x-zip','application/pdf'],
    'cols' => 'col-12',
    'restrictions' => [
      Trois\Attachment\View\Helper\AttachmentHelper::TAG_RESTRICTED,
      Trois\Attachment\View\Helper\AttachmentHelper::TYPES_RESTRICTED
    ],
    'attachments' => $entity->{$field}?? [],
  ],
  [':entity' => 'sp.entity']
);

$html = $this->Html->tag('template', $html, ['v-slot:default' => "sp"]);
echo $this->Html->tag('cms-editable-slot', $html, $attributes);
?>
