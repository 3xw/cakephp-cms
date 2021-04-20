<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Trois\Utils\Routing\Mapper;

// Api's Ressources
$resources = [
  'Pages' => [
    'Sections' => [
      'SectionItems'
    ]
  ],
  'Sections', 'Articles','SectionItems', 'Modules', 'Categories', 'Metas'
];

// Plugin routes
Router::plugin('Trois/Cms', ['path' => '/cms'], function (RouteBuilder $builder) use ($resources)
{
  // FRONT
  $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'view']);

  // Plugin's Api routes
  $builder->prefix('Api', function (RouteBuilder $builder) use ($resources)
  {
    Mapper::mapRessources($resources, $builder);
    $builder->setExtensions(['json']);
    $builder->fallbacks();
  });

  $builder->prefix('Admin', function (RouteBuilder $builder) use ($resources)
  {
    Mapper::mapRessources($resources, $builder);
    $builder->setExtensions(['json']);
    $builder->fallbacks();
  });

  $builder->setExtensions(['json']);
  $builder->fallbacks();
});
