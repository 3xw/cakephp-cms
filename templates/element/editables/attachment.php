<?php
$html = $this->Attachment->input(
  'Attachments',
  [
    'attachments' => $entity->{$field}?? [],
  ],
  [':entity' => 'sp.entity']
);

$html = $this->Html->tag('template', $html, ['v-slot:default' => "sp"]);
echo $this->Html->tag('cms-editable-slot', $html, $attributes);
?>
