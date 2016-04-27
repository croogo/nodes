<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Croogo/Nodes', ['path' => '/'], function (RouteBuilder $routeBuilder) {
    $routeBuilder->prefix('admin', function (RouteBuilder $routeBuilder) {
        $routeBuilder->extensions(['json']);

        $routeBuilder->connect('/nodes/:action/*', ['controller' => 'Nodes']);
    });

    $routeBuilder->connect('/', ['controller' => 'Nodes', 'action' => 'promoted']);
    $routeBuilder->connect('/promoted/*', ['controller' => 'Nodes', 'action' => 'promoted']);
    $routeBuilder->connect('/search/*', ['controller' => 'Nodes', 'action' => 'search']);

    $routeBuilder->scope('/:type', function (RouteBuilder $routeBuilder) {
        $routeBuilder->routeClass('Croogo/Taxonomy.TypeRoute');
        $routeBuilder->connect('/', ['controller' => 'Nodes', 'action' => 'index']);
        $routeBuilder->connect('/archives/*', ['controller' => 'Nodes', 'action' => 'index']);
        $routeBuilder->connect('/:slug', ['controller' => 'Nodes', 'action' => 'view']);
        $routeBuilder->connect('/term/:slug/*', ['controller' => 'Nodes', 'action' => 'term']);
    });

    // Content types
    $routeBuilder->connect('/blog', ['controller' => 'Nodes', 'action' => 'index', 'type' => 'blog']);
    $routeBuilder->connect('/blog/archives/*', ['controller' => 'Nodes', 'action' => 'index', 'type' => 'blog']);
    $routeBuilder->connect('/blog/:slug', ['controller' => 'Nodes', 'action' => 'view', 'type' => 'blog']);
    $routeBuilder->connect('/blog/term/:slug/*', ['controller' => 'Nodes', 'action' => 'term', 'type' => 'blog']);

    $routeBuilder->connect('/node', ['controller' => 'Nodes', 'action' => 'index', 'type' => 'node']);
    $routeBuilder->connect('/node/archives/*', ['controller' => 'Nodes', 'action' => 'index', 'type' => 'node']);
    $routeBuilder->connect('/node/:slug', ['controller' => 'Nodes', 'action' => 'view', 'type' => 'node']);
    $routeBuilder->connect('/node/term/:slug/*', ['controller' => 'Nodes', 'action' => 'term', 'type' => 'node']);

    // Page
    $routeBuilder->connect('/about', ['controller' => 'Nodes', 'action' => 'view', 'type' => 'page', 'slug' => 'about']);
    $routeBuilder->connect('/page/:slug', ['controller' => 'Nodes', 'action' => 'view', 'type' => 'page']);
    $routeBuilder->connect('/page/term/:slug/*', ['controller' => 'Nodes', 'action' => 'term', 'type' => 'page']);

    // Node view
    $routeBuilder->connect('/nodes/view/:type/:slug', ['controller' => 'Nodes', 'action' => 'view']);
});
