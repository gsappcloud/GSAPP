<?php
// $Id: views-view-table.tpl.php,v 1.6 2008/06/25 22:05:11 merlinofchaos Exp $
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $rows: An array of row items. Each row is an array of content
 *   keyed by field ID.
 * @ingroup views_templates
 */
?>
<table class="<?php print $class; ?>">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr>
      <?php 
      	unset($header["field_date_time_to_value"]);
      	unset($header["field_date_time_from_value"]);

      	if (!$header["edit_node"]) {
	      	unset($header["edit_node"]);
      	}
      ?>
      <?php foreach ($header as $field => $label): ?>
        <th class="views-field views-field-<?php print $fields[$field]; ?>">
          <?php print $label; ?>
        </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php
     
      foreach ($rows as $count => $row):         
        //Load the event node
    	$work_row_node = node_load($row["nid"]);

        //Load the Speaker node(s) referenced within work node
    	$speaker_name = "";
    	$speaker_array = $work_row_node->field_user_speaker;

    	if (!empty($speaker_array[0]["uid"])) {
    		$num_of_speakers = count($speaker_array);
    		$comma_counter = 1;
    		foreach ($speaker_array as $speaker_node) {
	    		$speaker_node_ref = user_load($speaker_node["uid"]);
	    		if($speaker_node_ref->profile_lastname){
	    			$speaker_name .= l($speaker_node_ref->profile_lastname, 'user/'.$speaker_node_ref->uid);
	    		}
	    		else{
	    			$speaker_name .= l($speaker_node_ref->name, 'user/'.$speaker_node_ref->uid);
	    		}
	    		if ($comma_counter > 0 && $comma_counter < $num_of_speakers) {
					$speaker_name .= "/";
				}
				$comma_counter++;
    		}
    	} 
    	
    	$days = str_replace(array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", '<div class="field-item">', '</div>'), array("Su", "M", "Tu", "W", "Th", "F", "Sa", '', ' '), $row["field_class_day_value"]);
    	$days_array = explode(" ", $days);
    	if (count($days_array) > 1) {
    	    array_pop($days_array); //This removes the empty array element at the end of each days array when days array > 1. This happens because of the str_replace of </div>.  
    	    $last_day = array_pop($days_array);
            $days2 = join(" ",$days_array);
            $days2 = $days2.' & '.$last_day;
            $days = $days2;
        }

    	$time = $row["field_date_time_from_value"]." - ".$row["field_date_time_to_value"]; 

    ?>
      <tr class="<?php print ($count % 2 == 0) ? 'even' : 'odd';?>">
        <?php 
          	unset($row["field_date_time_to_value"]);
          	unset($row["field_date_time_from_value"]);
            if (!$row["edit_node"]) {
	      		unset($row["edit_node"]);
      		}
        foreach ($row as $field => $content): ?>
          <td class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php 
            if ($fields[$field] == "nid"  ) {
				print $speaker_name;
			} elseif ($fields[$field] == "field-class-day-value" ) {
				print $days.' '.$time;
			} else {
	            print $content; 
			}
            ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
