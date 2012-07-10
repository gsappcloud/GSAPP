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
      	//Manually place one of the header labels.
      	$header["field_speaker_nid"] = "Professional title/affiliation";
      	
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
    <?php foreach ($rows as $count => $row): 
    	//Load the event node
    	$event_row_node = node_load($row["nid"]);

    	//Load the Speaker node(s) referenced within event node
    	$speaker_name = array();
   		$speaker_title_affil = "";
    	$speaker_array = $event_row_node->field_user_speaker;
    	if (!empty($speaker_array[0]["uid"])) {
    		$num_of_speakers = count($speaker_array);
    		$comma_counter = 1;
    		foreach ($speaker_array as $speaker_node) {
	    		$speaker_node_ref = user_load($speaker_node["uid"]);
	    		if($speaker_node_ref->profile_lastname && $speaker_node_ref->profile_firstname){
	    			$speaker_name[$speaker_node_ref->uid] = $speaker_node_ref->profile_lastname.', '.$speaker_node_ref->profile_firstname;
	    		}
	    		else{
	    			$speaker_name[$speaker_node_ref->uid] = $speaker_node_ref->name;
	    		}
	    		if($speaker_node_ref->profile_affiliation){
	    			$speaker_title_affil .= $speaker_node_ref->profile_title.", ".$speaker_node_ref->profile_affiliation;
	    		}
	    		else{
	    			$speaker_title_affil .= $speaker_node_ref->profile_title;
	    		}
	    		
	    		if ($comma_counter > 0 && $comma_counter < $num_of_speakers) {
					
					$speaker_title_affil .= "<br/>";
				}
				$comma_counter++;
    		}
    	}
    	
    	natcasesort($speaker_name); 
    	foreach($speaker_name as $uid => $speaker)
    	{
    		$speaker_name[$uid] = l($speaker,'user/'.$uid);
    	}

    ?>
      <tr class="<?php print ($count % 2 == 0) ? 'even' : 'odd';?>">
        <?php 
            if (!$row["edit_node"]) {
	      		unset($row["edit_node"]);
      		}
        foreach ($row as $field => $content): ?>
          <td class="views-field views-field-<?php print $fields[$field]; ?>">
            <?php 
            if ($fields[$field] == "nid"  ) {
				print implode('<br>',$speaker_name);
			} elseif ($fields[$field] == "field-speaker-nid" ) {
				print $speaker_title_affil;
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
