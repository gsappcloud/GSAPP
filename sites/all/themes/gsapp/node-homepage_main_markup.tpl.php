<?php

//reload the node for preview
if(!$node->tags && $node->nid)
{
	$node = node_load($node->nid);
}
?>
    
<div class="entry node <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">
  <?php if (!$page && $teaser): ?>
     <a class="titleLink2" href="<?php print $node_url; ?>"><?php print $title; ?></a>
    <?php if(!$page):?>
    	<a class="titleLink2" href="<?php print $node_url; ?>"><?php print $title; ?></a>
    <?php endif;?>
    <?php if(user_access('edit any page content')): ?>
	    <div class='views-field-edit-node'>
	    	<span class="field-content">
	    		<?php print l('Edit','node/'.$node->nid.'/edit?destination='.$_GET['q']);?>
	    	</span>
	    </div>
    <?php endif; ?>
  <?php endif; ?>
  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="content">
   <?php print $content;?>
  </div>

</div> <!-- /node -->
