<?php

use Cake\Routing\RouteBuilder;
use Croogo\Core\Router;

Router::plugin('Croogo/Nodes', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->setExtensions(['json']);

        $route->scope('/nodes', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });

    $route->setExtensions(['rss']);

    Router::build($route, '/', ['controller' => 'Nodes', 'action' => 'promoted']);
    Router::build($route, '/promoted/*', ['controller' => 'Nodes', 'action' => 'promoted']);
    Router::build($route, '/search', ['controller' => 'Nodes', 'action' => 'search']);

    // Content types
    Router::routableContentTypes($route);
    Router::build($route, '/:action/*', ['controller' => 'Nodes']);
});

Router::plugin('Croogo/Nodes', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('api', function (RouteBuilder $route) {
        $route->prefix('v10', ['path' => '/v1.0'], function (RouteBuilder $route) {
            $route->setExtensions(['json']);

            $route->resources('Nodes', [
                'map' => [
                    'lookup' => [
                        'action' => 'lookup',
                        'method' => 'GET',
                    ],
                ],
            ]);
        });
    });
});
