<div class="node  entry  <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">



  <?php if (!$page): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </h2>
  <?php elseif ($page && $node->teaser): ?>
    <h2 class="title">
      <?php print $title; ?>
    </h2>
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

 
  
  <div class="content">
    <?php print $content; ?>
  </div>

  <?php if ($links): ?>
    <div class="node-links clearfix">
      <?php print $links; ?>
    </div>
  <?php endif; ?>

</div> <!-- /node -->
