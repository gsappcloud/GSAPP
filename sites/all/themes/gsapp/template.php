<?php
// $Id: template.php,v 1.16 2007/10/11 09:51:29 goba Exp $


/**
 * Implementation of HOOK_theme().
 */
function gsapp_theme(&$existing, $type, $theme, $path) {
  return zen_theme($existing, $type, $theme, $path);
}

function gsapp_preprocess(&$vars, $hook){

	global $user;
	
	restrict_access_to_jobs_section($vars);
	

		if($vars['node']->type == 'overview_page' )
		{
			if(in_array('Director',$user->roles))
			{
				$vars['node']->comment = 2;
			}
			else
			{
				$vars['node']->comment = 0;
			}
		}
		if($hook == 'node'){
			if($vars['node']->field_work_page_reference[0]['nid'] && $vars['node']->type == 'image_gallary'){
			$_SESSION['gallary_node_id'] = $vars['node']->nid;
			$vars['ref_work_node'] = node_load($vars['node']->field_work_page_reference[0]['nid']);
			drupal_set_title($vars['ref_work_node']->title);
			//automatically set the active menu item to the referenced node id so all correct menu blocks show
			menu_set_active_item('node/'.$vars['ref_work_node']->nid);
			}

      if ($vars['page'] == TRUE) {
        if (isset($vars['field_require_wind'])) { 
          if ($vars['field_require_wind'][0]['value'] == 1) { /* WIND-required pages */
            if (!$user->uid) {
              drupal_goto("user/wind", "wind_destination_path=node/". $vars['nid']);
            }
          }
        }
      }

		}

		if($hook == 'block' && $vars['block']->module == 'menu_block' && $vars['block']->region == 'left_outer')
		{
			//set the active menu back to what it was initialy so that edit links work correctly from this point on.
				if($_SESSION['gallary_node_id']){
					menu_set_active_item('node/'.$_SESSION['gallary_node_id']);
					unset($_SESSION['gallary_node_id']);
				}


		}
}


function gsapp_preprocess_comment_wrapper(&$vars, $hook){
	global $user;
	$vars['node']->access_post_comments = 0;
	if($vars['node']->type == 'overview_page' )
	{
		if(in_array('Director',$user->roles))
		{
			$vars['node']->access_post_comments = 1;
		}
	}

}
function gsapp_preprocess_comment(&$vars, $hook){
global $user;
	if($vars['node']->type == 'overview_page' )
	{
		if(!in_array('Director',$user->roles))
		{
			unset($vars['links']);
			if(arg(1) == 'reply' || arg(1) == 'edit')
			{
				drupal_access_denied();
			}
		}
	}
}


function gsapp_preprocess_page(&$vars, $hook) {
  global $user,$base_url, $includes_dir;

  $vars['includes_dir'] = $includes_dir;

  if ($vars['node']->type == "page" ) {
	if ($terms = taxonomy_node_get_terms_by_vocabulary($vars['node'], 2)) {
	  $vars['title'] = reset($terms)->name;
	}
  }
  elseif (arg(0) == "calendar" && arg(1)) {
    $timestamp = strtotime(arg(1));
    $vars['title'] = "Events for " . date("F j, Y", $timestamp);
	$vars['head_title'] = $vars['title'] . ' | ' . $vars['head_title'];
  }
  if ($vars['node']->type == "overview_page" )
  {//title goes under the banner, it is in node-overview_page.tpl.php
  	unset($vars['title']);

  }

  if($vars['node']->nid == '11')
  {
  	unset($vars['tabs']);
  }

  if(arg(0) == 'search')
  {
  	$vars['title'] = 'Advanced Search';
  }
  if($_SESSION['main_filter'])
  {
  	$vars['main_filter_title'] = (taxonomy_get_term($_SESSION['main_filter'])->name);
  }
 if(arg(0)== 'user' && arg(2) == 'edit')
  {
  	 $user_profile = user_load(arg(1));
	  if(!empty($user_profile->profile_name)){
	  	$vars['title'] = $user_profile->profile_name;
	  }
  }
  
  if($user->uid){
  	drupal_set_header('Expires: Thu, 01 Dec 1994 16:00:00 GMT');
  }

  if ($_GET['q'] == "node/6782/delete" || $_GET['q'] == "node/6/delete") {
    drupal_set_message(t('Cannot delete home page.'));
    drupal_goto();
  }
}


function gsapp_preprocess_node(&$vars, $hook) {
}



function gsapp_preprocess_views_view(&$variables) {
	$variables['view']->is_cacheable = 0;
}


function gsapp_preprocess_book_navigation(&$variables) {
}

/* Maybe not needed?
function gsapp_pager_previous($text, $limit, $element = 0, $interval = 1, $parameters = array()) {
  global $pager_page_array;
  $output = '';

  // If we are anywhere but the first page
  if ($pager_page_array[$element] > 0) {
    $page_new = pager_load_array($pager_page_array[$element] - $interval, $element, $pager_page_array);
    // If the previous page is the first page, mark the link as such.
    if ($page_new[$element] == 0) {
      $output = theme('pager_first', "More", $limit, $element, $parameters);
    }
    // The previous page is not the first page.
    else {
      $output = theme('pager_link', "More", $page_new, $element, $parameters);
    }
  }

  return $output;
}

function gsapp_pager_next($text, $limit, $element = 0, $interval = 1, $parameters = array()) {
  global $pager_page_array, $pager_total;
  $output = '';

  // If we are anywhere but the last page
  if ($pager_page_array[$element] < ($pager_total[$element] - 1)) {
    $page_new = pager_load_array($pager_page_array[$element] + $interval, $element, $pager_page_array);
    // If the next page is the last page, mark the link as such.
    if ($page_new[$element] == ($pager_total[$element] - 1)) {
      $output = theme('pager_last', 'More &raquo;', $limit, $element, $parameters);
    }
    // The next page is not the last page.
    else {
      $output = theme('pager_link', 'More &raquo;', $page_new, $element, $parameters);
    }
  }

  return $output;
}
*/


