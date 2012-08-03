<div class="wrap">
	<h2><?php _e('Save a Slide', SG2_PLUGIN_NAME); ?></h2>
	
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post" enctype="multipart/form-data">
		<input type="hidden" name="Slide[id]" value="<?php echo $this -> Slide -> data -> id; ?>" />
		<input type="hidden" name="Slide[order]" value="<?php echo $this -> Slide -> data -> order; ?>" />
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Slide.title"><?php _e('Title', SG2_PLUGIN_NAME); ?></label></th>
					<td>
						<input class="widefat" type="text" name="Slide[title]" value="<?php echo esc_attr($this -> Slide -> data -> title); ?>" id="Slide.title" />
                        <span class="howto"><?php _e('title/name of your slide as it will be displayed to your users.', SG2_PLUGIN_NAME); ?></span>
						<?php echo (!empty($this -> Slide -> errors['title'])) ? '<div style="color:red;">' . $this -> Slide -> errors['title'] . '</div>' : ''; ?>
					</td>
				</tr>
				<tr>
					<th><label for="Slide.description"><?php _e('Description', SG2_PLUGIN_NAME); ?></label></th>
					<td>
						<textarea class="widefat" name="Slide[description]"><?php echo esc_attr($this -> Slide -> data -> description); ?></textarea>
                        <span class="howto"><?php _e('description of your slide as it will be displayed to your users below the title.', SG2_PLUGIN_NAME); ?></span>
						<?php echo (!empty($this -> Slide -> errors['description'])) ? '<div style="color:red;">' . $this -> Slide -> errors['description'] . '</div>' : ''; ?>
					</td>
				</tr>
				<tr>
					<th><label for="Slide.section"><?php _e('Section', SG2_PLUGIN_NAME); ?></label></th>
					<td>
						<?php if (SG2_PRO) { 
							require SG2_PLUGIN_DIR . '/pro/multi-custom.php';
						} else { ?>
						<select disabled><?php echo esc_attr($this -> Slide -> data -> section); ?>
							<option value="1">Custom 1</option>
						</select>						
						<?php } ?>
                        <span class="howto"><?php _e('FULL EDITION ONLY: which custom slideshow would you like this image to apply to?', SG2_PLUGIN_NAME); ?></span>
						<?php echo (!empty($this -> Slide -> errors['section'])) ? '<div style="color:red;">' . $this -> Slide -> errors['section'] . '</div>' : ''; ?>
					</td>
				</tr>				
                <tr>
                	<th><label for="Slide.type.file"><?php _e('Image Type', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                    	<label><input onclick="jQuery('#typediv_file').show(); jQuery('#typediv_url').hide();" <?php echo (empty($this -> Slide -> data -> type) || $this -> Slide -> data -> type == "file") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[type]" value="file" id="Slide.type.file" /> <?php _e('Upload File (recommended)', SG2_PLUGIN_NAME); ?></label>
                        <label><input onclick="jQuery('#typediv_url').show(); jQuery('#typediv_file').hide();" <?php echo ($this -> Slide -> data -> type == "url") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[type]" value="url" id="Slide.type.url" /> <?php _e('Specify URL', SG2_PLUGIN_NAME); ?></label>
                        <?php echo (!empty($this -> Slide -> errors['type'])) ? '<div style="color:red;">' . $this -> Slide -> errors['type'] . '</div>' : ''; ?>
                        <span class="howto"><?php _e('do you want to upload an image or specify a local/remote image URL?', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
				
            </tbody>
        </table>
        
        <div id="typediv_file" style="display:<?php echo (empty($this -> Slide -> data -> type) || $this -> Slide -> data -> type == "file") ? 'block' : 'none'; ?>;">
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for="Slide.image_file"><?php _e('Choose Image', SG2_PLUGIN_NAME); ?></label></th>
                        <td>
                        	<input type="file" name="image_file" value="" id="Slide.image_file" />
                            <span class="howto"><?php _e('choose your image file from your computer. JPG, PNG, GIF, SWF are supported.', SG2_PLUGIN_NAME); ?></span>
                            <?php echo (!empty($this -> Slide -> errors['image_file'])) ? '<div style="color:red;">' . $this -> Slide -> errors['image_file'] . '</div>' : ''; ?>
                            <?php
							if (!empty($this -> Slide -> data -> type) && $this -> Slide -> data -> type == "file") {
								if (!empty($this -> Slide -> data -> image)) {
									$name = $this -> Html -> strip_ext($this -> Slide -> data -> image, 'filename');
									$ext = $this -> Html -> strip_ext($this -> Slide -> data -> image, 'ext');
									?>
                                    
                                    <input type="hidden" name="Slide[image_oldfile]" value="<?php echo esc_attr(stripslashes($this -> Slide -> data -> image)); ?>" />
                                    <p><small><?php _e('Current thumbnail. Leave the field above blank to keep this image.', SG2_PLUGIN_NAME); ?></small></p>
                                   	<a href="<?php echo SG2_UPLOAD_URL; ?>/<?php echo $name; ?>.<?php echo $ext; ?>" class="thickbox">
									<?php if ($ext =="swf") { ?>
									<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="550" height="400" id="movie_name" align="middle">
										<param name="movie" value="<?php echo SG2_UPLOAD_URL; ?>/<?php echo $name; ?>.<?php echo $ext; ?>" />
										<!--[if !IE]>-->
										<object type="application/x-shockwave-flash" data="<?php echo SG2_UPLOAD_URL; ?>/<?php echo $name; ?>.<?php echo $ext; ?>" width="550" height="400">
											<param name="movie" value="movie_name.swf" />
										<!--<![endif]-->
											<a href="http://www.adobe.com/go/getflash">
												<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
											</a>
										<!--[if !IE]>-->
										</object>
										<!--<![endif]-->
									</object>
									
									<?php } else { ?>
										<img src="<?php echo SG2_UPLOAD_URL; ?>/<?php echo $name; ?>-thumb.<?php echo $ext; ?>" alt="" />
									<?php } ?>
											<br />
											<?php	echo ("filename" . $this -> Slide -> data -> image); ?>
										<br />
									</a>
                                    <?php	
								}
							}
							?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div id="typediv_url" style="display:<?php echo ($this -> Slide -> data -> type == "url") ? 'block' : 'none'; ?>;">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="Slide.image_url"><?php _e('Image URL', SG2_PLUGIN_NAME); ?></label></th>
                        <td>
                            <input class="widefat" type="text" name="Slide[image_url]" value="<?php echo esc_attr($this -> Slide -> data -> image_url); ?>" id="Slide.image_url" />
                            <span class="howto"><?php _e('Local or remote image location eg. http://domain.com/path/to/image.jpg', SG2_PLUGIN_NAME); ?></span>
                            <?php echo (!empty($this -> Slide -> errors['image_url'])) ? '<div style="color:red;">' . $this -> Slide -> errors['image_url'] . '</div>' : ''; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>    
                
        <table class="form-table">
        	<tbody>
				<tr>
					<th><label for="Slide_userlink_N"><?php _e('Use Link', SG2_PLUGIN_NAME); ?></label></th>
					<td>
						<label><input onclick="jQuery('#Slide_uselink_div').show();" <?php echo ($this -> Slide -> data -> uselink == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[uselink]" value="Y" id="Slide_uselink_Y" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
						<label><input onclick="jQuery('#Slide_uselink_div').hide();" <?php echo (empty($this -> Slide -> data -> uselink) || $this -> Slide -> data -> uselink == "N") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[uselink]" value="N" id="Slide_uselink_N" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
                        <span class="howto"><?php _e('set this to Yes to link this slide to a link/URL of your choice.', SG2_PLUGIN_NAME); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="Slide_uselink_div" style="display:<?php echo ($this -> Slide -> data -> uselink == "Y") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Slide.link"><?php _e('Link To', SG2_PLUGIN_NAME); ?></label></th>
						<td>
                        	<input class="widefat" type="text" name="Slide[link]" value="<?php echo esc_attr($this -> Slide -> data -> link); ?>" id="Slide.link" />
                            <span class="howto"><?php _e('link/URL to go to when a user clicks the slide eg. http://www.domain.com/mypage/', SG2_PLUGIN_NAME); ?></span>
                        </td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="submit" value="<?php _e('Save Slide', SG2_PLUGIN_NAME); ?>" />
		</p>
	</form>
</div>