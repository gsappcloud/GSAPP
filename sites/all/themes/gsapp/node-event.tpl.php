<?php
//reload the node for preview
if(!$node->tags && $node->nid)
{
	$node = node_load($node->nid);
}
if (!$page && $teaser) {	
	if ($terms = taxonomy_node_get_terms_by_vocabulary($node, 2)) {
		if(arg(0) == 'upcoming-events' && is_numeric(arg(1))) {
			drupal_set_title($terms[arg(1)]->name);
		}
	}
}  
?>
<div class="node entry <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">

  <?php if (!$page && $teaser): ?>
    <div class='views-field-title'>
     <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </div>
     <?php if(user_access('edit any event content')):?>
	    <div class='views-field-edit-node'>
	    	<span class="field-content">
	    		<?php print l('Edit','node/'.$node->nid.'/edit?destination='.$_GET['q']);?>
	    	</span>
	    </div>
    <?php endif; ?>
   <?php elseif(!$page): ?>
    <h3 class="title">
		<?php print $title;?>
	</h3>
    
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>
  
  <div class="content">
  	<?php print $content; ?>
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
  <?php
	  endif;
  	endif;
  ?>
	<div class="entryshare">
	Share:
		<a href="#">del.icio.us</a>
		<a href="#">Stumble Upon</a>
		<a href="#">Reddit</a>
		<a href="#">Digg</a>
		<a href="#">Facebook</a>
	</div>

  <?php if ($links): ?>
    <div class="node-links clearfix">
      <?php print $links; ?>
    </div>
  <?php endif; ?>

</div> <!-- /node -->