/**
 * *********
 *
 * @param array $vids array of vids
 * @param int $steps how many different levels of tags there are
 * @param int $limit limit how many tags to show
 * @param bool $random randomize display
 * @return html
 */
function _get_tags_viewed($vids = array(),$steps = 5, $limit=100,$random=TRUE){
	$query ="
	 SELECT  IFNULL(sum(node_counter.totalcount),1) AS count, term_data.name AS name, term_data.vid AS vid, term_data.tid AS tid
		FROM node node
		LEFT JOIN term_node term_node ON node.vid = term_node.vid
		LEFT JOIN term_data term_data ON term_node.tid = term_data.tid
		LEFT JOIN node_counter node_counter ON node.nid = node_counter.nid
		WHERE term_data.vid
		IN (
		'".implode(',',$vids)."'
		)
		GROUP BY tid
		".($random?' ORDER BY RAND( ) ':' ORDER BY count DESC ')."
		LIMIT 0 , $limit";

	$result = db_query($query);

	$tags = tagadelic_build_weighted_tags($result, $steps);
 	$output = theme('tagadelic_weighted', $tags);
 	if (!$output) {
    	return drupal_not_found();
  	}

  	$allLink = l('See all tags', 'tags-viewed').' ';
  	$output = "<div class=\"wrapper-tags-viewed\">$output$allLink</div>";
	return $output;
}

function _get_tags_used($vids = array(),$steps = 5, $limit=100,$random=TRUE){
	$query ="
	SELECT COUNT(*) AS count,
	d.tid,
	d.name,
	d.vid
	FROM term_data d INNER JOIN term_node n ON d.tid = n.tid
	WHERE d.vid
	IN (
	'".implode(',',$vids)."'
	)
	GROUP BY d.tid, d.name, d.vid
	".($random?' ORDER BY RAND( ) ':' ORDER BY count DESC ')."
	LIMIT 0 , $limit";
	$result = db_query($query);

	$tags = tagadelic_build_weighted_tags($result, $steps);
 	$output = theme('tagadelic_weighted', $tags);
 	if (!$output) {
    	return drupal_not_found();
  	}
	$allLink = l('See all tags', 'tags-used').' ';
  	$output = "<div class=\"wrapper-tags-viewed\">$output$allLink</div>";
	return $output;
}

function gsapp_comment_post_forbidden($node) {
  global $user,$base_url;
  static $authenticated_post_comments;

  return;
  if (!$user->uid) {
    if (!isset($authenticated_post_comments)) {
      // We only output any link if we are certain, that users get permission
      // to post comments by logging in. We also locally cache this information.
      $authenticated_post_comments = array_key_exists(DRUPAL_AUTHENTICATED_RID, user_roles(TRUE, 'post comments') + user_roles(TRUE, 'post comments without approval'));
    }

    if ($authenticated_post_comments) {
      // We cannot use drupal_get_destination() because these links
      // sometimes appear on /node and taxonomy listing pages.
      if (variable_get('comment_form_location_'. $node->type, COMMENT_FORM_SEPARATE_PAGE) == COMMENT_FORM_SEPARATE_PAGE) {
        $destination = 'destination='. drupal_urlencode($base_url."/comment/reply/$node->nid#comment-form");
      }
      else {
        $destination = 'destination='. drupal_urlencode($base_url."/node/$node->nid#comment-form");
      }

      if (variable_get('user_register', 1)) {
        // Users can register themselves.
        return t('<a href="@login">Login</a> to post a discussion', array('@login' => url('user/wind', array('query' => $destination))));
      }
      else {
        // Only admins can add new users, no public registration.
        return t('<a href="@login">Login</a> to post a discussion', array('@login' => url('user/wind', array('query' => $destination))));
      }
    }
  }
}

/**
 * Process variables for search-result.tpl.php.
 *
 * The $variables array contains the following arguments:
 * - $result
 * - $type
 *
 * @see search-result.tpl.php
 */
function gsapp_preprocess_search_result(&$variables) {
  $result = $variables['result'];
  $variables['url'] = check_url($result['link']);
  $variables['title'] = check_plain($result['title']);
  $variables['node'] = node_load($result['node']->nid);

  $info = array();
  if (!empty($result['type'])) {
    $info['type'] = check_plain($result['type']);
  }
  if (!empty($result['user'])) {
    $info['user'] = $result['user'];
  }
  if (!empty($result['date'])) {
    $info['date'] = format_date($result['date'], 'small');
  }
  if (isset($result['extra']) && is_array($result['extra'])) {
    $info = array_merge($info, $result['extra']);
  }
  // Check for existence. User search does not include snippets.
  $variables['snippet'] = isset($result['snippet']) ? $result['snippet'] : '';
  // Provide separated and grouped meta information..
  $variables['info_split'] = $info;
  $variables['info'] = implode(' - ', $info);
  // Provide alternate search result template.
  $variables['template_files'][] = 'search-result-'. $variables['type'];
}

