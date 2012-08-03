<?php
class SGProPlugin {
	var $plugin_name;
	var $plugin_base;
	var $pre = 'SGPro';
	var $debugging = false;
	var $menus = array();
	var $latestorbit = 'jquery.orbit-1.3.0.js';
	var $sections = array(
		'sgpro'     =>	'sgpro-slides',
		'settings'  =>	'sgpro',
	);
	var $helpers = array('Db', 'Html', 'Form', 'Metabox');
	var $models = array('Slide');
	
	function register_plugin($name, $base) {
		$this -> plugin_base = rtrim(dirname($base), DS);
		$this -> enqueue_scripts();
		$this -> initialize_classes();
		$this -> initialize_options();
		
		if (function_exists('load_plugin_textdomain')) {
			$currentlocale = get_locale();
			if(!empty($currentlocale)) {
				$moFile = dirname(__FILE__) . DS . "languages" . DS . SG2_PLUGIN_NAME . "-" . $currentlocale . ".mo";				
				if(@file_exists($moFile) && is_readable($moFile)) {
					load_textdomain(SG2_PLUGIN_NAME, $moFile);
				}
			}
		}
		if ($this -> debugging == true) {
			global $wpdb;
			$wpdb -> show_errors();
			error_reporting(E_ALL);
			@ini_set('display_errors', 1);
		}
		$this -> add_action( 'wp_print_styles', 'sg2_enqueue_styles' );
		return true;
	}
	
	function init_class($name = null, $params = array()) {
		if (!empty($name)) {
			$name = $this -> pre . $name;
			if (class_exists($name)) {
				if ($class = new $name($params)) {							
					return $class;
				}
			}
		}
		$this -> init_class('Country');
		return false;
	}
	
	function initialize_classes() {
		if (!empty($this -> helpers)) {
			foreach ($this -> helpers as $helper) {
				$hfile = dirname(__FILE__) . DS . 'helpers' . DS . strtolower($helper) . '.php';
				if (file_exists($hfile)) {
					require_once($hfile);
					if (empty($this -> {$helper}) || !is_object($this -> {$helper})) {
						$classname = $this -> pre . $helper . 'Helper';
						if (class_exists($classname)) {
							$this -> {$helper} = new $classname;
						}
					}
				} 
			}
		}
		if (!empty($this -> models)) {
			foreach ($this -> models as $model) {
				$mfile = dirname(__FILE__) . DS . 'models' . DS . strtolower($model) . '.php';
				if (file_exists($mfile)) {
					require_once($mfile);
					if (empty($this -> {$model}) || !is_object($this -> {$model})) {
						$classname = $this -> pre . $model;
					
						if (class_exists($classname)) {
							$this -> {$model} = new $classname;
						}
					}
				} 
			}
		}
	}
	
	function initialize_options() {
		$styles = array(
			'width'				=>	"450",
			'height'			=>	"300",
			'thumbheight'			=>	"75",
			'align'				=>	"none",
			'border'			=>	"1px solid #CCCCCC",
			'background'			=>	"#000000",
			'infobackground'		=>	"#000000",
			'infocolor'			=>	"#FFFFFF",
			'infomin'			=>	"Y",
			'resizeimages'			=>	"Y",
			'resizeimages2'			=>	"N"
		);
		
		$this -> add_option('styles', $styles);
		//General Settings
		$this -> add_option('fadespeed', 10);
		$this -> add_option('navopacity', 25);
		$this -> add_option('navhover', 70);
		$this -> add_option('nolinker', "N");
		$this -> add_option('nolinkpage', 0);
		$this -> add_option('pagelink', "S");
		$this -> add_option('captionlink', "N");
		$this -> add_option('transition', "F");
		$this -> add_option('information', "Y");
		$this -> add_option('information_temp', "Y");
		$this -> add_option('infospeed', 10);
		$this -> add_option('showhover', "S");
		$this -> add_option('thumbnails', "N");
		$this -> add_option('thumbnails_temp', "N");
		$this -> add_option('thumbposition', "bottom");
		$this -> add_option('thumbopacity', 70);
		$this -> add_option('thumbscrollspeed', 5);
		$this -> add_option('thumbspacing', 5);
		$this -> add_option('thumbactive', "#FFFFFF");
		$this -> add_option('autoslide', "Y");
		$this -> add_option('autoslide_temp', "Y");
		$this -> add_option('imagesbox', "T");
		$this -> add_option('autospeed', 10);
                $this -> add_option('widecenter', "Y");
		// Orbit Only
		$this -> add_option('autospeed2', 5000);
		$this -> add_option('duration', 700);
		$this -> add_option('othumbs', "B");
                $this -> add_option('bullcenter', "true");
		//Multi-ImageSlide
		$this -> add_option('multicols', 3);
		$this -> add_option('dropshadow', 'N');
                //Premium
                $this -> add_option('custslide', 10);
                $this -> add_option('preload', 'N');
                $this -> add_option('manager', 'manage_options');
                $this -> add_option('orbitinfo', 'Y');
		}
	
