<?php
class SGProSlide extends SGProDbHelper {
	var $table;
	var $model = 'Slide';
	var $controller = "slides";
	var $plugin_name = SG2_PLUGIN_NAME;
	var $data = array();
	var $errors = array();
	var $fields = array(
		'id'			=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'			=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'description'		=>	"TEXT",
		'image'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'type'			=>	"ENUM('file','url') NOT NULL DEFAULT 'file'",
		'section'		=>	"INT(5) NOT NULL DEFAULT '1'",
		'image_url'		=>	"VARCHAR(200) NOT NULL DEFAULT ''",
		'uselink'		=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'link'			=>	"VARCHAR(200) NOT NULL DEFAULT ''",
		'order'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'		=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'		=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'			=>	"PRIMARY KEY (`id`)",
	);
	function SGProSlide($data = array()) {
		global $wpdb;
                
		//$this -> table = $wpdb -> prefix . strtolower($this -> pre) . "_" . $this -> controller;
                $this -> table = $wpdb -> prefix . "gallery_" . $this -> controller;
		$this -> check_table($this -> model);
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
			}
		}
	
		return true;
	}
	function defaults() {
		$defaults = array(
			'order'				=>	0,
			'created'			=>	SGProHtmlHelper::gen_date(),
			'modified'		=>	SGProHtmlHelper::gen_date(),
		);
		
		return $defaults;
	}
	function validate($data = null) {
		$this -> errors = array();
	
		if (!empty($data)) {
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			
			foreach ($data as $dkey => $dval) {
				$this -> data -> {$dkey} = stripslashes($dval);
			}
			
			extract($data, EXTR_SKIP);
			
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', SG2_PLUGIN_NAME); }
			//if (empty($description)) { $this -> errors['description'] = __('Please fill in a description', SG2_PLUGIN_NAME); }
			if (empty($type)) { $this -> errors['type'] = __('Please select an image type', SG2_PLUGIN_NAME); }
			//if (empty($section)) { $section = '1'; }
			
			elseif ($type == "file") {
				if (!empty($image_oldfile) && empty($_FILES['image_file']['name'])) {
					$imagename = str_replace(" ", "-", $image_oldfile);
					
					$imagepath = SG2_UPLOAD_DIR . DS;
					$imagefull = $imagepath . $imagename;
					
					$this -> data -> image = $imagename;
				} else {					
					if ($_FILES['image_file']['error'] <= 0) {
						$imagename = str_replace(" ", "-", $_FILES['image_file']['name']);
						$imagepath = SG2_UPLOAD_DIR . DS;
						$imagefull = $imagepath . $imagename;
						
						if (!is_uploaded_file($_FILES['image_file']['tmp_name'])) { $this -> errors['image_file'] = __('The image did not upload, please try again', SG2_PLUGIN_NAME); }
						elseif (!move_uploaded_file($_FILES['image_file']['tmp_name'], $imagefull)) { $this -> errors['image_file'] = __('Image could not be moved from TMP to '. SG2_UPLOAD_URL .', please check permissions', SG2_PLUGIN_NAME); }
						else {
							$this -> data -> image = $imagename;
							
							$name = SGProHtmlHelper::strip_ext($imagename, 'filename');
							$ext = SGProHtmlHelper::strip_ext($imagename, 'ext');
							$thumbfull = $imagepath . $name . '-thumb.' . strtolower($ext);
							$smallfull = $imagepath . $name . '-small.' . strtolower($ext);
						
							image_resize($imagefull, $width = 100, $height = 100, $crop = true, $append = 'thumb', $dest = null, $quality = 100);
							image_resize($imagefull, $width = 50, $height = 50, $crop = true, $append = 'small', $dest = null, $quality = 100);
							
							@chmod($imagefull, 0777);
							@chmod($thumbfull, 0777);
							@chmod($smallfull, 0777);
						}
					} else {					
						switch ($_FILES['image_file']['error']) {
							case UPLOAD_ERR_INI_SIZE		:
							case UPLOAD_ERR_FORM_SIZE 		:
								$this -> errors['image_file'] = __('The image file is too large', SG2_PLUGIN_NAME);
								break;
							case UPLOAD_ERR_PARTIAL 		:
								$this -> errors['image_file'] = __('The image was partially uploaded, please try again', SG2_PLUGIN_NAME);
								break;
							case UPLOAD_ERR_NO_FILE 		:
								$this -> errors['image_file'] = __('No image was chosen for uploading, please choose an image', SG2_PLUGIN_NAME);
								break;
							case UPLOAD_ERR_NO_TMP_DIR 		:
								$this -> errors['image_file'] = __('No TMP directory has been specified for PHP to use, please ask your hosting provider', SG2_PLUGIN_NAME);
								break;
							case UPLOAD_ERR_CANT_WRITE 		:
								$this -> errors['image_file'] = __('Image cannot be written to disc, please ask your hosting provider', SG2_PLUGIN_NAME);
								break;
						}
					}
				}
			} elseif ($type == "url") {
				if (empty($image_url)) { $this -> errors['image_url'] = __('Please specify an image', SG2_PLUGIN_NAME); }
				else {
					if ($image = wp_remote_fopen($image_url)) {
						$filename = str_replace(" ", "-", basename($image_url));
						$filepath = SG2_UPLOAD_DIR . DS;
						
						$filefull = $filepath . $filename;
						if (!file_exists($filefull)) {
							$fh = @fopen($filefull, "w");
							@fwrite($fh, $image);
							@fclose($fh);
							$name = SGProHtmlHelper::strip_ext($filename, 'filename');
							$ext = SGProHtmlHelper::strip_ext($filename, 'ext');
							$thumbfull = $filepath . $name . '-thumb.' . strtolower($ext);
							$smallfull = $filepath . $name . '-small.' . strtolower($ext);
							image_resize($filefull, $width = 100, $height = 100, $crop = true, $append = 'thumb', $dest = null, $quality = 100);
							image_resize($filefull, $width = 50, $height = 50, $crop = true, $append = 'small', $dest = null, $quality = 100);
							@chmod($filefull, 0777);
							@chmod($thumbfull, 0777);
							@chmod($smallfull, 0777);
						}
					}
				}
			}
		} else {
			$this -> errors[] = __('No data was posted', SG2_PLUGIN_NAME);
		}
		return $this -> errors;
	}
}
?>