/**
 * *********
 *
 * @param array $vids array of vids
 * @param int $steps how many different levels of tags there are
 * @param int $limit limit how many tags to show
 * @param bool $random randomize display
 * @return html
 */

function _get_distinct_event_speakers(){
	$view = views_get_view("events");
	$view->execute_display('block_2');
	$speakers = array();
	$speaker_names = array();
	foreach ($view->result as $key => $result) {
	    $node_event = node_load($result->nid);

        if ($node_event->field_user_speaker[0]['uid'] ) {
            foreach ($node_event->field_user_speaker as $key => $speaker) {
                $speakers[$speaker['uid']] = user_load($speaker['uid']);
                if($speakers[$speaker['uid']]->profile_lastname && $speakers[$speaker['uid']]->profile_firstname){
                	$speaker_names[$speaker['uid']] = $speakers[$speaker['uid']]->profile_lastname.", ".$speakers[$speaker['uid']]->profile_firstname;
                }
                else{
                	//profile fields are empty, it LDAP did not sync properly use the username
                	$speaker_names[$speaker['uid']] = $speakers[$speaker['uid']]->name;
                }

            }
        }
	}

	//sort speaker names array, make links, return a string of output
	asort($speaker_names);

	$speaker_links = array();
	$current_path = arg(0). '/';
	$output = '<div class="item-list"><ul><li><a href="/'.arg(0).'">all</a></li>';
	foreach($speaker_names as $key => $value) {
	    $output .= '<li>'.l($value, $current_path.$key).'</li>';
	}
	$output .= "</ul></div>";
	return $output;
}

/**
 * Insert this into a block to generate a view that has a filter applied to it.
 *
 * @return string the formatted view
 */
function _generate_views_block($view_name,$display = 'block'){
	$default_view_displays = array('featured_event','exhibitions');
	$view = views_get_view($view_name);
	$output = $view->execute_display($display, array($_SESSION['main_filter']));

	if(count($view->result)>0)
	{
		if(is_array($output))
		return $output['content'];
		else
		return $output;
	}
	else
	{//no results returned, display the default
		if(in_array($view->name,$default_view_displays))
		{
			$view = views_get_view($view_name);
			$output = $view->execute_display($display);
			if(is_array($output))
			return $output['content'];
			else
			return $output;
		}
		return NULL;
	}
}


/**
 * Return a themed form element.
 *
 * @param element
 *   An associative array containing the properties of the element.
 *   Properties used: title, description, id, required
 * @param $value
 *   The form element's data.
 * @return
 *   A string representing the form element.
 *
 * @ingroup themeable
 */
