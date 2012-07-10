<?php
//reload the node for preview
if(!$node->tags && $node->nid)
{
	$node = node_load($node->nid);
}
?>
    
<div class="entry node <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">
<?$no_title_nodes = array(11);?>
  <?php if (!$page && $teaser): 
     if (!empty($node->field_image[0]['view'])): ?>
            <div class="views-field-field-image"><?php print $node->field_image[0]['view'];?></div>
     <?php endif; ?>
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
    <?php
	    //Load the Speaker node(s) referenced within work node        
        $speaker_name = array();        
        $speaker_array = $node->field_user_speaker; 
       
        //die(var_dump($speaker_array));    
        if (!empty($speaker_array[0]["uid"])) {    
                foreach ($speaker_array as $speaker_node) { 
                	if($speaker_node){
                		$speaker_node_ref = user_load($speaker_node["uid"]);  
                		if($speaker_node_ref->uid)                      
                    	$speaker_name[$speaker_node_ref->uid] = ($speaker_node_ref->profile_name?$speaker_node_ref->profile_name:$speaker_node_ref->name);    
                	}
                                                      
                }
                natcasesort($speaker_name);        
        }
        foreach($speaker_name as $uid => $speaker)
    	{
    		$speaker_name[$uid] = l($speaker,'user/'.$uid);
    	} 
        if (count($speaker_name) > 0) {
        	 print "<div id=\"inst\" class=\"views-field-field-speaker-nid\">".implode(', ',$speaker_name)."</div>";
        }
           
		
      if (!$page && $teaser) {
            if (!empty($node->field_teaser[0]['value'])) 
            print "<div class=\"views-field-field-teaser-value\"><span class=\"field-content\">".$node->field_teaser[0]['value']."</span></div>";
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
    <div class="entrytags float-entrytags"><?php print 'LISTED UNDER: ' . implode(" ", $tags); ?></div>
  <?php
    }
  ?>
  <br class = 'clear-floats'/>
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