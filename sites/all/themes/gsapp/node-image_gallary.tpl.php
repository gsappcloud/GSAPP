<div class="node  entry  <?php print $node_classes; ?>" id="node-<?php print $node->nid; ?>">
  <?php
	    //Load the Speaker node(s) referenced within work node        
        $speaker_name = "";        
        $speaker_array = $ref_work_node->field_user_speaker; 
       
        //die(var_dump($speaker_array));    
        if (!empty($speaker_array[0]["uid"])) {                
                $num_of_speakers = count($speaker_array);                
                $comma_counter = 1;                
                foreach ($speaker_array as $speaker_node) {                        
                    $speaker_node_ref = user_load($speaker_node["uid"]);                        
                    $speaker_name .= theme('username',$speaker_node_ref);                        
                    if ($comma_counter > 0 && $comma_counter < $num_of_speakers) {                                       
                        $speaker_name .= ", ";                                
                    }                                
                    $comma_counter++;                
                }        
        } 
     
        if (!empty($speaker_name)) 
            print "<div id=\"inst\" class=\"views-field-field-speaker-nid\">$speaker_name</div>";
  ?>

  <?php if (!$page): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </h2>
  <?php elseif ($page && $node->teaser): ?>
    <h2 class="title">
      <?php print $title; ?>
    </h2>
  <?php elseif ($page): ?>
  	<h4 class="title">
      <?php print $title; ?>
    </h4>
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

  <?php if ($page && !$teaser && $links): ?>
    <div class="node-links clearfix entryshare">
      <?php print "Share: ".$links; ?>
    </div>
  <?php endif; ?>

</div> <!-- /node -->

