<?php
/*
Plugin Name: Recent Posts
Plugin URI: http://rmarsh.com/plugins/recent-posts/
Description: Displays a <a href="options-general.php?page=recent-posts.php">highly configurable</a> list of the most recent posts. <a href="http://rmarsh.com/plugins/post-options/">Instructions and help online</a>. Requires the latest version of the <a href="http://wordpress.org/extend/plugins/post-plugin-library/">Post-Plugin Library</a> to be installed.
Version: 2.6.2.0
Author: Rob Marsh, SJ
Author URI: http://rmarsh.com/
*/

/*
Copyright 2008  Rob Marsh, SJ  (http://rmarsh.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details: http://www.gnu.org/licenses/gpl.txt
*/

$recent_posts_version = '2.6.2.0';

/*
	Template Tag: Displays the most recent posts.
		e.g.: <?php recent_posts(); ?>
	Full help and instructions at http://rmarsh.com/plugins/post-options/
*/
function recent_posts($args = '') {
	echo RecentPosts::execute($args);
}

function recent_posts_mark_current(){
	global $post, $recent_posts_current_ID;
	$recent_posts_current_ID = $post->ID;
}

/*

	'innards'
	
*/

if (!defined('DSEP')) define('DSEP', DIRECTORY_SEPARATOR);
if (!defined('POST_PLUGIN_LIBRARY')) RecentPosts::install_post_plugin_library();

$recent_posts_current_ID = -1;

class RecentPosts {
	
