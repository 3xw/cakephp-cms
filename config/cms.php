<?php
return [
  'Trois/Cms' => [
    'Editables' => [
      'prefix' => 'cms',
      'suffixes' => ['string','text']
    ],
    'Tree' => [
      'pages' =>
      [
        'default' => [
          'template' => 'Trois/Cms.pages/default',
          'sections' => ['default']
        ]
      ],
      'sections' =>
      [
        'default' => [
          'template' => 'Trois/Cms.sections/default',
          'modules' => ['default'],
          'articles' => ['default']
        ]
      ],
      'articles' =>
      [
        'default' => [
          'template' => 'Trois/Cms.articles/default',
          'modules' => ['default']
        ]
      ],
      'modules' =>
      [
        'default' => [
          'cell' => 'Trois/Cms.Module::default'
        ]
      ]
    ]
  ]
];
