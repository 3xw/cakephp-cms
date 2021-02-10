<?php
return [
  'Trois/Cms' => [
    'Editables' => [
      'prefix' => 'cms',
      'suffixes' => ['input_text','textarea']
    ],
    'Tree' => [
      'pages' =>
      [
        [
          'name' => 'default',
          'template' => 'Trois/Cms.pages/default',
          'sections' => ['default']
        ]
      ],
      'sections' =>
      [
        [
          'name' => 'default',
          'template' => 'Trois/Cms.sections/default',
          'modules' => ['default'],
          'articles' => ['default','test']
        ]
      ],
      'articles' =>
      [
        [
          'name' => 'default',
          'template' => 'Trois/Cms.articles/default',
        ],
        [
          'name' => 'test',
          'template' => 'Trois/Cms.articles/test',
        ]
      ],
      'modules' =>
      [
        [
          'name' => 'default',
          'cell' => 'Trois/Cms.Module::default'
        ]
      ]
    ]
  ]
];
