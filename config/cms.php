<?php
return [
  'Trois/Cms' => [
    'Models' => [
      'Articles' =>[
        'behaviors' => false
      ],
      'Categories' => [
        'behaviors' => false
      ],
      'Pages' => [
        'behaviors' => false
      ],
    ],
    'Editables' => [
      'prefix' => 'cms',
      'suffixes' => ['input_text','textarea','tiptap', 'tinymce','attachment']
    ],
    'Tree' => [
      'pages' => [
        'default' => [
          'name' => 'Page défault',
          'template' => 'Trois/Cms.pages/default',
          'allowed' => ['sections.default']
        ]
      ],
      'sections' => [
        'default' => [
          'name' => 'Défault Section',
          'template' => 'Trois/Cms.sections/default',
          'allowed' => ['modules.default','articles.default','articles.test']
        ]
      ],
      'articles' => [
        'default' => [
          'name' => 'Défault Article',
          'template' => 'Trois/Cms.articles/default',
        ],
        'test' => [
          'name' => 'Artcile test',
          'template' => 'Trois/Cms.articles/test',
        ]
      ],
      'modules' => [
        'default' => [
          'name' => 'Défault module',
          'cell' => 'Trois/Cms.Default::display'
        ]
      ]
    ]
  ]
];
