<?php $styles = $this -> get_option('styles'); ?>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="styles.navbuttons"><?php _e('Navigational Buttons', SG2_PLUGIN_NAME); ?></label></th>
			<td>
			<?php if ( SG2_PRO ) {
				require SG2_PLUGIN_DIR . '/pro/settings-navbuttons.php';
			} else {
			?>
                <select disabled>
                    <option>Classic </option> <?php _e('Classic', SG2_PLUGIN_NAME); ?>
                </select>
			<?php } ?>
				<div class="alignright" style="width:200px"><img src="<?php echo(SG2_PLUGIN_URL.'/images/nav-options.jpg')?>"></div>
				<span class="howto clear"><?php _e('FULL EDITION ONLY: Choose your nav buttons for left and right transitioning', SG2_PLUGIN_NAME); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.resizeimages"><?php _e('Resize Images (width)', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<label><input <?php echo (empty($styles['resizeimages']) || $styles['resizeimages'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="styles[resizeimages]" value="Y" id="styles.resizeimages_Y" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
				<label><input <?php echo ($styles['resizeimages'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="styles[resizeimages]" value="N" id="styles.resizeimages_N" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
				<span class="howto"><?php _e('should images be resized proportionally to fit the width of the slideshow area', SG2_PLUGIN_NAME); ?></span>
			</td>
		</tr>
        <?php if ( SG2_PRO ) { $resize2 = "type='radio'"; } else { 
			$resize2 = "type='radio' disabled"; 
			$styles['resizeimages2'] = "N";
			}?>        
		<tr>
			<th><label for="styles.resizeimages2"><?php _e('Resize Images (height)', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<label><input <?php echo ($styles['resizeimages2'] == "Y") ? 'checked="checked"' : ''; ?> <?php echo ($resize2); ?> name="styles[resizeimages2]" value="Y" id="styles.resizeimages_Y" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
				<label><input <?php echo (empty($styles['resizeimages2']) || $styles['resizeimages2'] == "N") ? 'checked="checked"' : ''; ?>  <?php echo ($resize2); ?> name="styles[resizeimages2]" value="N" id="styles.resizeimages2_N" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
				<span class="howto"><?php _e('Full Edition only. Should images be resized proportionally to fit the height of the slideshow area. ', SG2_PLUGIN_NAME); ?></span>
			</td>
		</tr>
                <tr>
                    <th><label for="widecenter"><?php _e('Center Vertically?', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <label><input <?php echo ($this->get_option('widecenter') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="widecenter" value="Y" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
                        <label><input <?php echo ($this->get_option('widecenter') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="widecenter" value="N" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
                    </td>
                </tr>
                
		<tr>
			<th><label for="styles.width"><?php _e('Gallery Width', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.width" type="text" name="styles[width]" value="<?php echo $styles['width']; ?>" /> <?php _e('px', SG2_PLUGIN_NAME); ?>
				<span class="howto"><?php _e('width of the slideshow gallery', SG2_PLUGIN_NAME); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.height"><?php _e('Gallery Height', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.height" type="text" name="styles[height]" value="<?php echo $styles['height']; ?>" /> <?php _e('px', SG2_PLUGIN_NAME); ?>
				<span class="howto"><?php _e('height of the slideshow gallery', SG2_PLUGIN_NAME); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.thumbheight"><?php _e('Thumbnail Height', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.thumbheight" type="text" name="styles[thumbheight]" value="<?php echo ($styles['thumbheight'] > 0) ? $styles['thumbheight'] : "75"; ?>" /> <?php _e('px', SG2_PLUGIN_NAME); ?>
				<span class="howto"><?php _e('height of your thumbnails', SG2_PLUGIN_NAME); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.border"><?php _e('Slideshow Border', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<input type="text" name="styles[border]" value="<?php echo $styles['border']; ?>" id="styles.border" style="width:145px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.background"><?php _e('Slideshow Background', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<input type="text" name="styles[background]" value="<?php echo $styles['background']; ?>" id="styles.background" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.infobackground"><?php _e('Information Background', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<input type="text" name="styles[infobackground]" value="<?php echo $styles['infobackground']; ?>" id="styles.infobackground" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.infocolor"><?php _e('Information Text Color', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<input type="text" name="styles[infocolor]" value="<?php echo $styles['infocolor']; ?>" id="styles.infocolor" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.infocolor"><?php _e('Minimize Information Bar Height?', SG2_PLUGIN_NAME); ?></label></th>
			<td>
				<label><input <?php echo (empty($styles['infomin']) || $styles['infomin'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="styles[infomin]" value="Y" id="styles.infomin_Y" /> <?php _e('Yes, minimize', SG2_PLUGIN_NAME); ?></label>
				<label><input <?php echo ($styles['infomin'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="styles[infomin]" value="N" id="styles.infomin_N" /> <?php _e('No, keep styling', SG2_PLUGIN_NAME); ?></label>
				<span class="howto"><?php _e('Keep your theme styling for &quot;H5&quot; and &quot;p&quot;? Or minimize them.', SG2_PLUGIN_NAME); ?></span>
			</td>
		</tr>
	</tbody>
</table>