	function execute($args='', $default_output_template='<li>{link}</li>'){
		if (!RecentPosts::check_post_plugin_library(__('Post-Plugin Library missing'))) return;
		global $wpdb, $wp_version, $recent_posts_current_ID;		
		$start_time = ppl_microtime();
		if (defined('POC_CACHE_4')) {
			$cache_key = 'recent-posts'.$args;
			$result = poc_cache_fetch($cache_key);
			if ($result !== false) return $result . sprintf("<!-- Recent Posts took %.3f ms (cached) -->", 1000 * (ppl_microtime() - $start_time));
		}
		// First we process any arguments to see if any defaults have been overridden
		$options = ppl_parse_args($args);
		// Next we retrieve the stored options and use them unless a value has been overridden via the arguments
		$options = ppl_set_options('recent-posts', $options, $default_output_template);
		if (0 < $options['limit']) {
			$match_tags = ($options['match_tags'] !== 'false' && $wp_version >= 2.3);
			$exclude_cats = ($options['excluded_cats'] !== '');
			$include_cats = ($options['included_cats'] !== '');
			$exclude_authors = ($options['excluded_authors'] !== '');
			$include_authors = ($options['included_authors'] !== '');
			$exclude_posts = (trim($options['excluded_posts']) !== '');
			$include_posts = (trim($options['included_posts']) !== '');
			$match_category = ($options['match_cat'] === 'true');
			$match_author = ($options['match_author'] === 'true');
			$use_tag_str = ('' != $options['tag_str'] && $wp_version >= 2.3);
			$omit_current_post = ($options['omit_current_post'] !== 'false');
			$hide_pass = ($options['show_private'] === 'false');
			$check_age = ('none' !== $options['age']['direction']);
			$check_custom = (trim($options['custom']['key']) !== '');
			$limit = $options['skip'].', '.$options['limit'];

			//the workhorse...
			$sql = "SELECT * FROM $wpdb->posts ";
		    if ($check_custom) $sql .= "LEFT JOIN $wpdb->postmeta ON post_id = ID ";
			// build the 'WHERE' clause
			$where = array();
			if (!function_exists('get_post_type')) { 
				$where[] = where_hide_future();
			} else {
				$where[] = where_show_status($options['status'], $options['show_attachments']);
			}
			if ($match_category) $where[] = where_match_category();
			if ($match_tags) $where[] = where_match_tags($options['match_tags']);
			if ($match_author) $where[] = where_match_author();
			$where[] = where_show_pages($options['show_pages'], $options['show_attachments']);	
			if ($include_cats) $where[] = where_included_cats($options['included_cats']);
			if ($exclude_cats) $where[] = where_excluded_cats($options['excluded_cats']);
			if ($exclude_authors) $where[] = where_excluded_authors($options['excluded_authors']);
			if ($include_authors) $where[] = where_included_authors($options['included_authors']);
			if ($exclude_posts) $where[] = where_excluded_posts(trim($options['excluded_posts']));
			if ($include_posts) $where[] = where_included_posts(trim($options['included_posts']));
			if ($use_tag_str) $where[] = where_tag_str($options['tag_str']);
			if ($omit_current_post) $where[] = where_omit_post($recent_posts_current_ID);
			if ($hide_pass) $where[] = where_hide_pass();
			if ($check_age) $where[] = where_check_age($options['age']['direction'], $options['age']['length'], $options['age']['duration']);
			if ($check_custom) $where[] = where_check_custom($options['custom']['key'], $options['custom']['op'], $options['custom']['value']);
			$sql .= "WHERE ".implode(' AND ', $where);
			if ($check_custom) $sql .= " GROUP BY $wpdb->posts.ID";
			if ($options['date_modified'] === 'true') {
				$sql .= " ORDER BY post_modified DESC LIMIT $limit";
			} else {
				$sql .= " ORDER BY post_date DESC LIMIT $limit";
			}
			$results = $wpdb->get_results($sql);
		} else {
			$results = false;
		}	
	    if ($results) {
			$translations = ppl_prepare_template($options['output_template']);
			foreach ($results as $result) {
				$items[] = ppl_expand_template($result, $options['output_template'], $translations, 'recent-posts');
			}
			if ($options['sort']['by1'] !== '') $items = ppl_sort_items($options['sort'], $results, 'recent-posts', $options['group_template'], $items);		
			$output = implode(($options['divider']) ? $options['divider'] : "\n", $items);
			$output = $options['prefix'] . $output . $options['suffix'];
		} else {
			// if we reach here our query has produced no output ... so what next?
			if ($options['no_text'] !== 'false') {
				$output = ''; // we display nothing at all
			} else {
				// we display the blank message, with tags expanded if necessary
				$translations = ppl_prepare_template($options['none_text']);
				$output = $options['prefix'] . ppl_expand_template(array(), $options['none_text'], $translations, 'recent-posts') . $options['suffix'];
			}
		}
		if (defined('POC_CACHE_4')) poc_cache_store($cache_key, $output); 
		return ($output) ? $output . sprintf("<!-- Recent Posts took %.3f ms -->", 1000 * (ppl_microtime() - $start_time)) : '';
	}

	// tries to install the post-plugin-library plugin
	function install_post_plugin_library() {
		$plugin_path = 'post-plugin-library/post-plugin-library.php';
		$current = get_option('active_plugins');
		if (!in_array($plugin_path, $current)) {
			$current[] = $plugin_path;
			update_option('active_plugins', $current);
			do_action('activate_'.$plugin_path);
		}
	}

	function check_post_plugin_library($msg) {
		$exists = function_exists('ppl_microtime');
		if (!$exists) echo $msg;
		return $exists;
	}
	
}

if ( is_admin() ) {
	require(dirname(__FILE__).'/recent-posts-admin.php');
}