	function render_msg($message = '') {
		$this -> render('msg-top', array('message' => $message), true, 'admin');
	}
	
	function render_err($message = '') {
		$this -> render('err-top', array('message' => $message), true, 'admin');
	}
	function redirect($location = '', $msgtype = '', $message = '') {
		$url = $location;
		if ($msgtype == "message") {
			$url .= '&' . $this -> pre . 'updated=true';
		} elseif ($msgtype == "error") {
			$url .= '&' . $this -> pre . 'error=true';
		}
		if (!empty($message)) {
			$url .= '&' . $this -> pre . 'message=' . urlencode($message);
		}
		?>
		<script type="text/javascript">
			window.location = '<?php echo (empty($url)) ? get_option('home') : $url; ?>';
		</script>
		<?php
		flush();
	}
	
	function paginate($model = null, $fields = '*', $sub = null, $conditions = null, $searchterm = null, $per_page = 10, $order = array('modified', "DESC")) {
		global $wpdb;
	
		if (!empty($model)) {
			global $paginate;
			$paginate = $this -> vendor('Paginate');
			$paginate -> table = $this -> {$model} -> table;
			$paginate -> sub = (empty($sub)) ? $this -> {$model} -> controller : $sub;
			$paginate -> fields = (empty($fields)) ? '*' : $fields;
			$paginate -> where = (empty($conditions)) ? false : $conditions;
			$paginate -> searchterm = (empty($searchterm)) ? false : $searchterm;
			$paginate -> per_page = $per_page;
			$paginate -> order = $order;
			$data = $paginate -> start_paging($_GET[$this -> pre . 'page']);
			if (!empty($data)) {
				$newdata = array();
				foreach ($data as $record) {
					$newdata[] = $this -> init_class($model, $record);
				}
				$data = array();
				$data[$model] = $newdata;
				$data['Paginate'] = $paginate;
			}
			return $data;
		}
		return false;
	}
	
	function vendor($name = '', $folder = '') {
		if (!empty($name)) {
			$filename = 'class.' . strtolower($name) . '.php';
			$filepath = rtrim(dirname(__FILE__), DS) . DS . 'vendors' . DS . $folder . '';
			$filefull = $filepath . $filename;
			if (file_exists($filefull)) {
				require_once($filefull);
				$class = 'SGPro' . $name;
				if (${$name} = new $class) {
					return ${$name};
				}
			}
		}
		return false;
	}
	function check_uploaddir() {
		if (!file_exists(SG2_UPLOAD_DIR)) {
			if (@mkdir(SG2_UPLOAD_DIR, 0777)) {
				@chmod(SG2_UPLOAD_DIR, 0777);
				return true;
			} else {
				$message = __('Uploads folder named "' . SG2_PLUGIN_NAME . '" cannot be created inside "' . SG2_UPLOAD_DIR, SG2_PLUGIN_NAME);
				$this -> render_msg($message);
			}
		}
		return false;
	}
	
