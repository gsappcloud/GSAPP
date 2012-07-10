<?php
//reload the node for preview
if(!$node->tags && $node->nid)
{
	$node = node_load($node->nid);
}
?>

<div class="entry node <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">
<?$no_title_nodes = array(11);?>
  <?php if (!$page && $teaser): ?>
    <a class="titleLink2" href="<?php print $node_url; ?>"><?php print $title; ?></a>
    <?php if(user_access('edit any annoucement content')): ?>
	    <div class='views-field-edit-node'>
	    	<span class="field-content">
	    		<?php print l('Edit','node/'.$node->nid.'/edit?destination='.$_GET['q']);?>
	    	</span>
	    </div>
    <?php endif; ?>
  <?php elseif ((!$page && !$teaser)): ?>
    <h4 class="title">
      <?php print $title; ?>
    </h4>
  <?php endif; ?>  
  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="content">
    <?php
	  if (!$page && $teaser) {
	  	//die(var_dump($node->field_teaser[0]['value']));
	    print (!empty($node->field_teaser[0]['value'])) ? $node->field_teaser[0]['value'] : $node->field_text[0]['value'];
	  }
	  else {
		print $node->field_text[0]['value'];
	  }
	?>
  </div>

  <?php
  	$tags_vid = 3;
    $tags = array();
    if(is_array($node->tags[$tags_vid]))
    {
    	foreach($node->tags[$tags_vid] as $tid => $tag)
		{
			if($tag->name)
			{
				$tags[$tag->tid] = l($tag->name,'taxonomy/term/'.$tag->tid);
			}
		}
  ?>
    <div class="entrytags"><?php print 'LISTED UNDER: ' . implode(" ", $tags); ?></div>
  <?php
    }
  ?>
  
  <?php if ($page && !$teaser && $links): ?>
    <div class="node-links clearfix entryshare">
      <?php print "Share: ".$links; ?>
    </div>
  <?php endif; ?>
  
  <?php
  if ($page) {
  	print $node->content['book_navigation']['#value'];
  }
  ?>

</div> <!-- /node -->
<?php
  if ($page && $node->comment_count) {
    print '<h2 id="comments-title">Discussion</h2>';
  }
?>