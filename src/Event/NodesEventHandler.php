<?php

namespace Croogo\Nodes\Event;

use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Croogo\Core\Croogo;
use Croogo\Comments\Model\Comment;
use Croogo\Core\Nav;

/**
 * Nodes Event Handler
 *
 * @category Event
 * @package  Croogo.Nodes.Event
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class NodesEventHandler implements EventListenerInterface
{

/**
 * implementedEvents
 */
    public function implementedEvents()
    {
        return [
            'Croogo.bootstrapComplete' => [
                'callable' => 'onBootstrapComplete',
            ],
            'Croogo.setupAdminData' => [
                'callable' => 'onSetupAdminData',
            ],
            'Controller.Links.setupLinkChooser' => [
                'callable' => 'onSetupLinkChooser',
            ],
            'Controller.Nodes.afterPublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterUnpublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterPromote' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterUnpromote' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterDelete' => [
                'callable' => 'onAfterBulkProcess',
            ],
        ];
    }

/**
 * Setup admin data
 */
    public function onSetupAdminData($event)
    {
        $View = $event->subject;

        $types = $View->viewVars['typesForAdminLayout'] ?: [];
        foreach ($types as $type) {
            if (!empty($type->plugin)) {
                continue;
            }
            Nav::add('sidebar', 'content.children.create.children.' . $type->alias, [
                'title' => $type->title,
                'url' => [
                    'plugin' => 'Croogo/Nodes',
                    'admin' => true,
                    'controller' => 'Nodes',
                    'action' => 'add',
                    $type->alias,
                ],
            ]);
        };
    }

/**
 * onBootstrapComplete
 */
    public function onBootstrapComplete($event)
    {
        if (Plugin::loaded('Comments')) {
                        Croogo::hookBehavior('Node', 'Comments.Commentable');
            Croogo::hookComponent('Nodes', 'Comments.Comments');
            Croogo::hookModelProperty('Comment', 'belongsTo', [
                'Node' => [
                    'className' => 'Nodes.Node',
                    'foreignKey' => 'foreign_key',
                    'counterCache' => true,
                    'counterScope' => [
                        'Comment.model' => 'Node',
                        'Comment.status' => Comment::STATUS_APPROVED,
                    ],
                ],
            ]);
        }
        if (Plugin::loaded('Croogo/Taxonomy')) {
            Croogo::hookBehavior('Croogo/Nodes.Nodes', 'Croogo/Taxonomy.Taxonomizable');
        }
        if (Plugin::loaded('Croogo/Meta')) {
            Croogo::hookBehavior('Croogo/Nodes.Nodes', 'Croogo/Meta.Meta');
        }
    }

/**
 * Setup Link chooser values
 *
 * @return void
 */
    public function onSetupLinkChooser($event)
    {
        $typesTable = TableRegistry::get('Croogo/Taxonomy.Types');
        $types = $typesTable->find('all', [
            'fields' => ['alias', 'title', 'description'],
        ]);
        $linkChoosers = [];
        foreach ($types as $type) {
            $linkChoosers[$type->title] = [
                'title' => $type->title,
                'description' => $type->description,
                'url' => [
                    'plugin' => 'Croogo/Nodes',
                    'controller' => 'Nodes',
                    'action' => 'index',
                    '?' => [
                        'type' => $type->alias,
                        'chooser' => 1,
                        'KeepThis' => true,
                        'TB_iframe' => true,
                        'height' => 400,
                        'width' => 600
                    ]
                ]
            ];
        }
        Croogo::mergeConfig('Croogo.linkChoosers', $linkChoosers);
    }

/**
 * Clear Nodes related cache after bulk operation
 *
 * @param CakeEvent $event
 * @return void
 */
    public function onAfterBulkProcess($event)
    {
        Cache::clearGroup('nodes', 'nodes');
        Cache::clearGroup('nodes', 'nodes_view');
        Cache::clearGroup('nodes', 'nodes_promoted');
        Cache::clearGroup('nodes', 'nodes_term');
        Cache::clearGroup('nodes', 'nodes_index');
    }
}
