<?php
$this->Croogo->adminScript('Nodes.admin');
if (Configure::read('Writing.wysiwyg')) {
    $this->Html->scriptBlock($tinymce->fileBrowserCallBack(), ['inline' => false]);
    $this->Html->scriptBlock($tinymce->init('NodeBody'), ['inline' => false]);
}
?>
<div class="nodes form">
    <h2><?= $title_for_layout ?></h2>

    <?php
        echo $this->Form->create('Node', ['url' => [
            'action' => 'translate',
            'locale' => $this->getRequest()->getQuery('locale'),
        ]]);
        ?>
    <fieldset>
        <div class="tabs">
            <ul>
                <li><a href="#node-main"><span><?= __d('croogo', $type['Type']['title']) ?></span></a></li>
            </ul>

            <div id="node-main">
            <?php
            foreach ($fields as $field) {
                echo $this->Form->input('Node.' . $field);
            }
            ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->end('Submit');?>
</div>
