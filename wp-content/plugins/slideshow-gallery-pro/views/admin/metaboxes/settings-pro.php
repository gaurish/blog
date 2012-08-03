<table class="form-table">
    <tbody>
        <tr>
            <th><label for="custslide"><?php _e('# of Custom Slideshows', SG2_PLUGIN_NAME); ?></label></th>
            <td>
                <?php if (SG2_PRO) { ?>
                    <select name="custslide">
                        <option <?php echo ($this->get_option('custslide') == "10") ? 'selected' : ''; ?> value="10">10</option> 
                        <option <?php echo ($this->get_option('custslide') == "20") ? 'selected' : ''; ?> value="20">20</option> 
                        <option <?php echo ($this->get_option('custslide') == "40") ? 'selected' : ''; ?> value="40">40</option> 
                        <option <?php echo ($this->get_option('custslide') == "65") ? 'selected' : ''; ?> value="65">65</option> 
                        <option <?php echo ($this->get_option('custslide') == "100") ? 'selected' : ''; ?> value="100">100</option> 
                    </select>
                <? } ?>
        </tr>
        <tr>
            <th><label for="preload"><?php _e('Preloader', SG2_PLUGIN_NAME); ?></label></th>
            <td>
                <label><input <?php echo ($this->get_option('preload') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="preload" value="Y" /> <?php _e('On', SG2_PLUGIN_NAME); ?></label>
                <label><input <?php echo ($this->get_option('preload') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="preload" value="N" /> <?php _e('Off', SG2_PLUGIN_NAME); ?></label>
            </td>
        </tr>        
        <tr>
            <th><label for="manager"><?php _e('Who can edit?', SG2_PLUGIN_NAME); ?></label></th>
            <td>
                <select name="manager">
                    <option <?php echo ($this->get_option('manager') == "manage_options") ? 'selected' : ''; ?> value="manage_options">Administrator</option> 
                    <option <?php echo ($this->get_option('manager') == "edit_pages") ? 'selected' : ''; ?> value="edit_pages">Editor</option> 
                    <option <?php echo ($this->get_option('manager') == "publish_posts") ? 'selected' : ''; ?> value="publish_posts">Author</option> 
                </select>
            </td>
        </tr>        
    </tbody>
</table>