function widget_rrm_recent_posts_init() {
	if (! function_exists("register_sidebar_widget")) {
		return;
	}
	function widget_rrm_recent_posts($args) {
		extract($args);
		$options = get_option('widget_rrm_recent_posts');
		$opt = get_option('recent-posts');
		$widget_condition = $opt['widget_condition'];
		// the condition specified in the widget control overrides  the placement setting screen
		if ($options['condition']) {
			$condition = $options['condition'];
		} else {
			if ($widget_condition) {
				$condition = $widget_condition;
			} else {
				$condition = 'true';
			}
		}
		$condition = (stristr($condition, "return")) ? $condition : "return ".$condition;
		$condition = rtrim($condition, '; ') . ' || is_admin();'; 
		if (eval($condition)) {
			$title = empty($options['title']) ? __('Recent Posts', 'recent_posts_plugin') : $options['title'];
			if ( !$number = (int) $options['number'] )
				$number = 10;
			else if ( $number < 1 )
				$number = 1;
			else if ( $number > 15 )
				$number = 15;
			$options = get_option('recent-posts');	
			$widget_parameters = $options['widget_parameters'];
			$output = RecentPosts::execute('limit='.$number.'&'.$widget_parameters);
			if ($output) {
				echo $before_widget;
				echo $before_title.$title.$after_title;
				echo $output;
				echo $after_widget;
			}
		}
	}
	function widget_rrm_recent_posts_control() {
		if ( $_POST['widget_rrm_recent_posts_submit'] ) {
			$options['title'] = strip_tags(stripslashes($_POST['widget_rrm_recent_posts_title']));
			$options['number'] = (int) $_POST["widget_rrm_recent_posts_number"];
			$options['condition'] = stripslashes(trim($_POST["widget_rrm_recent_posts_condition"], '; '));
			update_option("widget_rrm_recent_posts", $options);
		} else {
			$options = get_option('widget_rrm_recent_posts');
		}		
		$title = attribute_escape($options['title']);
		if ( !$number = (int) $options['number'] )
			$number = 5;
		$condition = attribute_escape($options['condition']);
		?>
		<p><label for="widget_rrm_recent_posts_title"> <?php _e('Title:', 'recent_posts_plugin'); ?> <input style="width: 200px;" id="widget_rrm_recent_posts_title" name="widget_rrm_recent_posts_title" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="widget_rrm_recent_posts_number"> <?php _e('Number of posts to show:', 'recent_posts_plugin'); ?> <input style="width: 25px; text-align: center;" id="widget_rrm_recent_posts_number" name="widget_rrm_recent_posts_number" type="text" value="<?php echo $number; ?>" /></label> <?php _e('(at most 15)', 'recent_posts_plugin'); ?> </p>
		<p><label for="widget_rrm_recent_posts_condition"> <?php _e('Show only if page: (e.g., <a href="http://codex.wordpress.org/Conditional_Tags" title="help">is_single()</a>)', 'recent_posts_plugin'); ?> <input style="width: 200px;" id="widget_rrm_recent_posts_condition" name="widget_rrm_recent_posts_condition" type="text" value="<?php echo $condition; ?>" /></label></p>
		<input type="hidden" id="widget_rrm_recent_posts_submit" name="widget_rrm_recent_posts_submit" value="1" />
		There are many more <a href="options-general.php?page=recent-posts.php">options</a> available.
		<?php
	}
	register_sidebar_widget(__('Recent Posts +', 'recent_posts_plugin'), 'widget_rrm_recent_posts');
	register_widget_control(__('Recent Posts +', 'recent_posts_plugin'), 'widget_rrm_recent_posts_control', 300, 100);
}

add_action('plugins_loaded', 'widget_rrm_recent_posts_init');

function recent_posts_init () {
	load_plugin_textdomain('recent_posts_plugin');
	$options = get_option('recent-posts');
	if ($options['content_filter'] === 'true' && function_exists('ppl_register_content_filter')) ppl_register_content_filter('RecentPosts');
	if ($options['feed_on'] === 'true' && function_exists('ppl_register_post_filter')) ppl_register_post_filter('feed', 'recent-posts', 'RecentPosts');
	if ($options['append_condition']) {
		$condition = $options['append_condition'];
	} else {
		$condition = 'true';
	}
	$condition = (stristr($condition, "return")) ? $condition : "return ".$condition;
	$condition = rtrim($condition, '; ') . ';'; 
	if ($options['append_on'] === 'true' && function_exists('ppl_register_post_filter')) ppl_register_post_filter('append', 'recent-posts', 'RecentPosts', $condition);
}

add_action ('init', 'recent_posts_init', 1);

?>