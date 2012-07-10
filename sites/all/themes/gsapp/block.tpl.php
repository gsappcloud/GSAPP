<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block->module ?> block-bid-<?php print $block->bid?>">

<?php if ($block->subject): ?>

<?
    //block ids for announcements and broadcast
	$blocks = array(63=>NULL,62=>NULL,95=>'nodequeue_4',96=>'nodequeue_3');
	if(array_key_exists($block->bid,$blocks)){
		//get all the nodes in the associated view and count them
	    $block->delta = (is_numeric($block->delta) ? $blocks[$block->bid] : $block->delta);
		$view = views_get_view(str_replace('-block','',$block->delta));
		if($view)
		{
			$view->execute(NULL,$args);
	  		$nodes = $view->result;
	  		$content_count = count($nodes);
	  		if(count($nodes) == 1){
	  			//replace the s at the end of the block subject
	  			$block->subject = substr_replace($block->subject,'',-1,1);
	  		}
		}

	}?>

  <?php
  $node = node_load(arg(1));
  if($node->nid && $node->type == 'overview_page' && $block->bid == '125'){
  	$block->subject = 'Work';
  }
  	?>


  <?php
  if (user_access('administer menu')) {
      //Print edit links only for maintainer role.
      $node = node_load(arg(1));
      if($node->nid == '6' && $block->bid == '129'){
      	print "<div class=\"views-field-edit-node edit-menu-block-link\">".l('Edit', "admin/build/menu-customize/menu-gsapp?destination=")."</div>";
      }
      if($node->nid == '6' && $block->bid == '130'){
      	print "<div class=\"views-field-edit-node edit-menu-block-link\">".l('Edit', "admin/build/menu-customize/menu-extension?destination=")."</div>";
      }
      if($node->nid == '6' && $block->bid == '133'){
      	print "<div class=\"views-field-edit-node edit-menu-block-link\">".l('Edit', "admin/build/menu-customize/primary-links?destination=")."</div>";
      }
  }
  	?>

  <h2><?php
  if ($block->bid == 76) {
  	print l('Tags Used', 'tags-used');
  }
  elseif ($block->bid == 75) {
  	print l('Tags Viewed', 'tags-viewed');
  } else {
  	print $block->subject;
  }
  ?></h2>
<?php endif;?>
  <div class="content"><?php print $block->content ?></div>
</div>