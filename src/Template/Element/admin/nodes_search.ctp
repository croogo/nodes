<?php
$url = isset($url) ? $url : ['action' => 'index'];
?>
<?php
echo $this->Form->create(false, [
    'align' => 'inline',
    'url' => $url,
]);

$this->Form->templates([
    'label' => false,
    'submitContainer' => '{{content}}',
]);

echo $this->Form->input('filter', [
    'title' => __d('croogo', 'Search'),
    'placeholder' => __d('croogo', 'Search...'),
    'tooltip' => false,
]);

if (!isset($this->request->query['chooser'])):

    echo $this->Form->input('type', [
        'options' => $nodeTypes,
        'empty' => __d('croogo', 'Type'),
        'class' => 'c-select',
    ]);

    echo $this->Form->input('status', [
        'options' => [
            '1' => __d('croogo', 'Published'),
            '0' => __d('croogo', 'Unpublished'),
        ],
        'empty' => __d('croogo', 'Status'),
        'class' => 'c-select',
    ]);

    echo $this->Form->input('promote', [
        'options' => [
            '1' => __d('croogo', 'Yes'),
            '0' => __d('croogo', 'No'),
        ],
        'empty' => __d('croogo', 'Promoted'),
        'class' => 'c-select',
    ]);

endif;

echo $this->Form->submit(__d('croogo', 'Filter'), [
    'class' => 'btn-success-outline',
]);
echo $this->Form->end();
?>
