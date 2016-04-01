<?php
$this->assign('title', __d('croogo', 'Create content'));
?>
<h2 class="hidden-md-up"><?php echo $this->fetch('title'); ?></h2>
<?php
$this->Html->addCrumb('', '/admin', ['icon' => 'home'])
    ->addCrumb(__d('croogo', 'Content'), ['action' => 'index'])
    ->addCrumb(__d('croogo', 'Create'), '/' . $this->request->url);
?>
<div class="<?= $this->Theme->getCssClass('row') ?>">
    <div class="<?= $this->Theme->getCssClass('columnFull') ?>">
        <p class="lead"><?= __d('croogo', 'Select the type of content you wish to create from the list below') ?></p>
        <div class="list-group">
            <?php foreach ($types as $type): ?>
                <?php
                if (!empty($type->plugin)):
                    continue;
                endif;
                ?>
                <a href="<?= $this->Url->build(['action' => 'add', $type->alias]) ?>" class="list-group-item">
                    <h4 class="list-group-item-heading"><?= h($type->title) ?></h4>
                    <p class="list-group-item-text"><?= h($type->description) ?></p>
                </a>
                <div class="type">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
