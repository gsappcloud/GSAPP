<?php if(array_key_exists('72',$node->taxonomy)):
//exhibition
?>
	
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
	    <span class="date-display-single"><?php print $node->field_assign_date[0]['value'];?></span>
	   
		    <div class="views-field-title">
		      	<?php print l($title,'node/'.$node->nid);?>
		    </div>
		
	<?php else:?>
	 	<?php if(!$page && $teaser):?>
		     <div class="views-field-title">
		    	<?php print l($title,'node/'.$node->nid, array('attributes' => array('class'=>'titleLink2')));?>
		     </div>
	  	<?php elseif(!$page):?>
		     <h3 class="title">
		      	<?php print $title;?>
		     </h3>
	  	<?php endif;?>
		 <div class="date-display-single"><?php print $node->field_assign_date[0]['value'];?></div>
	<?php endif;?>
 	<div class="time-display-single"><?php print $node->field_assign_time[0]['value'];?></div>
    <div class="views-field-field-location-value"><?php print $node->field_location[0]['value']?></div>
  <?php if (!$page && $teaser): ?>
    <?php if(arg(0) == 'node' && arg(1) == '11'): ?>
   	 <div class="views-field-field-image"><?php print $node->field_image[0]['view'];?></div>
    <?php endif; ?>
    
        <?php if(user_access('manage feed items')): ?>
		    <div class='views-field-edit-node'>
		    	<span class="field-content">
		    	    <?php print l('Edit in Sundial','https://calendar.columbia.edu/sundial/priv/eventView/index.php?nav=eventEdit&EventID='.$node->field_event_id[0]['value'],array('attributes'=>array('target'=>'_blank')));?>
		    		<?php print l('Edit','node/'.$node->nid.'/edit',array('query'=>array('destination'=>$_GET['q'])));?>
		    		
		    	</span>
		    </div>
    	<?php endif; ?>
    
    <div class="views-field-field-teaser"><?php print $node->field_short_description[0]['value']?></div>
  <?php else: ?>
  
        <?php if(user_access('manage feed items')): ?>
		    <div class='views-field-edit-node'>
		    	<span class="field-content">
		    	    <?php print l('Edit in Sundial','https://calendar.columbia.edu/sundial/priv/eventView/index.php?nav=eventEdit&EventID='.$node->field_event_id[0]['value'],array('attributes'=>array('target'=>'_blank')));?>
		    	</span>
		    </div>
    	<?php endif; ?>
    	
   
    
    <?php foreach($node->field_user_speaker as $speaker)
    {
    	$speaker_view = user_load($speaker['uid']);
    	
    	if($speaker_view->uid)
    	$speakers[$speaker_view->uid] = ($speaker_view->profile_name?$speaker_view->profile_name:$speaker_view->name);
    	
    }
    if(is_array($speakers)){
    	natcasesort($speakers);
  
		foreach($speakers as $uid =>$speaker){
			$speakers[$uid] = l($speaker,'user/'.$uid,array('html'=>1));
		}
    }
    
    ?>
    <?php if(count($speakers)>0):?>
   	 	<div class="field views-field-field-speaker-value">
    	<?php print implode(', ',$speakers)?></div>
    <?php endif ?>
  <div class="content">
  	<?php print ($node->content['body']['#value'] ? $node->content['body']['#value'] : $node->body);?>
  </div>
   
  
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
<?php endif;?>

<?php if(array_key_exists('71',$node->taxonomy)):
//EVENT
?>


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
     <a class = 'titleLink2' href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </div>
     <?php if(user_access('manage feed items')):?>
	    <div class='views-field-edit-node'>
	    	<span class="field-content">
	    		<?php print l('Edit','node/'.$node->nid.'/edit',array('query'=>array('destination'=>$_GET['q'])));?>
	    		
	    	</span>
	    </div>
	    <div class='views-field-edit-node'>
	    	<span class="field-content">
	    		<?php print l('Edit in Sundial','https://calendar.columbia.edu/sundial/priv/eventView/index.php?nav=eventEdit&EventID='.$node->field_event_id[0]['value'],array('attributes'=>array('target'=>'_blank')));?>
	    	</span>
	    </div>		
    <?php endif; ?>
   <?php elseif(!$page): ?>
    <h3 class="title">
		<?php print $title;?>
	</h3>
    <?php elseif($page):?>
    <?php if(user_access('manage feed items')):?>
	    <div class='views-field-edit-node'>
	    	<span class="field-content">
	    		
	    		<?php print l('Edit in Sundial','https://calendar.columbia.edu/sundial/priv/eventView/index.php?nav=eventEdit&EventID='.$node->field_event_id[0]['value'],array('attributes'=>array('target'=>'_blank')));?>
	    		
	    	</span>
	    </div>
    <?php endif; ?>
  	<?php endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>
   <div class="date-display-single"><?php print $node->field_assign_date[0]['value'];?></div>
	
 	<div class="time-display-single"><?php print $node->field_assign_time[0]['value'];?></div>
    <div class="views-field-field-location-value"><?php print $node->field_location[0]['value']?></div>
    
    <?php foreach($node->field_user_speaker as $speaker)
    {
    	$speaker_view = user_load($speaker['uid']);
    	
    	if($speaker_view->uid)
    	$speakers[$speaker_view->uid] = ($speaker_view->profile_name?$speaker_view->profile_name:$speaker_view->name);
    	
    }
    if(is_array($speakers)){
    	natcasesort($speakers);
    	foreach($speakers as $uid =>$speaker){
			$speakers[$uid] = l($speaker,'user/'.$uid,array('html'=>1));
		}
    }
    
  
	
    ?>
   
  <div class="content">
    <?php if(!$page && $teaser):?>
   		<div class="views-field-field-teaser"><?php print $node->field_short_description[0]['value']?></div>
  	<?php else:?>
	  	 <?php if(count($speakers)>0):?>
	   	 	<div class="field views-field-field-speaker-value">
	    	<?php print implode(', ',$speakers)?></div>
	    <?php endif ?>
  		 <?php print ($node->content['body']['#value'] ? $node->content['body']['#value'] : $node->body);?>
  	<?php endif;?>
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
  <?php if ($page && !$teaser && $links): ?>
    <div class="node-links clearfix entryshare">
      <?php print "Share: ".$links; ?>
    </div>
  <?php endif; ?>

</div> <!-- /node -->
<?php endif;?>