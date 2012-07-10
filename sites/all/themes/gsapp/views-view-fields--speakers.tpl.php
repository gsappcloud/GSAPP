<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<div class="entry">
<div class = 'person-name'>
	<?php print l($row->profile_values_profile_lastname_value.', '.$row->profile_values_profile_firstname_value,'user/'.$row->uid,array('attributes' => array('class'=> 'peopleLink')));?>
</div>
<div class='person-title'>
	<span class="views-label">Title: </span><?php print $row->profile_values_profile_title_value?>
</div>
<?php
//get all the tags that the person is associated with from the nodes
$view = views_get_view('person_nodes');

$view->execute_display('block_1',array($row->uid));
$tags = array();
foreach($view->result as $node)
{
	$node = node_load($node->nid);
	if(count($node->tags[3])>0)
	foreach($node->tags[3] as $tid =>$term)
	{
		$tags[$tid] = $term;
	}
	
}

foreach($tags as $tid => $term)
{
	$links['taxonomy_term_'. $term->tid] = array(
            'title' => $term->name,
            'href' => taxonomy_term_path($term),
            'attributes' => array('rel' => 'tag', 'title' => strip_tags($term->description))
          );

    
}
?>
<?php if($links):?>
<div class="views-field-tid">
<span class="views-label-tid">Listed Under: </span>
<span class="field-content">
<?php print theme('links', $links);?>
</span>
</span>
</div>
<?php endif;?>
</div>