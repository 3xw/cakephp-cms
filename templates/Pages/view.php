<?php
use Cake\Core\Configure;

$settings = Configure::read('Trois/Cms');
$content = $this->element($page->template, ['ref' => 'page-'.$page->id]);

if(true)
{
  echo $this->Html->tag(
    'cms-page',
    $this->Html->tag('template', $content, ['v-slot:content' => '']),
    [
      ':original-page' => json_encode($page),
      ':settings' => json_encode($settings)
    ]
  );
}
else echo $content;
?>
