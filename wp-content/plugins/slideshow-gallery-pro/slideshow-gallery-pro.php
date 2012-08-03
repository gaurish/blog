<?php
/*
Plugin Name: Slideshow Gallery Pro
Plugin URI: http://c-pr.es/projects/satellite
Author: Robot with Emotions
Author URI: http://c-pr.es
Description: This plugin will self-destruct within 5 minutes of installation. No, seriously, download Satellite instead
Version: 3.0
*/
define('DS', DIRECTORY_SEPARATOR);
define( 'SG2_VERSION', '2' );
$uploads = wp_upload_dir();
if ( ! defined( 'SG2_PLUGIN_BASENAME' ) )
	define( 'SG2_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'SG2_PLUGIN_NAME' ) )
	define( 'SG2_PLUGIN_NAME', trim( dirname( SG2_PLUGIN_BASENAME ), '/' ) );
if ( ! defined( 'SG2_PLUGIN_DIR' ) )
	define( 'SG2_PLUGIN_DIR', WP_PLUGIN_DIR . DS . SG2_PLUGIN_NAME );
if ( ! defined( 'SG2_PLUGIN_URL' ) )
	define( 'SG2_PLUGIN_URL', WP_PLUGIN_URL . DS . SG2_PLUGIN_NAME );
if ( ! defined( 'SG2_UPLOAD_URL' ) )
	define( 'SG2_UPLOAD_URL', $uploads['baseurl']. DS . SG2_PLUGIN_NAME );
if ( ! defined( 'SG2_UPLOAD_DIR' ) )
	define( 'SG2_UPLOAD_DIR', $uploads['basedir']. DS . SG2_PLUGIN_NAME );
if ( ! file_exists( SG2_PLUGIN_DIR . '/pro/' ) )
	define( 'SG2_PRO', false );
else
	define( 'SG2_PRO', true );
	
require_once SG2_PLUGIN_DIR . '/slideshow-gallery-plugin.php';
	
class SGPro extends SGProPlugin {
	function __construct() {
		$url = explode("&", $_SERVER['REQUEST_URI']);
		$this -> url = $url[0];
		
		$this -> register_plugin('slideshow-gallery-pro', __FILE__);
		
		//WordPress action hooks
		$this -> add_action('admin_menu');
		$this -> add_action('admin_head');
		$this -> add_action('admin_notices');
//		$this -> add_action('sg2_enqueue_styles');
		
		//WordPress filter hooks
		$this -> add_filter('mce_buttons');
		$this -> add_filter('mce_external_plugins');
		$this -> add_filter('plugin_action_links', 'add_sgpro_settings_link', 10, 2 );			
		
		add_shortcode('slideshow', array($this, 'embed'));
		add_shortcode('gpslideshow', array($this, 'embed'));
		
	}
	function admin_menu() {
		add_menu_page(__('Slideshow', SG2_PLUGIN_NAME), __('Slideshow', SG2_PLUGIN_NAME), $this -> get_option('manager'), "sgpro", array($this, 'admin_settings'), SG2_PLUGIN_URL . '/images/icon.png');
		$this -> menus['sgpro'] = add_submenu_page("sgpro", __('Configuration', SG2_PLUGIN_NAME), __('Configuration', SG2_PLUGIN_NAME), $this -> get_option('manager'), "sgpro", array($this, 'admin_settings'));
		$this -> menus['sgpro-slides'] = add_submenu_page("sgpro", __('Manage Slides', SG2_PLUGIN_NAME), __('Manage Slides', SG2_PLUGIN_NAME), $this -> get_option('manager'), "sgpro-slides", array($this, 'admin_slides'));		
		
		add_action('admin_head-' . $this -> menus['sgpro'], array($this, 'admin_head_gallery_settings'));
	}
	
	function admin_head() {
		$this -> render('head', false, true, 'admin');
	}
	
	function admin_head_gallery_settings() {		
		add_meta_box('submitdiv', __('Save Settings', SG2_PLUGIN_NAME), array($this -> Metabox, "settings_submit"), $this -> menus['sgpro'], 'side', 'core');
		add_meta_box('generaldiv', __('General Settings', SG2_PLUGIN_NAME), array($this -> Metabox, "settings_general"), $this -> menus['sgpro'], 'normal', 'core');
		add_meta_box('linksimagesdiv', __('Links &amp; Images Overlay', SG2_PLUGIN_NAME), array($this -> Metabox, "settings_linksimages"), $this -> menus['sgpro'], 'normal', 'core');
		add_meta_box('stylesdiv', __('Appearance &amp; Styles', SG2_PLUGIN_NAME), array($this -> Metabox, "settings_styles"), $this -> menus['sgpro'], 'normal', 'core');
                if ( SG2_PRO ) {
                    add_meta_box('prodiv', __('Premium Edition Only', SG2_PLUGIN_NAME), array($this -> Metabox, "settings_pro"), $this -> menus['sgpro'], 'normal', 'core');
                }
		
		do_action('do_meta_boxes', $this -> menus['sgpro'], 'normal');
		do_action('do_meta_boxes', $this -> menus['sgpro'], 'side');
		
	}
	
	function admin_notices() {
		$this -> check_uploaddir();
	
		if (!empty($_GET[$this -> pre . 'message'])) {		
			$msg_type = (!empty($_GET[$this -> pre . 'updated'])) ? 'msg' : 'err';
			call_user_method('render_' . $msg_type, $this, $_GET[$this -> pre . 'message']);
		}
	}
	
	function mce_buttons($buttons) {
		array_push($buttons, "separator", "gallery");
		return $buttons;
	}
	
	function mce_external_plugins($plugins) {
		$plugins['gallery'] = SG2_PLUGIN_URL . '/js/tinymce/editor_plugin.js';
		return $plugins;
	}
	
	function slideshow($output = true, $post_id = null, $exclude = null, $include = null, $custom = null, $width = null, $height = null) {

		$this->resetTemp();
		$args = func_get_args();
		global $wpdb;
		$post_id_orig = $post -> ID;
		if ( ((! empty($width)) || (! empty($height))) && SG2_PRO ) {
			require SG2_PLUGIN_DIR . '/pro/custom_sizing.php';
		}
		
//		$this -> add_action( 'wp_print_styles', 'gs_enqueue_styles' );
		if ( ! empty($post_id) && $post = get_post($post_id)) {
			if ($attachments = get_children("post_parent=" . $post -> ID . "&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC")) {
				$content = $this -> exclude_ids($attachments, $exclude, $include);
			}
		}
		elseif ( ! empty( $custom ) ) {
			$slides = $this -> Slide -> find_all(array('section'=>(int) stripslashes($custom)), null, array('order', "ASC"));
			if ( $this -> get_option('transition_temp') == "F") {
				$content = $this -> render('gallery', array('slides' => $slides, 'frompost' => false), false, 'default');
			} elseif ( $this -> get_option('transition_temp') == "OM") {
				$content = $this -> render('multislider', array('slides' => $slides, 'frompost' => false), false, 'pro');
			} else {
				$content = $this -> render('default', array('slides' => $slides, 'frompost' => false), false, 'orbit');
			}			
		}
		else {
			$slides = $this -> Slide -> find_all(null, null, array('order', "ASC"));
			if ( $this -> get_option('transition_temp') == "F") {
				$content = $this -> render('gallery', array('slides' => $slides, 'frompost' => false), false, 'default');
			} elseif ( $this -> get_option('transition_temp') == "OM") {
				$content = $this -> render('multislider', array('slides' => $slides, 'frompost' => false), false, 'pro');
			} else {
				$content = $this -> render('default', array('slides' => $slides, 'frompost' => false), false, 'orbit');
			}
		}
		$post -> ID = $post_id_orig;
		if ($output) { echo $content; } else { return $content; }
	}
	function embed($atts = array(), $content = null) {
		//global variables
		global $wpdb;
		$defaults = array('post_id' => null, 'exclude' => null, 'include' => null, 'custom' => null, 'caption' => null, 'auto' => null, 'w' => null, 'h' => null, 'nolink' => null, 'slug' => null, 'thumbs' => null, 'align' => null, 'transition' => null);
		extract( shortcode_atts( $defaults, $atts ) );
		
		$this->resetTemp();
		$align = stripslashes($align);
		if ( !empty( $align ) ) {
			$style = array();
			$style = $this -> get_option('styles');
			if ( $align == "left" || $align == "right" ) {
				$style['align'] = $align;				
				$this -> update_option('styles', $style);
			}
		}
		if ( !empty( $caption ) ) { 
			if ( ($this -> get_option('information')=='Y') && ( $caption == 'off' ) ) {
				$this -> update_option('information_temp', 'N');	
			} elseif ( ($this -> get_option('information')=='N') && ( $caption == 'on' ) ) {
				$this -> update_option('information_temp', 'Y');
			}
		}
		if ( !empty( $thumbs ) ) { 
			if (($this -> get_option( 'thumbnails')=='Y' ) && ( $thumbs == 'off' )) {
				$this -> update_option('thumbnails_temp', 'N');	
			} elseif (($this -> get_option( 'thumbnails')=='N' ) && ( $thumbs == 'on' )) {
				$this -> update_option( 'thumbnails_temp', 'Y' );
			}
		}
		if ( !empty( $transition ) ) {
			if (($this -> get_option( 'transition' )!='F' ) && ( $transition == 'fade' )) {
				$this -> update_option('transition_temp', 'F');	
			} elseif (($this -> get_option( 'transition' )!='OF' ) && ( $transition == 'orbit-fade' )) {
				$this -> update_option( 'transition_temp', 'OF' );
			} elseif ( $transition == 'vertical-slide' ) {
				$this -> update_option( 'transition_temp', 'OVS' );
			} elseif (($this -> get_option( 'transition' )!='OHS' ) && ( $transition == 'horizontal-slide' )) {
				$this -> update_option( 'transition_temp', 'OHS' );
			} elseif (($this -> get_option( 'transition' )!='OHP' ) && ( $transition == 'horizontal-push' )) {
				$this -> update_option( 'transition_temp', 'OHP' );
			} elseif (($this -> get_option( 'transition' )!='OM' ) && ( $transition == 'orbit-multi' )) {
				$this -> update_option( 'transition_temp', 'OM' );
			}
		}
		if ( !empty( $auto ) ) { 
			if (($this -> get_option('autoslide')=='Y' ) && ( $auto == 'off' ) ) {
				$this -> update_option('autoslide_temp', 'N' );	
			} elseif ( ( $this -> get_option('autoslide')=='N' ) && ($auto == 'on' ) ) {
				$this -> update_option( 'autoslide_temp', 'Y' );
			}
		} elseif ( $this -> get_option( 'autoslide') == 'Y' ) {
			$this -> update_option( 'autoslide_temp', 'Y' ); 
		} else {
			$this -> update_option( 'autoslide_temp', 'N' ); 
		}
		/******** PRO ONLY **************/
		if ( SG2_PRO ) {
			require SG2_PLUGIN_DIR . '/pro/custom_sizing.php';
		}
		//$this -> add_action(array($this, 'pro_custom_wh'));
		/******** END PRO ONLY **************/
		if ( !empty($nocaption) ) { $this -> update_option('information', 'N' ); }
		if ( !empty($nolink) ) { $this -> update_option( 'nolinker', 'Y' ); }
			else { $this -> update_option( 'nolinker', 'N' ); }
		if ( !empty($custom) ) {
			$slides = $this -> Slide -> find_all(array('section'=>(int) stripslashes($custom)), null, array('order', "ASC"));
			if ( $this -> get_option('transition_temp') == "F") {
				$content = $this -> render('gallery', array('slides' => $slides, 'frompost' => false), false, 'default');
			} else {
				$content = $this -> render('default', array('slides' => $slides, 'frompost' => false), false, 'orbit');
			}					
		} else {
			global $post;
			$post_id_orig = $post -> ID;
			if (empty($slug)) {
				$pid = (empty($post_id)) ? $post -> ID : $post_id;
			} else {
				$page = get_page_by_path('$slug');
				if ($page) {
					$pid = $page->ID;
				} else {
					$page = get_page_by_path($slug, '', 'post');
					if ($page) {
						$pid = $page->ID;
					} else {
						$pid = (empty($post_id)) ? $post -> ID : $post_id;
					}
				}
			}
			if (!empty($pid) && $post = get_post($pid)) {
				if ($attachments = get_children("post_parent=" . $post -> ID . "&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC")) {
					$content = $this->exclude_ids($attachments, $exclude, $include);
				}
			}
			$post -> ID = $post_id_orig;
		}
		return $content;
	}
	function resetTemp() {
		// This section allows for using _temp variable only (esp in gallery.php)
		if ($this -> get_option('information')=='Y') { $this -> update_option('information_temp', 'Y'); }
		elseif ($this -> get_option('information')=='N') { $this -> update_option('information_temp', 'N'); }
		if ($this -> get_option('thumbnails')=='Y') { $this -> update_option('thumbnails_temp', 'Y'); }
		elseif ($this -> get_option('thumbnails')=='N') { $this -> update_option('thumbnails_temp', 'N'); }
		if ($this -> get_option('autoslide')=='Y') { $this -> update_option('autoslide_temp', 'Y'); }
		elseif ($this -> get_option('autoslide')=='N') { $this -> update_option('autoslide_temp', 'N'); }
		if ($this -> get_option('transition')=='F') { $this -> update_option('transition_temp', 'F'); }
		elseif ($this -> get_option('transition')=='OF') { $this -> update_option('transition_temp', 'OF'); }
		elseif ($this -> get_option('transition')=='OVS') { $this -> update_option('transition_temp', 'OVS'); }
		elseif ($this -> get_option('transition')=='OHS') { $this -> update_option('transition_temp', 'OHS'); }
		elseif ($this -> get_option('transition')=='OHP') { $this -> update_option('transition_temp', 'OHP'); }
		elseif ($this -> get_option('transition')=='OM') { $this -> update_option('transition_temp', 'OM'); }
		$style = array();
		$style = $this -> get_option('styles');
		$style['align'] = "none";
		$this -> update_option('styles', $style);
	}
	function exclude_ids( $attachments, $exclude, $include ) {
		if ( ! empty( $exclude )) {
			$exclude = array_map('trim', explode(',', $exclude));
/*			echo("<script type='text/javascript'>alert('exclude! ".$exclude[0]."');</script>");*/
			foreach ( $attachments as $id => $attachment ) {
				if (in_array( $id, $exclude )) {
					unset( $attachments[$id] );
				}
			}
		}
		elseif (!empty($include)) {
			$include = array_map('trim', explode(',', $include));
/*			echo("<script type='text/javascript'>alert('include!".$include[0]."');</script>");*/
			foreach ($attachments as $id => $attachment) {
				if (in_array($id, $include)) {}
				else { unset($attachments[$id]); }
			}
		}
		if ( $this -> get_option('transition_temp') == "F") {
			$content = $this -> render('gallery', array('slides' => $attachments, 'frompost' => true), false, 'default');
		} elseif ( $this -> get_option('transition_temp') == "OM") {
			$content = $this -> render('multislider', array('slides' => $attachments, 'frompost' => true), false, 'pro');
		} else {
			$content = $this -> render('default', array('slides' => $attachments, 'frompost' => true), false, 'orbit');
		}	
		return $content;
	}	
	
	function admin_slides() {	
		switch ($_GET['method']) {
			case 'delete'			:
				if (!empty($_GET['id'])) {
					if ($this -> Slide -> delete($_GET['id'])) {
						$msg_type = 'message';
						$message = __('Slide has been removed', SG2_PLUGIN_NAME);
					} else {
						$msg_type = 'error';
						$message = __('Slide cannot be removed', SG2_PLUGIN_NAME);	
					}
				} else {
					$msg_type = 'error';
					$message = __('No slide was specified', SG2_PLUGIN_NAME);
				}
				
				$this -> redirect($this -> url, $msg_type, $message);
				break;
			case 'save'				:
				if (!empty($_POST)) {
					if ($this -> Slide -> save($_POST, true)) {
						$message = __('Slide has been saved', SG2_PLUGIN_NAME);
						$this -> redirect($this -> url, "message", $message);
					} else {
						$this -> render('slides' . DS . 'save', false, true, 'admin');
					}
				} else {
					$this -> Db -> model = $this -> Slide -> model;
					$this -> Slide -> find(array('id' => $_GET['id']));
					$this -> render('slides' . DS . 'save', false, true, 'admin');
				}
				break;
			case 'mass'				:
				if (!empty($_POST['action'])) {
					if (!empty($_POST['Slide']['checklist'])) {						
						switch ($_POST['action']) {
							case 'delete'				:							
								foreach ($_POST['Slide']['checklist'] as $slide_id) {
									$this -> Slide -> delete($slide_id);
								}
								
								$message = __('Selected slides have been removed', SG2_PLUGIN_NAME);
								$this -> redirect($this -> url, 'message', $message);
								break;
						}
					} else {
						$message = __('No slides were selected', SG2_PLUGIN_NAME);
						$this -> redirect($this -> url, "error", $message);
					}
				} else {
					$message = __('No action was specified', SG2_PLUGIN_NAME);
					$this -> redirect($this -> url, "error", $message);
				}
				break;
			case 'order'			:
				$slides = $this -> Slide -> find_all(null, null, array('order', "ASC"));
				$this -> render('slides' . DS . 'order', array('slides' => $slides), true, 'admin');
				break;
			default					:
				$data = $this -> paginate('Slide');				
				$this -> render('slides' . DS . 'index', array('slides' => $data[$this -> Slide -> model], 'paginate' => $data['Paginate']), true, 'admin');
				break;
		}
	}
	
	function admin_settings() {
		switch ($_GET['method']) {
			case 'reset'			:
				global $wpdb;
				$query = "DELETE FROM `" . $wpdb -> prefix . "options` WHERE `option_name` LIKE '" . $this -> pre . "%';";
				
				if ($wpdb -> query($query)) {
					$message = __('All configuration settings have been reset to their defaults', SG2_PLUGIN_NAME);
					$msg_type = 'message';
					$this -> render_msg($message);	
				} else {
					$message = __('Configuration settings could not be reset', SG2_PLUGIN_NAME);
					$msg_type = 'error';
					$this -> render_err($message);
				}
				
				$this -> redirect($this -> url, $msg_type, $message);
				break;
			default					:
				if (!empty($_POST)) {
					foreach ($_POST as $pkey => $pval) {		
						$this -> update_option($pkey, $pval);
					}
					
					$message = __('Configuration has been saved', SG2_PLUGIN_NAME);
					$this -> render_msg($message);
				}	
				break;
		}
				
		$this -> render('settings', false, true, 'admin');
	}
	
}
//initialize a SGPro object
$SGPro = new SGPro();
?>