<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="imagesbox_N"><?php _e('Open Images in...', SG2_PLUGIN_NAME); ?></label></th>
            <td>
                <label><input <?php echo ($this -> get_option('imagesbox') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="N" id="imagesbox_N" /> <?php _e('No Link', SG2_PLUGIN_NAME); ?></label>
                <label><input <?php echo ($this -> get_option('imagesbox') == "W") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="W" id="imagesbox_W" /> <?php _e('Window', SG2_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('imagesbox') == "T") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="T" id="imagesbox_T" /> <?php _e('Thickbox', SG2_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('imagesbox') == "S") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="S" id="imagesbox_S" /> <?php _e('Shadowbox', SG2_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('imagesbox') == "P") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="P" id="imagesbox_P" /> <?php _e('PrettyPhoto', SG2_PLUGIN_NAME); ?></label>
            	<span class="howto"><?php _e('Thickbox comes standard with your Wordpress install. Shadowbox and Prettyphoto come only with a specific theme or plugin', SG2_PLUGIN_NAME); ?></span>
            </td>
        </tr>
		<tr>
			<th><?php _e('Recommendations', SG2_PLUGIN_NAME);?> </th>
			<td>
				<div><a href="http://wordpress.org/extend/plugins/shadowbox-js/" target="_blank">Shadowbox Plugin</a></div>
				<div><a href="http://wordpress.org/extend/plugins/wp-prettyphoto/" target="_blank">PrettyPhoto Plugin</a></div>
			</td>
		</tr>
		<tr>
        	<th><label for="pagelink_N"><?php _e('Page Link Target', SG2_PLUGIN_NAME); ?></label></th>
            <td>
                <label><input <?php echo ($this -> get_option('pagelink') == "S") ? 'checked="checked"' : ''; ?> type="radio" name="pagelink" value="S" id="pagelink_S" /> <?php _e('Current Tab', SG2_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('pagelink') == "B") ? 'checked="checked"' : ''; ?> type="radio" name="pagelink" value="B" id="pagelink_B" /> <?php _e('New Tab', SG2_PLUGIN_NAME); ?></label>
            	<span class="howto"><?php _e('Same as setting that <em>target</em> pages are &quot;_self&quot; or &quot;_blank&quot;', SG2_PLUGIN_NAME); ?></span>
            </td>
        </tr>
		<?php if ( SG2_PRO ) {		?>
		<tr>
        	<th><label for="captionlink_N"><?php _e('Use Caption Field as a Link?', SG2_PLUGIN_NAME); ?></label></th>
            <td>
                <label><input <?php echo ($this -> get_option('captionlink') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="captionlink" value="S" id="captionlink_Y" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('captionlink') == ("N"||"")) ? 'checked="checked"' : ''; ?> type="radio" name="captionlink" value="B" id="captionlink_N" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
            	<span class="howto"><?php _e('If using the <strong>Wordpress Image Gallery</strong> you can still link out to a new page by using the Caption Field', SG2_PLUGIN_NAME); ?></span>
            </td>
        </tr>
		<?php } ?>
    </tbody>
</table>