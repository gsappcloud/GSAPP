<?php //autoapply filter for all courses, pass a session of the current program visited
	if($page){
		foreach($node->taxonomy as $tid => $term){
			if($term->vid == '4' && $_SESSION['main_filter'] != $tid){
			//drupal_goto($_GET['q'],'filter='.$tid);
			//$_SESSION['overview_page_program'] = $tid;
		}
	}
	}
?>

<div class="node <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">

  <?php if (!$page): ?>
    <div class="title">
      <a class="titleLink2" href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </div>
     <?php if(user_access('edit any overview_page content')):?>
	    <div class='views-field-edit-node'>
	    	<span class="field-content">
	    		<?php print l('Edit','node/'.$node->nid.'/edit?destination='.$_GET['q']);?>
	    	</span>
	    </div>
    <?php endif; ?>
  <?php elseif ($page && $node->teaser): ?>
    <h2 class="title">
      <?php print $title; ?>
    </h2>
  <?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>
  <div class="content">
  
  <?php if($node->field_image[0]['filepath'])
	  {
	  	if($page){
	  		print theme('imagecache', 'overview_banner', $field_image[0]['filepath']);
	  	}
	  }?>
	  <div class="left-overview-content">
	  <div class="entry">
		  <?php if($page && !$teaser):?>
			  
			  <h3 class="title">
			     <?php print $title; ?>
			  </h3>
			  <?php //print ($right_inner) ? '<div class="right_inner">' . $right_inner . '</div>' : ''; ?>
		  <?php endif; ?>
		  <?php print $content; ?>
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
    }
	
    ?>
    <?php if(count($tags) > 0):?>
    <div class="views-field-tid"><span class='views-label-tid'>Listed Under: </span><span class='field-content'><?php print implode(' ',$tags); ?></span></div>
	<?php endif;?>
	
  <?php if ($page && !$teaser && $links): ?>
    <div class="node-links clearfix entryshare">
      <?php print "Share: ".$links; ?>
    </div>
  <?php endif; ?>
      </div>
	  </div>
	  <?php if($page):?>
	  <div class='right-overview-sidebar'>
	  
	  	  <?php print _generate_overview_page_views_block('nodequeue_3','block_1',NULL,1);?>
	  	  <?php print _generate_overview_page_views_block('featured_event','block_2');?>
	  	  <?php print _generate_overview_page_views_block('today_events','block_2');?>
	  </div>
	  <?php endif;?>
  </div>
  
  
</div> <!-- /node -->
<?php 
if($page){
	print _gsapp_director_comment_render($node);
}
?>