	function add_action($action, $function = null, $priority = 10, $params = 1) {
		if (add_action($action, array($this, (empty($function)) ? $action : $function), $priority, $params)) {
			return true;
		}
		return false;
	}
	function add_filter($filter, $function = null, $priority = 10, $params = 1) {
		if (add_filter($filter, array($this, (empty($function)) ? $filter : $function), $priority, $params)) {
			return true;
		}
		return false;
	}
	
//	IF ( SG2_LOAD_CSS )
	function sg2_enqueue_styles() {
		
		$cssfile = ($this -> get_option('transition_temp') == 'F') ? 'gallery-css.php' : 'orbit-css.php';
		$galleryStyleFile = SG2_PLUGIN_DIR . '/css/'. $cssfile;
		$galleryStyleUrl = SG2_PLUGIN_URL . '/css/'. $cssfile .'?v='. SG2_VERSION .'&amp;pID=' . $GLOBALS['post']->ID;
		if($_SERVER['HTTPS']) {
			$galleryStyleUrl = str_replace("http:","https:",$galleryStyleUrl);
		}
		$infogal = $this;
        if (file_exists($galleryStyleFile)) {
            if ($styles = $this->get_option('styles')) {
                foreach ($styles as $skey => $sval) {
                    $galleryStyleUrl .= "&amp;" . $skey . "=" . urlencode($sval);
                }
            }
            $width_temp = $this->get_option('width_temp');
            $height_temp = $this->get_option('height_temp');
            $align_temp = $this->get_option('align_temp');
            $nav_temp = $this->get_option('nav_temp');
            //print_r($wp_query->current_post);
                    
            if (is_array($width_temp)) {
                foreach ($width_temp as $skey => $sval) {
                    if ($skey == $pID) 
                        $galleryStyleUrl .= "&amp;width_temp=" . urlencode($sval);
                }
            }
            if (is_array($height_temp)) {
                foreach ($height_temp as $skey => $sval) {
                    if ($skey == $pID)
                        $galleryStyleUrl .= "&amp;height_temp=" . urlencode($sval);
                }
            }
            if (is_array($align_temp)) {
                foreach ($align_temp as $skey => $sval) {
                    if ($skey == $pID)
                        $galleryStyleUrl .= "&amp;align=" . urlencode($sval);
                }
            }
            if (is_array($nav_temp)) {
                foreach ($nav_temp as $skey => $sval) {
                    if ($skey == $pID)
                        $galleryStyleUrl .= "&amp;nav=" . urlencode($sval);
                }
            }
            wp_register_style(SG2_PLUGIN_NAME . "_style", $galleryStyleUrl);
			wp_enqueue_style(SG2_PLUGIN_NAME . "_style");
	}
	}
	function enqueue_scripts() {	
		wp_enqueue_script('jquery');
		
		if (is_admin()) {
			if (!empty($_GET['page']) && in_array($_GET['page'], (array) $this -> sections)) {
				wp_enqueue_script('autosave');
			
				if ($_GET['page'] == 'sgpro') {
					wp_enqueue_script('common');
					wp_enqueue_script('wp-lists');
					wp_enqueue_script('postbox');
					
					wp_enqueue_script('settings-editor', '/' . PLUGINDIR . '/' . SG2_PLUGIN_NAME . '/js/settings-editor.js', array('jquery'), '1.0');
				}
				
				if ($_GET['page'] == "sgpro-slides" && $_GET['method'] == "order") {
					wp_enqueue_script('jquery-ui-sortable');
				}
				wp_enqueue_script('jquery-ui-sortable');
				
				add_thickbox();
			}
			
//			wp_enqueue_script(SG2_PLUGIN_NAME . 'admin', '/' . PLUGINDIR . '/' . SG2_PLUGIN_NAME . '/js/admin.js', null, '1.0');
		} else {
			if ($this -> get_option('transition_temp') == "F") {
				wp_enqueue_script(SG2_PLUGIN_NAME, '/' . PLUGINDIR . '/' . SG2_PLUGIN_NAME . '/js/gallery-min.js', null);
			} else if ($this -> get_option('transition_temp') != "F") {
				wp_register_script('sgpro_ulslide', '/' . PLUGINDIR . '/' . SG2_PLUGIN_NAME . '/js/'.$this -> latestorbit);
				wp_enqueue_script('sgpro_ulslide');
			}
			if (SG2_PRO && ($this->get_option('preload') == 'Y')) {
				wp_register_script('sgpro_preloader', '/' . PLUGINDIR . '/' . SG2_PLUGIN_NAME . '/pro/preloader.js');
				wp_enqueue_script('sgpro_preloader');
			}

			if ($this -> get_option('imagesbox') == "T")
				add_thickbox();
			
		}
		
		return true;
	}
	function plugin_base() {
		return rtrim(dirname(__FILE__), '/');
	}
	function url() {
		return rtrim(WP_PLUGIN_URL , '/') . '/' . substr(preg_replace("/\\" . DS . "/si", "/", $this -> plugin_base()), strlen(ABSPATH));
	}
	function add_option($name = '', $value = '') {
		if (add_option($this -> pre . $name, $value)) {
			return true;
		}
		return false;
	}
	function update_option($name = '', $value = '') {
		if (update_option($this -> pre . $name, $value)) {
			return true;
		}
		return false;
	}
	function get_option($name = '', $stripslashes = true) {
		if ($option = get_option($this -> pre . $name)) {
			if (@unserialize($option) !== false) {
				return unserialize($option);
			}
			if ($stripslashes == true) {
				$option = stripslashes_deep($option);
			}
			return $option;
		}
		return false;
	}
	function debug($var = array()) {
		if ($this -> debugging) {
			echo '<pre>' . print_r($var, true) . '</pre>';
			return true;
		}
		
		return false;
	}
	
