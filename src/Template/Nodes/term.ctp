<?php

$titles = [];
if (isset($term)):
    $titles[] = $term->title;
endif;
if (isset($type)):
    $titles[] = $type->title;
endif;
$this->assign('title', implode (' | ', $titles));

?>
<div class="nodes">

    <?php
        if (count($nodes) == 0) {
            echo __d('croogo', 'No items found.');
        }
    ?>

    <?php
        foreach ($nodes as $node):
            $this->Nodes->set($node);
    ?>
    <div id="node-<?php echo $this->Nodes->field('id'); ?>" class="node node-type-<?php echo $this->Nodes->field('type'); ?>">
        <h2><?php echo $this->Html->link($this->Nodes->field('title'), $this->Nodes->field('url')->getUrl()); ?></h2>
        <?php
            echo $this->Nodes->info();
            echo $this->Nodes->body();
            echo $this->Nodes->moreInfo();
        ?>
    </div>
    <?php
        endforeach;
    ?>

    <div class="paging"><?php echo $this->Paginator->numbers(); ?></div>
</div>