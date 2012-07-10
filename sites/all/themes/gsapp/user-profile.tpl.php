<?php
// $Id: user-profile.tpl.php,v 1.2.2.1 2008/10/15 13:52:04 dries Exp $

/**
 * @file user-profile.tpl.php
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * By default, all user profile data is printed out with the $user_profile
 * variable. If there is a need to break it up you can use $profile instead.
 * It is keyed to the name of each category or other data attached to the
 * account. If it is a category it will contain all the profile items. By
 * default $profile['summary'] is provided which contains data on the user's
 * history. Other data can be included by modules. $profile['user_picture'] is
 * available by default showing the account picture.
 *
 * Also keep in mind that profile items and their categories can be defined by
 * site administrators. They are also available within $profile. For example,
 * if a site is configured with a category of "contact" with
 * fields for of addresses, phone numbers and other related info, then doing a
 * straight print of $profile['contact'] will output everything in the
 * category. This is useful for altering source order and adding custom
 * markup for the group.
 *
 * To check for all available data within $profile, use the code below.
 *
 * @code
 *   print '<pre>'. check_plain(print_r($profile, 1)) .'</pre>';
 * @endcode
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-field.tpl.php
 *   Where the html is handled for each item in the group.
 *
 * Available variables:
 *   - $user_profile: All user profile data. Ready for print.
 *   - $profile: Keyed array of profile categories and their items or other data
 *     provided by modules.
 *
 * @see template_preprocess_user_profile()
 */
?>
<div class="profile">
<?php  

	
 	$view =  views_get_view('person_user');
    $output = $view->execute_display('block_1',array($account->uid));
    if(count($view->result) > 0){
    	$user_current = user_load($view->result[0]->uid);
    	print '<div class="person-top-text">';
   
    	if($account->uid == $user->uid || user_access('administer users')){
			print '<div class="views-field-edit-node">'.l('Edit Profile','user/'.$account->uid.'/edit/Additional Information',array('query'=>'destination='.$_GET['q'])).'</div>';
		}
    
    	print $output['content'].'</div>';
    
    	$view = views_get_view('person_nodes');
    	print '<div class="person-listing">'.$view->execute_display('default',array($account->uid)).'</div>';;
    
    	drupal_set_title($account->profile_name);
    }
 	else{//only show user profiles that belong to a certain role, setting is in the view filter.
 		drupal_access_denied();
 		exit();
 	}
    
 
$uid= arg(1);

  if (_guestbook_access('administer', $uid) && is_numeric($op_id)) {
    switch ($op) {
      case "delete":
       $y = guestbook_delete_entry_confirm($uid, $op_id);
      case 'comment':
        $comment_entry = $op_id;
        break;
    }
  }

  // Fetch guestbook entries
  $userid4 = arg(1);
  $limit = variable_get('guestbook_entries_per_page', 20);
  $result = pager_query(
    "SELECT g.*, u1.name, u1.data, u1.picture, u2.name as commentby
    FROM {guestbook} g
    LEFT JOIN {users} u1 ON g.author = u1.uid
    LEFT JOIN {users} u2 ON g.commentauthor = u2.uid
    WHERE g.recipient = $userid4
    ORDER BY g.created DESC",
    $limit, 0, "SELECT COUNT(*) FROM {guestbook} WHERE recipient = %d", $userid4);
  $entries = array();
 
  while ($entry = db_fetch_array($result)) {
    $entries[] = $entry;
  }
  
  print theme('guestbook', $userid4, $entries, $comment_entry, $limit);
 		
 ?>
</div>
  <?php if ($links): ?>
    <div class="node-links clearfix entryshare">
      <?php print "Share: ".$links; ?>
    </div>
  <?php endif; ?>
  
  <?php //menu_set_active_item('people');?>