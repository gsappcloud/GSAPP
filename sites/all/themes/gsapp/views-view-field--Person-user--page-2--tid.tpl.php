<?php
// $Id: views-view-field.tpl.php,v 1.1 2008/05/16 22:22:32 merlinofchaos Exp $
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, this construct should be used:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
?>

<?php 
$result_values = array();
$result_values = array_values($field->items);
$result_values = $result_values[0];
$count = 1;


$content_profile_node = content_profile_load(variable_get('my_site_lite_taxonomy_profile_node','my_site'), $user->uid);

$order_list = explode(',',$content_profile_node->field_taxonomy_order[0]['value']);

foreach($order_list as $tid){
	if($tid && $result_values[$tid]){
		$taxonomy_order[$tid] = $result_values[$tid];
	}
	
}


?>
<?php
$view = views_get_view('nodequeue_12');
$output = $view->execute_display('default');

if($output){
	print $output;
}


foreach($taxonomy_order as $tid => $taxonomy_formatted){
	//There are special cases where we should load the right view for some sections.
	switch ($tid)
	{
		case 6:
			//news and events section
			$view_name = 'events';
			$display_name = 'block_5';
			$display_args = array();
			break;
		case 71:
			//upcoming events section
			$view_name = 'events';
			$display_name = 'block_3';
			$display_args = array();
			break;
		case 72:
			//upcoming exhibitions
			$view_name = 'upcoming_exhibitions';
			$display_name = 'block_2';
			$display_args = array();
			break;
		case 191:
			//upcoming announcements
			$view_name = 'broadcast_announcements';
			$display_name = 'block_2';
			$display_args = array();
			break;
		case 192:
			//upcoming broadcasts
			$view_name = 'broadcast_announcements';
			$display_name = 'block_3';
			$display_args = array();
			break;
		case 193:
			//events archived
			$view_name = 'events';
			$display_name = 'block_4';
			$display_args = array();
			break;
			
		default:
			$view_name = 'taxonomy_term';
			$display_name = 'block_4';
			$display_args = array($tid);
		
	}
	
	
	
	
	$view = views_get_view($view_name);
	$output = $view->execute_display($display_name,$display_args);

	if($output['content']){
		print('<div class="site-block block-tid-'.$tid.'"><h4><span>'.$output['subject'].l('-','my_site_lite/remove/'.$tid,array('attributes'=>array('class'=>'my-site-lite-remove'))).'</span></h4>'.$output['content'])."</div>";
		$count%3 == 0 ? print "<br class='clear-floats'>":"";
		$count++;
	}
}
?>