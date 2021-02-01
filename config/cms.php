<?php

return [
  'Trois/Cms' => [
    'Pages' =>
    [
      'default' => [
        'template' => 'Trois/Cms.pages/default',
        'sections' => ['default']
      ]
    ],
    'Sections' =>
    [
      'default' => [
        'template' => 'Trois/Cms.sections/default',
        'modules' => ['default']
      ]
    ],
    'Modules' =>
    [
      'default' => [
        'cell' => 'Trois/Cms.Module::default'
      ]
    ]
  ]
];