function gsapp_form_element($element, $value) {
  // This is also used in the installer, pre-database setup.
  $t = get_t();


  $output = '<div class="form-item"';
  if (!empty($element['#id'])) {
    $output .= ' id="'. $element['#id'] .'-wrapper"';
  }
  $output .= ">\n";
  $required = !empty($element['#required']) ? '<span class="form-required" title="'. $t('This field is required.') .'">*</span>' : '';
  if(is_array($element['#options']))
  {
  	$option_keys = array_keys($element['#options']);
  }

  if (!empty($element['#title'])) {
    $title = $element['#title'];
    if (!empty($element['#id'])) {
      $output .= ' <label for="'. $element['#id'] .'">'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
    elseif (!empty($element['inline']['keys']['#id'])) {
      $output .= ' <label for="'. $element['inline']['keys']['#id'] .'">'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
    elseif (!empty($element[$option_keys[0]]['#id'])) {
      $output .= ' <label for="'. $element[$option_keys[0]]['#id'] .'">'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
    else {
      $output .= ' <label for="test">'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
  }

  $output .= " $value\n";

  if (!empty($element['#description'])) {
    $output .= ' <div class="description">'. $element['#description'] ."</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}


function _generate_overview_page_views_block($view_name,$display = 'block_1',$block_title = NULL,$use_node_title = FALSE){
	$section_vid = '2';
	$output = "";
	if(arg(0) == 'node' && is_numeric(arg(1)))
	{
		$node = node_load(arg(1));
		if(is_array($node->taxonomy) && $node->type == 'overview_page')
		{
			foreach($node->taxonomy as $tid => $term)
			{
				if($term->vid == $section_vid){
					$sections[] = $tid;
				}
			}
		}
	}

	if(is_array($sections))
	{
		$view = views_get_view($view_name);
		$view->is_cacheable = FALSE;
	    $output = $view->execute_display($display,array(implode('+',$sections)));

	}

	if(count($view->result) == 0){
		$view = views_get_view($view_name);
		$view->is_cacheable = FALSE;
		$output = $view->execute_display($display);
	}


	$output['subject'] = $block_title ? $block_title : $output['subject'];
	$node->title = $use_node_title ? $node->title." ": '';
	if($output['subject']){
		$output['subject'] = "<h2 class='title'>".$node->title.$output['subject']."</h2>";
	}
	if($output['content'])
	{
		$block_content .= '<div class="view overview-page-side-block block">'.$output['subject'].$output['content']."</div>";
	}

	return $block_content;
}

/**
 * This is special renering of the comments taken from the comment.module enabling comments for directors on the overview_page
 *
 * @param unknown_type $node
 * @param unknown_type $cid
 * @return HTML output of comments
 */
function _gsapp_director_comment_render($node, $cid = 0) {
  global $user;
  if($node->comment)
  {//comments are handled by the default module renderer so return
  	return;
  }

  $node_comment_mode = node_comment_mode($node->nid);

  if($node_comment_mode)
  {
  	  if(in_array('Director',$user->roles))
	  {
	  	$node_comment_mode = 2;
	  }
	  else
	  {
	  	$node_comment_mode = 1;
	  }
  }

  $output = '';

  if (user_access('access comments')) {
    // Pre-process variables.
    $nid = $node->nid;
    if (empty($nid)) {
      $nid = 0;
    }

    $mode = _comment_get_display_setting('mode', $node);
    $order = _comment_get_display_setting('sort', $node);
    $comments_per_page = _comment_get_display_setting('comments_per_page', $node);

    if ($cid && is_numeric($cid)) {
      // Single comment view.
      $query = 'SELECT c.cid, c.pid, c.nid, c.subject, c.comment, c.format, c.timestamp, c.name, c.mail, c.homepage, u.uid, u.name AS registered_name, u.signature, u.picture, u.data, c.status FROM {comments} c INNER JOIN {users} u ON c.uid = u.uid WHERE c.cid = %d';
      $query_args = array($cid);
      if (!user_access('administer comments')) {
        $query .= ' AND c.status = %d';
        $query_args[] = COMMENT_PUBLISHED;
      }

      $query = db_rewrite_sql($query, 'c', 'cid');
      $result = db_query($query, $query_args);

      if ($comment = db_fetch_object($result)) {
        $comment->name = $comment->uid ? $comment->registered_name : $comment->name;
        $links = module_invoke_all('link', 'comment', $comment, 1);
        drupal_alter('link', $links, $node);

        $output .= theme('comment_view', $comment, $node, $links);
      }
    }
    else {
      // Multiple comment view
      $query_count = 'SELECT COUNT(*) FROM {comments} c WHERE c.nid = %d';
      $query = 'SELECT c.cid as cid, c.pid, c.nid, c.subject, c.comment, c.format, c.timestamp, c.name, c.mail, c.homepage, u.uid, u.name AS registered_name, u.signature, u.picture, u.data, c.thread, c.status FROM {comments} c INNER JOIN {users} u ON c.uid = u.uid WHERE c.nid = %d';

      $query_args = array($nid);
      if (!user_access('administer comments')) {
        $query .= ' AND c.status = %d';
        $query_count .= ' AND c.status = %d';
        $query_args[] = COMMENT_PUBLISHED;
      }

      if ($order == COMMENT_ORDER_NEWEST_FIRST) {
        if ($mode == COMMENT_MODE_FLAT_COLLAPSED || $mode == COMMENT_MODE_FLAT_EXPANDED) {
          $query .= ' ORDER BY c.cid DESC';
        }
        else {
          $query .= ' ORDER BY c.thread DESC';
        }
      }
      else if ($order == COMMENT_ORDER_OLDEST_FIRST) {
        if ($mode == COMMENT_MODE_FLAT_COLLAPSED || $mode == COMMENT_MODE_FLAT_EXPANDED) {
          $query .= ' ORDER BY c.cid';
        }
        else {
          // See comment above. Analysis reveals that this doesn't cost too
          // much. It scales much much better than having the whole comment
          // structure.
          $query .= ' ORDER BY SUBSTRING(c.thread, 1, (LENGTH(c.thread) - 1))';
        }
      }
      $query = db_rewrite_sql($query, 'c', 'cid');
      $query_count = db_rewrite_sql($query_count, 'c', 'cid');

      // Start a form, for use with comment control.
      $result = pager_query($query, $comments_per_page, 0, $query_count, $query_args);

      $divs = 0;
      $num_rows = FALSE;
      $comments = '';
      drupal_add_css(drupal_get_path('module', 'comment') .'/comment.css');

      while ($comment = db_fetch_object($result)) {
        $comment = drupal_unpack($comment);
        $comment->name = $comment->uid ? $comment->registered_name : $comment->name;
        $comment->depth = count(explode('.', $comment->thread)) - 1;

        if ($mode == COMMENT_MODE_THREADED_COLLAPSED || $mode == COMMENT_MODE_THREADED_EXPANDED) {
          if ($comment->depth > $divs) {
            $divs++;
            $comments .= '<div class="indented">';
          }
          else {
            while ($comment->depth < $divs) {
              $divs--;
              $comments .= '</div>';
            }
          }
        }

        if ($mode == COMMENT_MODE_FLAT_COLLAPSED) {
          $comments .= theme_comment_flat_collapsed($comment, $node);
        }

        else if ($mode == COMMENT_MODE_FLAT_EXPANDED) {
          $comments .= theme('comment_flat_expanded', $comment, $node);
        }
        else if ($mode == COMMENT_MODE_THREADED_COLLAPSED) {
          $comments .= theme('comment_thread_collapsed', $comment, $node);
        }
        else if ($mode == COMMENT_MODE_THREADED_EXPANDED) {
          $comments .= theme('comment_thread_expanded', $comment, $node);
        }

        $num_rows = TRUE;
      }

      while ($divs-- > 0) {
        $comments .= '</div>';
      }

      $comment_controls = variable_get('comment_controls_'. $node->type, COMMENT_CONTROLS_HIDDEN);
      if ($num_rows && ($comment_controls == COMMENT_CONTROLS_ABOVE || $comment_controls == COMMENT_CONTROLS_ABOVE_BELOW)) {
        $output .= drupal_get_form('comment_controls', $mode, $order, $comments_per_page);
      }

      $output .= $comments;
      $output .= theme('pager', NULL, $comments_per_page, 0);

      if ($num_rows && ($comment_controls == COMMENT_CONTROLS_BELOW || $comment_controls == COMMENT_CONTROLS_ABOVE_BELOW)) {
        $output .= drupal_get_form('comment_controls', $mode, $order, $comments_per_page);
      }
    }

    // If enabled, show new comment form if it's not already being displayed.
    $reply = arg(0) == 'comment' && arg(1) == 'reply';

    if (user_access('post comments') && $node_comment_mode == COMMENT_NODE_READ_WRITE && (variable_get('comment_form_location_'. $node->type, COMMENT_FORM_SEPARATE_PAGE) == COMMENT_FORM_BELOW) && !$reply) {
      $output .= comment_form_box(array('nid' => $nid), t('Director\'s Blog'));
    }

    $output = theme('comment_wrapper', $output, $node);
  }

  return $output;
}

function _print_manage_featured($view){
	if(!$view)
	{
		return;
	}
	$output = '';
	if($view->display[$display]->display_options['relationships']['nodequeue_rel']['qids']){
		$qids = $view->display[$display]->display_options['relationships']['nodequeue_rel']['qids'];
	}
	else{
		$qids = $view->display['default']->display_options['relationships']['nodequeue_rel']['qids'];
	}
	if(is_array($qids))
	{
		foreach ($qids as $key =>$qid)
		{
			if(!$qid)
			{//get rid of the empty values

				unset($qids[$key]) ;
			}
			else{
				$qid_keys[] = $key;
			}
		}
	}

	if($view->name == 'featured_event')
	{
		$subqueue = 6;
	}
	elseif($view->name == 'exhibitions')
	{
		$subqueue = 8;
	}
	if(user_access('manipulate queues') && count($qids) > 0)
	$output = '<div class="views-field-edit-node manage-featured-link">'.l('Manage Featured','admin/content/nodequeue/'.$qids[$qid_keys[0]].'/view/'.$subqueue,array('query'=>'destination='.$_GET['q'])).'</div>';


	return $output;
}

function gsapp_userreference_select($element) {
	if(arg(0) == 'node' && arg(2) == 'edit')
	{
		$current_node = node_load(arg(1));
		foreach($current_node->field_user_speaker as $assigned_user){
			$users[] = $assigned_user['uid'];
		}
	}

	$output = '<div class="form-item" id="edit-field-user-speaker-uid-uid-wrapper">
 <label for="edit-field-user-speaker-uid-uid">Speaker(s): </label>
 <select name="field_user_speaker[uid][uid][]" multiple="multiple"  class="form-select" id="edit-field-user-speaker-uid-uid" >
';

	foreach($element['uid']['uid']['#options'] as $uid => $user)
	{
		$output .= '<option value = "'.$uid.'" '.(in_array($uid,$users) ? 'selected':'').'>'.str_replace('Name:','',str_replace("\n",'',$user)).'</option>';
	}

	$output .='
</option></select>
</div>';

  	return $output;
}

function gsapp_username($object) {

  if($object->profile_name)
  {
  	$object->name = $object->profile_name;
  }

  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) .'...';
    }
    else {
      $name = $object->name;
    }

    if (user_access('access user profiles')) {
      $output = l($name, 'user/'. $object->uid, array('attributes' => array('title' => t('View user profile.'))));
    }
    else {
      $output = check_plain($name);
    }
  }
  else if ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the true author of the content.
    if (!empty($object->homepage)) {
      $output = l($object->name, $object->homepage, array('attributes' => array('rel' => 'nofollow')));
    }
    else {
      $output = check_plain($object->name);
    }

    $output .= ' ('. t('not verified') .')';
  }
  else {
    $output = variable_get('anonymous', t('Anonymous'));
  }

  return $output;
}

function gsapp_menu_local_tasks() {
  global $user;
  $output = '';

  if ($primary = menu_primary_local_tasks()) {
  	if(!user_access('change own username'))
	{
		$primary = ereg_replace("user/[0-9]+/edit","user/".$user->uid."/edit/Additional%20Information",$primary);
	}
	$primary = preg_replace("/<li(.*)guestbook(.*)?>/",'',$primary);
    $output .= "<ul class=\"tabs primary clear-block\">\n". $primary ."</ul>\n";

  }
  if ($secondary = menu_secondary_local_tasks()) {
  	if(!user_access('change own username'))
	{
		$secondary = preg_replace("/<li(.*)Account(.*)?>/",'',$secondary);
	}
	if(!user_access('administer my_site_lite'))
	{
		$secondary = preg_replace("/<li(.*)My Site(.*)?>/",'',$secondary);
	}
	if(!user_access('administer my_site_lite'))
	{
		$secondary = preg_replace("/<li(.*)Personal Information(.*)?>/",'',$secondary);
	}

	$secondary = preg_replace("/<li(.*)guestbook(.*)?>/",'',$secondary);

    $output .= "<ul class=\"tabs secondary clear-block\">\n". $secondary ."</ul>\n";
  }

  return $output;
}

function gsapp_preprocess_user_profile(&$variables) {
  $variables['profile'] = array();
  // Sort sections by weight
  uasort($variables['account']->content, 'element_sort');
  // Provide keyed variables so themers can print each section independantly.
  foreach (element_children($variables['account']->content) as $key) {
    $variables['profile'][$key] = drupal_render($variables['account']->content[$key]);
  }
  // Collect all profiles to make it easier to print all items at once.
  $variables['user_profile'] = implode($variables['profile']);
}

function _generateAtoZ($view,$args,&$nodes,&$output,$type='node')
{
  $index = array('A' => NULL, 'B' => NULL, 'C' => NULL, 'D' => NULL, 'E' => NULL, 'F' => NULL, 'G' => NULL, 'H' => NULL, 'I' => NULL, 'J' => NULL, 'K' => NULL, 'L' => NULL, 'M' => NULL, 'N' => NULL, 'O' => NULL, 'P' => NULL, 'Q' => NULL, 'R' => NULL, 'S' => NULL, 'T' => NULL, 'U' => NULL, 'V' => NULL, 'W' => NULL, 'X' => NULL, 'Y' => NULL, 'Z' => NULL);

		foreach($nodes as $node)
		{
			if($type == 'user'){
				$node = user_load($node->uid);
			}
			elseif($type = 'node'){
				$node = node_load($node->nid);
			}



			$key = strtoupper(substr($node->profile_lastname,0,1));
			if(array_key_exists($key,$index))
			{
				$index[$key][] = $node;
			}
			/*else
			{
				if($node->profile_lastname)
				$index['*'][] = $node;
			}*/
		}

		/*if(!isset($index['Other']))
		{ //set the other index even if the node does not exist
			$index['Other'] = NULL;
		}*/
		$alpha_index .= '<div id="alpha-index">';
		foreach ($index as $alpha => $service)
		{

			if(!empty($service))
			{
				if(arg(1) == '')
				{
					drupal_goto(arg(0).'/'. strtoupper($alpha));
					exit;
				}
				/* Output alpha index */
				$alpha_index .= "<a href='/".arg(0).'/'. strtoupper($alpha) ."'>$alpha</a>";

			}
			else
				$alpha_index .= "<span class='no-listing'>$alpha</span>";
		}

		$alpha_index .= "</div>";
		$output .= "<div id='atoz-container'>";
		$output .= $alpha_index;
		$output .= "</div>";
}

function gsapp_imagecache($namespace, $path, $alt = '', $title = '', $attributes = NULL) {

	if ($image = image_get_info(imagecache_create_path($namespace, $path))) {
    $attributes['width'] = $image['width'];
    $attributes['height'] = $image['height'];
  }
  // check is_null so people can intentionally pass an empty array of attributes to override
  // the defaults completely... if
  if (is_null($attributes)) {
    $attributes['class'] = 'imagecache imagecache-'. $namespace;
  }
  $attributes = drupal_attributes($attributes);
  $imagecache_url = imagecache_create_url($namespace, $path);
  $caption = '';
  if($namespace=='image_gallary'){
  	$caption = '<div class="caption">'. check_plain($alt).'</div>';
  }

  return '<img src="'. $imagecache_url .'" alt="'. check_plain($alt) .'" title="'. check_plain($title) .'" '. $attributes .' />'.$caption;
}

function _get_semester_taxonomy(){
	/* checks to see if the taxonomy is a semester filtered taxonomy. If it is return the tid. Otherwise return false */

	$work_courses_children = taxonomy_get_children('66','2');
	$labs_courses_children = taxonomy_get_children('67','2');

	$work_courses_children['66'] = taxonomy_get_term('66');
	$labs_courses_children['67'] = taxonomy_get_term('67');

	foreach($work_courses_children as $key =>$term){
		$filter_taxonomy_terms[$key] = $term;
	}
	foreach($labs_courses_children as $key =>$term){
		$filter_taxonomy_terms[$key] = $term;
	}

	if(taxonomy_get_term(arg(2))->tid){
		if(array_key_exists(arg(2),$filter_taxonomy_terms)){
			return arg(2);
		}
	}
	elseif(arg(0) == 'node'){
		$node = node_load(arg(1));
		$tids = array_intersect(array_keys($node->taxonomy),array_keys($filter_taxonomy_terms));
		if($tids){$tid_keys = array_keys($tids);
			return $tids[$tid_keys[0]];
		}
	}

	if(arg(0) == 'course-archive'){
		return $_GET['term'];
	}

	return false;
}

function _get_current_semester(){
	// only apply to children taxonomy of courses. Courses taxonomy id is 66 (Courses) and vocabulary is 2 (Section).

	if(_get_semester_taxonomy()){
		$view = views_get_view('nodequeue_9');
		$view->execute_display('default');
		return $view->result[0]->nid;
	}
	else{
		return 'all';
	}
}

function _get_past_semesters(){
	$view = views_get_view('semesters');
	$view->execute_display('default');

	$current_semester = node_load(_get_current_semester());

	if($current_semester == 'all'){
		//only get archived semesters if the current semester is set
		return false;
	}
	// past semesters are only the ones where the year is less that the current semester year
	
	foreach($view->result as $semester){
		$semester = node_load($semester->nid);
		if(strtotime($semester->field_term[0]['value'].'/01/'.date('Y',strtotime($semester->field_year[0]['value']))) < strtotime($current_semester->field_term[0]['value'].'/01/'.date('Y',strtotime($current_semester->field_year[0]['value'])))){
			$semesters[] = $semester->nid;
		}
	}

	return $semesters;
}

function gsapp_calendar_title($granularity, $view) {

  	switch ($granularity) {
    case 'year':
      return $view->year;
    case 'month':
      return date_format_date($view->min_date, 'custom', 'F')." ".$view->year;
    case 'day':
      return date_format_date($view->min_date, 'custom', 'l, F j Y');
    case 'week':
    	return t('Week of @date', array('@date' => date_format_date($view->min_date, 'custom', 'F j')));
  }
}

/**
 * Theme the calendar title
 */
function gsapp_date_nav_title($granularity, $view, $link = FALSE, $format = NULL) {
  switch ($granularity) {
    case 'year':
      $title = $view->year;
      $url = $view->url .'/'. $view->year;
      break;
    case 'month':
      $title = date_format_date($view->min_date, 'custom', !empty($format) ? $format : 'F')." ".$view->year;

      $url = $view->url .'/'. $view->year .'-'. date_pad($view->month);
      break;
    case 'day':
      $title = date_format_date($view->min_date, 'custom', !empty($format) ? $format : 'l, F j Y');
      $url = $view->url .'/'. $view->year .'-'. date_pad($view->month) .'-'. date_pad($view->day);
      break;
    case 'week':
    	$title = t('Week of @date', array('@date' => date_format_date($view->min_date, 'custom', !empty($format) ? $format : 'F j')));
    	$url = $view->url .'/'. $view->year .'-W'. date_pad($view->week);
    	break;
  }
  // TODO Update this.
  //if (!empty($view->mini) || $link) {
  //	// Month navigation titles are used as links in the mini view.
  //	return l($title, $url, array(), calendar_url_append($view));
  //}
  //else {
    return $title;
  //}
}


/**
 * Implements theme_menu_item_link()
 */
/*
function gsapp_menu_item_link($link) {
	if($link['mlid'] == '1789')
	{
		die(var_dump($link));
	}
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }

  // If an item is a LOCAL TASK, render it as a tab
  if ($link['type'] & MENU_IS_LOCAL_TASK) {
    $link['title'] = '<span class="tab">' . check_plain($link['title']) . '</span>';
    $link['localized_options']['html'] = TRUE;
  }

  return l($link['title'], $link['href'], $link['localized_options']);
}
*/


function menu_link_load_by_path($path) {
  if ($item = db_fetch_array(db_query("SELECT link_title title FROM menu_links WHERE link_path = '%s'", $path))) {
  	 _menu_link_translate($item);
    return $item;
  }
  return FALSE;
}

function gsapp_guestbook_form_entry_form(&$form_state) {

  $output  = '';
  $access  = $form_state['access']['#value'];
  $display = $form_state['display']['#value'];
  $uid     = $form_state['uid']['#value'];


  switch ($access) {
    case 'allowed':
      if ($display == 'link') {
        // Output only a link to a page with the form.
        //$output .= '<p>&raquo; '. l(t('Add guestbook entry'), guestbook_path($uid) .'/sign') .'</p>';
      }
      else {
        $output .= $display == 'page' ? '' : '<div class="box"><h2 class="title">'. t('Contribute') .'</h2></div>';
        $output .= drupal_render($form_state);
      }
      break;

    case 'own guestbook':
      $output .= ' ';
      break;

    case 'not logged in':
      $output .= ' ';
      break;

    case 'not allowed':
      $output .= ' ';
      break;
  }
  return $output;
}

function gsapp_guestbook($uid, $entries, $comment_entry, $limit = 20) {
  global $user;
  $form_location = variable_get('guestbook_form_location', 'above');
  $pager_position = variable_get('guestbook_pager_position', GUESTBOOK_PAGER_BELOW);

  // intro text
  $intro = _guestbook_info($uid, 'intro');
  $output = $intro ? check_markup($intro) : '';
  //$output .= _guestbook_user_profile_link($uid);


  // form on separate page
  $output .= ($form_location == 'separate page' ? guestbook_form_entry($uid, 'link') : '');
  // form and pager above entries
  $output .= ($form_location == 'above' ? guestbook_form_entry($uid) : '');
  $output .= ($pager_position & GUESTBOOK_PAGER_ABOVE ? theme('pager', NULL, $limit, 0) : '');

  $i = 0;
  foreach ($entries as $entry) {
    $zebra = ($i % 2) ? 'odd' : 'even';
    $output .= theme('guestbook_entry', $uid, $entry, $comment_entry, $zebra);
    $i++;
  }

  // form and pager below entries
  $output .= $pager_position & GUESTBOOK_PAGER_BELOW ? theme('pager', NULL, $limit, 0) : '';
  $output .= $form_location == 'below' ? guestbook_form_entry($uid) : '';
  if(ereg('guestbook-entry',$output)){
  	$output = '<h2 id="comments-title">Discussion</h2><div id="comments">'. $output ."</div>\n";
  }

  return $output;
}


function gsapp_guestbook_entry($uid, $entry, $comment_entry = NULL, $zebra, $confirm_delete = false) {
  global $user;
  $output = '';
  $display = (array) variable_get('guestbook_display', array('date', 'email', 'website', 'comments'));

  $output .= "\n<div class=\"comment entry guestbook-entry $zebra\">\n";
  if ($comment_entry == $entry['id']) {
    $output .= '<a name="comment-entry"></a>';
  }



  // date, email, website
  $output .= '<div class="submitted">';
  if (in_array('date', $display)) {
    $output .= format_date($entry['created'], 'medium');
  }
  if (in_array('email', $display) && !empty($entry['anonemail'])) {
    $output .= '&nbsp;|&nbsp;<a href="mailto:'. check_url($entry['anonemail']) .'">'. t('E-mail') .'</a>';
  }
  if (in_array('website', $display) && !empty($entry['anonwebsite'])) {
    // Auto-prepend HTTP protocol if website contains no protocol.
    if (strpos($entry['anonwebsite'], '://') === FALSE) {
      $entry['anonwebsite'] = 'http://'. $entry['anonwebsite'];
    }
    $output .= '&nbsp;|&nbsp;<a href="'. check_url($entry['anonwebsite']) .'">'. t('Website') .'</a>&nbsp;';
  }
  $output .= '</div>';

  // message
  $output .= '<div class="content guestbook-message">'. check_markup($entry['message'], variable_get('guestbook_input_format', 1), FALSE) .'</div>';

  if ($entry['picture']) {
    $output .= '<div style="clear:both;"></div>';
  }

  // comment
  $output .= theme('guestbook_entry_comment', $uid, $entry, $comment_entry);

  // author
  if ($entry['author'] == 0) {
    $author = check_plain($entry['anonname']);
  }
  else {
    $author = theme('guestbook_user_picture', $entry['author']);
  }

  $output .= '<div class="entryshare">Posted by: '. $author .'</div>';

  // links
  if (_guestbook_access('administer', $uid) && !$confirm_delete) {
    if ($comment_entry != $entry['id']) {
      $pager = !empty($_GET['page']) ? 'page='. $_GET['page'] : NULL;
      $output .= '<div class="links">';
      $output .= l(t('Delete'), guestbook_path($uid) .'/guestbook/delete/'. $entry['id'], array('query' => $pager)) .'&nbsp;&nbsp;';
      //$output .= l($entry['comment'] == '' ? t('Add') : t('Edit'), guestbook_path($uid) .'/comment/'. $entry['id'], array('query' => $pager, 'fragment' => 'comment-entry'));
      $output .= '</div>';
    }
  }

  $output .= "\n</div>";
  return $output;
}

function restrict_access_to_jobs_section($vars){
	if(ereg('cron.php',$_SERVER['PHP_SELF'])){
		//dont run on cron somehow it brings up the wind screen.
		return;
	}
	global $user;
//make the jobs section user authenticated
	if($user->uid == 0){
		if(arg(0) == 'taxonomy' && arg(1) == 'term' && arg(2) == '16'){
			//jobs section
				drupal_goto('user/wind','&wind_destination_path='.$_GET['q']);
		}
		else{
			if(is_array($vars['node']->taxonomy)){
			 	if(arg(0) == 'node' && array_key_exists(16,$vars['node']->taxonomy)){
					//jnode that is in the jobs section
					drupal_goto('user/wind','&wind_destination_path='.$_GET['q']);
				}
			}
		}
	}
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
  // ProfilePlus module: remove the Users tab from the search page
  if (module_exists('profileplus')) {
    _removetab('Users', $vars);
  }
  _removetab('Help', $vars);
}


/**
 * Removes a tab from the $tabs array.
 * ProfilePlus uses this function to remove the 'Users' tab
 * from the search page.
 */
function _removetab($label, &$vars) {
  $tabs = explode("\n", $vars['tabs']);
  $vars['tabs'] = '';

  foreach($tabs as $tab) {
    if(strpos($tab, '>' . $label . '<') === FALSE) {
      $vars['tabs'] .= $tab . "\n";
    }
  }
}


function phptemplate_menu_overview_form($form) {
  drupal_add_tabledrag('menu-overview', 'match', 'parent', 'menu-plid', 'menu-plid', 'menu-mlid', TRUE, MENU_MAX_DEPTH - 1);
  drupal_add_tabledrag('menu-overview', 'order', 'sibling', 'menu-weight');

  $header = array(
    t('Menu item'),
    array('data' => t('Enabled'), 'class' => 'checkbox'),
//    array('data' => t('Expanded'), 'class' => 'checkbox'),
    t('Weight'),
    array('data' => t('Operations'), 'colspan' => '2'),
  );

  $rows = array();
  foreach (element_children($form) as $mlid) {
    unset($element['expanded']);
    if (isset($form[$mlid]['hidden'])) {
    
      $element = &$form[$mlid];
      // Build a list of operations.
      $operations = array();
      foreach (element_children($element['operations']) as $op) {
        $operations[] = drupal_render($element['operations'][$op]);
      }
      while (count($operations) < 2) {
        $operations[] = '';
      }

      // Add special classes to be used for tabledrag.js.
      $element['plid']['#attributes']['class'] = 'menu-plid';
      $element['mlid']['#attributes']['class'] = 'menu-mlid';
      $element['weight']['#attributes']['class'] = 'menu-weight';

      // Change the parent field to a hidden. This allows any value but hides the field.
      $element['plid']['#type'] = 'hidden';

      $row = array();
      $row[] = theme('indentation', $element['#item']['depth'] - 1) . drupal_render($element['title']);
      $row[] = array('data' => drupal_render($element['hidden']), 'class' => 'checkbox');
//      $row[] = array('data' => drupal_render($element['expanded']), 'class' => 'checkbox');
      $row[] = drupal_render($element['weight']) . drupal_render($element['plid']) . drupal_render($element['mlid']);
      $row = array_merge($row, $operations);

      $row = array_merge(array('data' => $row), $element['#attributes']);
      $row['class'] = !empty($row['class']) ? $row['class'] .' draggable' : 'draggable';
      $rows[] = $row;
    }
  }
  $output = '';
  if ($rows) {
    $output .= theme('table', $header, $rows, array('id' => 'menu-overview'));
  }
  $output .= drupal_render($form);
  return $output;
}
