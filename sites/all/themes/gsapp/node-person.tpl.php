<div class="node <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">

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
    <?php 
    print $node->field_job_title[0]["value"].", ".$node->field_affiliation[0]["value"];
    print $node->field_text[0]["value"];
    ?>
  </div>
  
  <?php
  	if (count($taxonomy)):
  
  	  unset($terms);
	  $terms = array();
	  foreach($node->taxonomy as $key => $val) {
	    if ($val->vid == 3) {
	      $terms[] = l($val->name, "taxonomy/term/" . $val->tid);
	    }
	  }
	  if (count($terms)):
  ?>
    <div class="entrytags"><?php print 'LISTED UNDER: ' . implode(" ", $terms); ?></div>
  <?php if ($links): ?>
    <div class="node-links clearfix entryshare">
      <?php print "Share: ".$links; ?>
    </div>
  <?php endif; ?>
  <?php
	  endif;
  	endif;
  ?>
  

</div> <!-- /node -->
