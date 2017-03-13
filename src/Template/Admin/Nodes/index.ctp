<?php

use Cake\Utility\Hash;
use Croogo\Core\Status;

$this->extend('Croogo/Core./Common/admin_index');

$this->Croogo->adminScript('Croogo/Nodes.admin');

$this->Breadcrumbs
    ->add(__d('croogo', 'Content'));

$this->append('actions');
echo $this->Croogo->adminAction(__d('croogo', 'Create content'), ['action' => 'create'], ['button' => 'success']);
$this->end();

$this->append('search', $this->element('admin/nodes_search'));

$this->append('form-start', $this->Form->create(null, [
    'url' => ['action' => 'process'],
    'align' => 'inline',
]));

$this->start('table-heading');
echo $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'NodesCheckAll']),
    $this->Paginator->sort('title', __d('croogo', 'Title')),
    $this->Paginator->sort('type', __d('croogo', 'Type')),
    $this->Paginator->sort('user_id', __d('croogo', 'User')),
    $this->Paginator->sort('status', __d('croogo', 'Status')),
    '',
]);
$this->end();

$this->append('table-body');
?>
    <?php foreach ($nodes as $node): ?>
        <tr>
            <td><?php echo $this->Form->checkbox('Nodes.' . $node->id . '.id',
                    ['class' => 'row-select', 'id' => 'Nodes' . $node->id . 'Id']); ?></td>
            <td>
                <span>
                <?php
                echo $this->Html->link($node->title,
                    Hash::merge($node->url->getArrayCopy(), [
                        'prefix' => false,
                    ]),
                    ['target' => '_blank']
                );
                ?>
                </span>

                <?php if ($node->promote == 1): ?>
                    <span class="label label-info"><?php echo __d('croogo', 'promoted'); ?></span>
                <?php endif ?>

                <?php if ($node->status == Status::PREVIEW): ?>
                    <span class="label label-warning"><?php echo __d('croogo', 'preview'); ?></span>
                <?php endif ?>
            </td>
            <td>
                <?php
                echo $this->Html->link($node->type, [
                    'action' => 'index',
                    '?' => [
                        'type' => $node->type,
                    ],
                ]);
                ?>
            </td>
            <td>
                <?php echo $node->user->username; ?>
            </td>
            <td>
                <?php
                echo $this->element('Croogo/Core.admin/toggle', [
                    'id' => $node->id,
                    'status' => (int)$node->status,
                ]);
                ?>
            </td>
            <td>
                <div class="item-actions">
                    <?php
                    echo $this->Croogo->adminRowActions($node->id);
                    echo ' ' . $this->Croogo->adminRowAction('', ['action' => 'edit', $node->id], [
                            'icon' => $this->Theme->getIcon('update'),
                            'tooltip' => __d('croogo', 'Edit this item'),
                        ]);
                    echo ' ' . $this->Croogo->adminRowAction('', '#Nodes' . $node->id . 'Id', [
                            'icon' => $this->Theme->getIcon('copy'),
                            'tooltip' => __d('croogo', 'Create a copy'),
                            'rowAction' => 'copy',
                        ]);
                    echo ' ' . $this->Croogo->adminRowAction('', '#Nodes' . $node->id . 'Id', [
                            'icon' => $this->Theme->getIcon('delete'),
                            'class' => 'delete',
                            'tooltip' => __d('croogo', 'Remove this item'),
                            'rowAction' => 'delete',
                        ], __d('croogo', 'Are you sure?'));
                    ?>
                </div>
            </td>
        </tr>
    <?php endforeach ?>
<?php
$this->end();

$this->start('bulk-action');
echo $this->Form->input('Nodes.action', [
    'label' => __d('croogo', 'Bulk actions'),
    'class' => 'c-select',
    'options' => [
        'publish' => __d('croogo', 'Publish'),
        'unpublish' => __d('croogo', 'Unpublish'),
        'promote' => __d('croogo', 'Promote'),
        'unpromote' => __d('croogo', 'Unpromote'),
        'delete' => __d('croogo', 'Delete'),
        [
            'value' => 'copy',
            'text' => __d('croogo', 'Copy'),
            'hidden' => true,
        ],
    ],
    'empty' => 'Bulk actions',
]);

$jsVarName = uniqid('confirmMessage_');
echo $this->Form->button(__d('croogo', 'Apply'), [
    'type' => 'button',
    'class' => 'bulk-process btn-outline-primary',
    'data-relatedElement' => '#nodes-action',
    'data-confirmMessage' => $jsVarName,
    'escape' => true,
]);

$this->Js->set($jsVarName, __d('croogo', '%s selected items?'));
$this->Js->buffer("$('.bulk-process').on('click', Nodes.confirmProcess);");

$this->end();

$this->append('form-end', $this->Form->end());
