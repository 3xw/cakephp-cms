<?php
return [
  'Trois/Cms' => [
    'Models' => [
      'Articles' =>[
        'behaviors' => [
          \Trois\Utils\ORM\Behavior\SluggableBehavior::class => ['field' => 'title','translate' => false],
          \Trois\ElasticSearch\ORM\Behavior\SyncWithESBehavior::class => [
            'index' => 'App\Model\Index\ItemsIndex',
            'primaryKey' => 'foreign_key', // string or callable
            'translate' => false, // property name if yes ex: locale
            'staticMatching' => [
              'model' => 'Articles'
            ], // or [keyN => valueN/callableN]
            'mapping' => [ // properties => 1. Array: entity field(s) || properties => 2. String: static value or callable
              'title' => new \Trois\ElasticSearch\ORM\CompletionConstructor(['title'],[
                'contexts' => [
                  'model' => 'Articles'
                ],
              ]),
              'content' => ['header','content']
            ],
            'deleteDocument' => true,
            'separator' => ' - ',
          ]
        ]
      ],
      'Categories' => [
        'behaviors' => [
          \Trois\Utils\ORM\Behavior\SluggableBehavior::class => ['field' => 'name','translate' => false],
          \Trois\ElasticSearch\ORM\Behavior\SyncWithESBehavior::class => [
            'index' => 'App\Model\Index\ItemsIndex',
            'primaryKey' => 'foreign_key', // string or callable
            'translate' => false, // property name if yes ex: locale
            'staticMatching' => [
              'model' => 'Categories'
            ], // or [keyN => valueN/callableN]
            'mapping' => [ // properties => 1. Array: entity field(s) || properties => 2. String: static value or callable
              'title' => new \Trois\ElasticSearch\ORM\CompletionConstructor(['name'],[
                'contexts' => [
                  'model' => 'Categories'
                ],
              ]),
              'content' => ['header','content']
            ],
            'deleteDocument' => true,
            'separator' => ' - ',
          ]
        ]
      ],
      'Pages' => [
        'behaviors' => [
          \Trois\Utils\ORM\Behavior\SluggableBehavior::class => ['field' => 'title','translate' => false],
          \Trois\ElasticSearch\ORM\Behavior\SyncWithESBehavior::class => [
            'index' => 'App\Model\Index\ItemsIndex',
            'primaryKey' => 'foreign_key', // string or callable
            'translate' => false, // property name if yes ex: locale
            'staticMatching' => [
              'model' => 'Pages'
            ], // or [keyN => valueN/callableN]
            'mapping' => [ // properties => 1. Array: entity field(s) || properties => 2. String: static value or callable
              'title' => new \Trois\ElasticSearch\ORM\CompletionConstructor(['name'],[
                'contexts' => [
                  'model' => 'Pages'
                ],
              ]),
              'content' => ['header','content']
            ],
            'deleteDocument' => true,
            'separator' => ' - ',
          ]
        ]
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