	function check_table($model = null) {
		global $wpdb;
	
		if (!empty($model)) {			
			if (!empty($this -> fields) && is_array($this -> fields)) {			
				if (!$wpdb -> get_var("SHOW TABLES LIKE '" . $this -> table . "'")) {				
					$query = "CREATE TABLE `" . $this -> table . "` (";
					$c = 1;
				
					foreach ($this -> fields as $field => $attributes) {
						if ($field != "key") {
							$query .= "`" . $field . "` " . $attributes . "";
						} else {
							$query .= "" . $attributes . "";
						}
						if ($c < count($this -> fields)) {
							$query .= ",";
						}
						$c++;
					}
					
					$query .= ") ENGINE=MyISAM AUTO_INCREMENT=1 CHARSET=UTF8;";
					
					if (!empty($query)) {
						$this -> table_query[] = $query;
					}
				} else {
					$field_array = $this -> get_fields($this -> table);
					
					foreach ($this -> fields as $field => $attributes) {					
						if ($field != "key") {
							$this -> add_field($this -> table, $field, $attributes);
						}
					}
				}
				
				if (!empty($this -> table_query)) {				
					require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
					dbDelta($this -> table_query, true);
				}
			}
		}
		
		return false;
	}
	
	function get_fields($table = null) {	
		global $wpdb;
	
		if (!empty($table)) {
			$fullname = $table;
			if (($tablefields = mysql_list_fields(DB_NAME, $fullname, $wpdb -> dbh)) !== false) { 
				$columns = mysql_num_fields($tablefields);
				$field_array = array();
				for ($i = 0; $i < $columns; $i++) {
					$fieldname = mysql_field_name($tablefields, $i);
					$field_array[] = $fieldname;
				}
	
				return $field_array;
			}
		}
		return false;
	}
	
	function delete_field($table = '', $field = '') {
		global $wpdb;
		
		if (!empty($table)) {
			if (!empty($field)) {
				$query = "ALTER TABLE `" . $wpdb -> prefix . "" . $table . "` DROP `" . $field . "`";
				
				if ($wpdb -> query($query)) {
					return false;
				}
			}
		}
		
		return false;
	}
	
	function change_field($table = '', $field = '', $newfield = '', $attributes = "TEXT NOT NULL") {
		global $wpdb;
		
		if (!empty($table)) {		
			if (!empty($field)) {			
				if (!empty($newfield)) {
					$field_array = $this -> get_fields($table);
					
					if (!in_array($field, $field_array)) {
						if ($this -> add_field($table, $newfield)) {
							return true;
						}
					} else {
						$query = "ALTER TABLE `" . $table . "` CHANGE `" . $field . "` `" . $newfield . "` " . $attributes . ";";
						
						if ($wpdb -> query($query)) {
							return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	function add_field($table = '', $field = '', $attributes = "TEXT NOT NULL") {
		global $wpdb;
	
		if (!empty($table)) {
			if (!empty($field)) {
				$field_array = $this -> get_fields($table);
				
				if (!empty($field_array)) {				
					if (!in_array($field, $field_array)) {					
						$query = "ALTER TABLE `" . $table . "` ADD `" . $field . "` " . $attributes . ";";
						
						if ($wpdb -> query($query)) {
							return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	function render($file = '', $params = array(), $output = true, $folder = 'admin') {	
		if (!empty($file)) {
			$filename = $file . '.php';
			$filepath = $this -> plugin_base() . DS . 'views' . DS . $folder . DS;
			$filefull = $filepath . $filename;
			if (file_exists($filefull)) {
				if (!empty($params)) {
					foreach ($params as $pkey => $pval) {
						${$pkey} = $pval;
					}
				}
				if ($output == false) {
					ob_start();
				}
				include($filefull);
				if ($output == false) {					
					$data = ob_get_clean();					
					return $data;
				} else {
					flush();
					return true;
				}
			}
		}
		return false;
	}
	/**
	 * Add Settings link to plugins - code from GD Star Ratings
	 */
	 function add_sgpro_settings_link($links, $file) {
		static $this_plugin;
		
		if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
		 
		if ($file == $this_plugin){
			$settings_link = '<a href="admin.php?page=sgpro">'.__("Settings", SG2_PLUGIN_NAME).'</a>';
			array_unshift($links, $settings_link);
		}
		return $links;
	 }
 
}
?>