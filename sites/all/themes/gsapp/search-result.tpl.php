<?php
// $Id: search-result.tpl.php,v 1.1.2.1 2008/08/28 08:21:44 dries Exp $

/**
 * @file search-result.tpl.php
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $type: The type of search, e.g., "node" or "user".
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type.
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 * - $info_split['upload']: Number of attachments output as "% attachments", %
 *   being the count. Depends on upload.module.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for their existance before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 *
 *   <?php if (isset($info_split['comment'])) : ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 *
 * To check for all available data within $info_split, use the code below.
 *
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 *
 * @see template_preprocess_search_result()
 */
?>

<dd>
 <?php if($type == 'node'):?>
  <?php if($node){
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
    print '<div class="entry">';
  	print '<div class="title">'.l($node->title,'node/'.$node->nid,array('attributes' => array('class'=>'titleLink2'))).'</div>';
  	?><?php if(user_access('edit any page content')): ?>
	    <div class='views-field-edit-node'>
	    	<span class="field-content">
	    		<?php print l('Edit','node/'.$node->nid.'/edit?destination='.$_GET['q']);?>
	    	</span>
	    </div>
    <?php endif; ?><?
  	print '<div class="content">'.($node->field_teaser[0]['value'] ? $node->field_teaser[0]['value'] : $node->teaser).'</div>';
  	if(count($tags) >0)
  	print '<div class="entrytags">Listed Under: '.implode(' ',$tags).'</div>';
  	print '</div>';
  }?>
<?php elseif ($type == 'profile'):?>
	<?php $user = user_load(array('name'=>$title));?>
	<?php if($user->uid > 2):?>
	<div class="entry">
		<div class="person-name"><?php print l($user->profile_lastname.", ".$user->profile_firstname,'user/'.$user->uid,array('attributes'=>array('class'=>'peopleLink')))?></div>
		<div class="person-title">Title: <?php print $user->profile_title;?></div>
	</div>
	<?php endif;?>
<?php endif; ?>
</dd>
