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
	 
  <?php if ($links): ?>
    <div class="node-links clearfix">
      <?php print $links; ?>
    </div>
  <?php endif; ?>

</div> <!-- /node -->
