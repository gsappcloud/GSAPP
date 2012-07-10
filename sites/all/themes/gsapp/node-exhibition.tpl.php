<?php
//reload the node for preview
if(!$node->tags && $node->nid)
{
	$node = node_load($node->nid);
}

?>
<div class="node entry <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">
 <div class="content">
 	<?php if(arg(0) == 'node' && arg(1) == 11):?>
	    <span class="date-display-single"><?php print date('m.d.Y',strtotime($node->field_date[0]['value']));?>
	    -
	    <?php print date('m.d.Y',strtotime($node->field_date[0]['value2']));?></span>
	   
		    <div class="views-field-title">
		      	<?php print $title;?>
		    </div>
		
	<?php else:?>
	 	<?php if(!$page && $teaser):?>
		     <div class="views-field-title">
		    	<?php print l($title,'node/'.$node->nid)?>
		     </div>
	  	<?php elseif(!$page):?>
		     <h3 class="title">
		      	<?php print $title;?>
		     </h3>
	  	<?php endif;?>
		 <div class="date-display-single"><?php print date('m.d.Y',strtotime($node->field_date[0]['value']));?>
		 -
		 <?php print date('m.d.Y',strtotime($node->field_date[0]['value2']));?></div>
	<?php endif;?>
 	<div class="time-display-single"><?php print date('g:iA',strtotime($node->field_date[0]['value']));?>
    -
    <?php print date('g:iA',strtotime($node->field_date[0]['value2']));?></div>
    <div class="views-field-field-location-value"><?php print $node->field_location[0]['value']?></div>
  <?php if (!$page && $teaser): ?>
    <?php if(arg(0) == 'node' && arg(1) == '11'): ?>
   	 <div class="views-field-field-image"><?php print $node->field_image[0]['view'];?></div>
    <?php endif; ?>
    
        <?php if(user_access('edit any exhibition content')): ?>
		    <div class='views-field-edit-node'>
		    	<span class="field-content">
		    		<?php print l('Edit','node/'.$node->nid.'/edit?destination='.$_GET['q']);?>
		    	</span>
		    </div>
    	<?php endif; ?>
    
    <div class="views-field-field-teaser"><?php print $node->field_teaser[0]['value']?></div>
  <?php else: ?>
    <div class="field field-type-text field-field-text"><?php print $node->field_text[0]['value']?></div>
  
  <?php endif; ?>
 
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
    <?php if($page):?>
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
  	<?php endif; ?>
</div> <!-- /content -->
</div> <!-- /node -->
