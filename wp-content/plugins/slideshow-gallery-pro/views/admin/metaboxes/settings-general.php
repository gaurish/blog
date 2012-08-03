<table class="form-table">
    <tbody>
        <tr>
            <th><label for="transition"><?php _e('Transition Style', SG2_PLUGIN_NAME); ?></label></th>
            <td>
                <?php if (SG2_PRO) { ?>
                    <select name="transition" class="sgpro_trans">
                        <option <?php echo ($this->get_option('transition') == "F") ? 'selected' : ''; ?> value="F"><?php _e('Default Fade', SG2_PLUGIN_NAME); ?></option> 
                        <option <?php echo ($this->get_option('transition') == "OF") ? 'selected' : ''; ?> value="OF"><?php _e('Orbit Fade', SG2_PLUGIN_NAME); ?></option> 
                        <option <?php echo ($this->get_option('transition') == "OHS") ? 'selected' : ''; ?> value="OHS"><?php _e('Orbit Horizontal-Slide', SG2_PLUGIN_NAME); ?></option> 
                        <option <?php echo ($this->get_option('transition') == "OVS") ? 'selected' : ''; ?> value="OVS"><?php _e('Orbit Vertical-Slide', SG2_PLUGIN_NAME); ?></option> 
                        <option <?php echo ($this->get_option('transition') == "OHP") ? 'selected' : ''; ?> value="OHP"><?php _e('Orbit Horizontal-Push', SG2_PLUGIN_NAME); ?></option> 
                        <!--<option <?php echo ($this->get_option('transition') == "OM") ? 'selected' : ''; ?> value="OM"><?php _e('Orbit Multi-Image Slider', SG2_PLUGIN_NAME); ?></option> -->
                    </select>
                <? } else { ?>
                    <select name="transition" class="sgpro_trans">
                        <option <?php echo ($this->get_option('transition') == "F") ? 'selected' : ''; ?> value="F"><?php _e('Default Fade', SG2_PLUGIN_NAME); ?></option> 
                        <option <?php echo ($this->get_option('transition') == "OF") ? 'selected' : ''; ?> value="OF"><?php _e('Orbit Fade', SG2_PLUGIN_NAME); ?></option> 
                        <option <?php echo ($this->get_option('transition') == "OHS") ? 'selected' : ''; ?> value="OHS"><?php _e('Orbit Horizontal-Slide', SG2_PLUGIN_NAME); ?></option> 
                        <option <?php echo ($this->get_option('transition') == "OVS") ? 'selected' : ''; ?> value="OVS"><?php _e('Orbit Vertical-Slide', SG2_PLUGIN_NAME); ?></option> 
                        <option <?php echo ($this->get_option('transition') == "OHP") ? 'selected' : ''; ?> value="OHP"><?php _e('Orbit Horizontal-Push', SG2_PLUGIN_NAME); ?></option> 
                    </select>
                <?php } ?>
                <span class="howto"><?php _e('Orbits do not allow thumbnails', SG2_PLUGIN_NAME); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="autoslideY"><?php _e('Auto Slide', SG2_PLUGIN_NAME); ?></label></th>
            <td>
                <label><input onclick="jQuery('#autoslide_div').show();jQuery('#autoslide2_div').show();" <?php echo ($this->get_option('autoslide') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="autoslide" value="Y" id="autoslide2Y" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
                <label><input onclick="jQuery('#autoslide_div').hide();jQuery('#autoslide2_div').hide();" <?php echo ($this->get_option('autoslide') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="autoslide" value="N" id="autoslide2N" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
            </td>
        </tr>
    </tbody>
</table>
<script>
    jQuery(".sgpro_trans").change(function () {
        //alert(jQuery("select option:selected").val());
        jQuery('#multislide_style_div').hide();
        if (jQuery("select option:selected").val() == 'F') {
            jQuery('#transslide_div').hide();
            jQuery('#fadeslide_div').show();
        } else {
            jQuery('#fadeslide_div').hide();
            jQuery('#transslide_div').show();
        }
        if (jQuery("select option:selected").val() == 'OM') {
            jQuery('#multislide_style_div').show();
        }
        else {
            jQuery('#multislide_style_div').hide();
        }
    }).change();

</script>
<div id="transslide_div" style="display:<?php echo ($this->get_option('transition') != "F") ? 'block' : 'none'; ?>;">
    <div id="autoslide2_div" style="display:<?php echo ($this->get_option('autoslide') == "Y") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="autospeed"><?php _e('Auto Speed', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <input type="text" style="width:45px;" name="autospeed2" value="<?php echo $this->get_option('autospeed2'); ?>" id="autospeed2" /> <?php _e('speed', SG2_PLUGIN_NAME); ?>
                        <span class="howto"><?php _e('default:5000 recommended:2000-12000', SG2_PLUGIN_NAME); ?><br/><?php _e('lower number for quicker length of time between sliding of images', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="duration"><?php _e('Transition Speed', SG2_PLUGIN_NAME); ?></label></th>
                <td>
                    <input style="width:45px;" type="text" name="duration" value="<?php echo $this->get_option('duration'); ?>" id="fadespeed" /> <?php _e('duration', SG2_PLUGIN_NAME); ?>
                    <span class="howto"><?php _e('default:700 recommended:300-2000', SG2_PLUGIN_NAME); ?><br/><?php _e('lower number for quicker transition of images', SG2_PLUGIN_NAME); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="othumbs"><?php _e('Thumbnail Style', SG2_PLUGIN_NAME); ?></label></th>
                <td>
                    <label><input <?php echo ($this->get_option('othumbs') == ("N" || null)) ? 'checked="checked"' : ''; ?> type="radio" name="othumbs" value="N" id="othumbsN" /> <?php _e('None', SG2_PLUGIN_NAME); ?></label>
                    <label><input <?php echo ($this->get_option('othumbs') == "B") ? 'checked="checked"' : ''; ?> type="radio" name="othumbs" value="B" id="othumbsB" /> <?php _e('Bullets', SG2_PLUGIN_NAME); ?></label>
                    <span class="howto"><?php _e('More image thumbnails coming soon', SG2_PLUGIN_NAME); ?></span>
                </td>
            </tr>		
                <tr>
                    <th><label for="bullcenter"><?php _e('Bullet Centering', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <label><input <?php echo ($this->get_option('bullcenter') == "true") ? 'checked="checked"' : ''; ?> type="radio" name="bullcenter" value="true" /> <?php _e('On', SG2_PLUGIN_NAME); ?></label>
                        <label><input <?php echo ($this->get_option('bullcenter') == "false") ? 'checked="checked"' : ''; ?> type="radio" name="bullcenter" value="false" /> <?php _e('Off', SG2_PLUGIN_NAME); ?></label>
                    </td>
                </tr>
            <tr>
                <th><label for="orbitinfo"><?php _e('Show Captions', SG2_PLUGIN_NAME); ?></label></th>
                <td>
                    <label><input <?php echo ($this->get_option('orbitinfo') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="orbitinfo" value="Y" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
                    <label><input <?php echo ($this->get_option('orbitinfo') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="orbitinfo" value="N" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
                </td>
            </tr>                
        </tbody>
    </table>
    <div id="multislide_style_div" style="display:<?php echo ($this->get_option('transition') == "OM") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="multicols"><?php _e('Number of Images in a Row', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <select name="multicols" class="sgpro_trans">
                            <?php for ($i = 1; $i < 20; $i++) { ?>
                                <option <?php echo ($this->get_option('multicols') == $i) ? 'selected' : ''; ?> value="<?php echo($i); ?>"><?php echo($i); ?></option>
                            <?php } ?>
                        </select>
                        <span class="howto"><?php _e('Number of columns in your multi-image slider', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="dropshadow"><?php _e('Drop Shadow', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <label><input onclick="jQuery('#dropshadow_div').show();" <?php echo ($this->get_option('dropshadow') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="dropshadow" value="Y" id="dropshadowY" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
                        <label><input onclick="jQuery('#dropshadow_div').hide()" <?php echo ($this->get_option('dropshadow') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="dropshadow" value="N" id="dropshadowN" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
                    </td>
                </tr>			
            </tbody>
        </table>
    </div>
</div>
<div id="fadeslide_div"  style="display:<?php echo ($this->get_option('transition') == "F") ? 'block' : 'none'; ?>;">
    <div id="autoslide_div" style="display:<?php echo ($this->get_option('autoslide') == "Y") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="autospeed"><?php _e('Auto Speed', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <input type="text" style="width:45px;" name="autospeed" value="<?php echo $this->get_option('autospeed'); ?>" id="autospeed" /> <?php _e('speed', SG2_PLUGIN_NAME); ?>
                        <span class="howto"><?php _e('default:10', SG2_PLUGIN_NAME); ?><br/><?php _e('lower number for shorter interval between images', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <table class="form-table">

        <tbody>
            <tr>
                <th><label for="fadespeed"><?php _e('Image Fading Speed', SG2_PLUGIN_NAME); ?></label></th>
                <td>
                    <input style="width:45px;" type="text" name="fadespeed" value="<?php echo $this->get_option('fadespeed'); ?>" id="fadespeed" />
                    <span class="howto"><?php _e('default:50 recommended:1-100', SG2_PLUGIN_NAME); ?><br/><?php _e('lower number for quicker fading of images', SG2_PLUGIN_NAME); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="navopacity"><?php _e('Navigation Default Opacity', SG2_PLUGIN_NAME); ?></label></th>
                <td>
                    <input type="text" name="navopacity" value="<?php echo $this->get_option('navopacity'); ?>" id="navopacity" style="width:45px;" /> <?php _e('&#37; <!-- percentage -->', SG2_PLUGIN_NAME); ?>
                    <span class="howto"><?php _e('opacity of the prev/next buttons by default', SG2_PLUGIN_NAME); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="navhover"><?php _e('Navigation Hover Opacity', SG2_PLUGIN_NAME); ?></label></th>
                <td>
                    <input type="text" name="navhover" value="<?php echo $this->get_option('navhover'); ?>" id="navhover" style="width:45px;" /> <?php _e('&#37; <!-- percentage -->', SG2_PLUGIN_NAME); ?>
                    <span class="howto"><?php _e('opacity of the prev/next buttons when they are hovered', SG2_PLUGIN_NAME); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="informationY"><?php _e('Show Information', SG2_PLUGIN_NAME); ?></label></th>
                <td>
                    <label><input onclick="jQuery('#information_div').show();" <?php echo ($this->get_option('information') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="information" value="Y" id="informationY" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
                    <label><input onclick="jQuery('#information_div').hide();" <?php echo ($this->get_option('information') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="information" value="N" id="informationN" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="information_div" style="display:<?php echo ($this->get_option('information') == "Y") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="infospeed"><?php _e('Information Speed', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <input type="text" style="width:45px;" name="infospeed" value="<?php echo $this->get_option('infospeed'); ?>" id="infospeed" />
                        <span class="howto"><?php _e('speed at which the information will slide in', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="showhover"><?php _e('Information Display Settings', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <?php $showh = $this->get_option('showhover'); ?>
                        <label><input <?php echo (empty($showh) || $this->get_option('showhover') == "S") ? 'checked="checked"' : ''; ?> type="radio" name="showhover" value="S" id="showhoverS" /> <?php _e('Scroll Up', SG2_PLUGIN_NAME); ?></label>
                        <label><input <?php echo ($this->get_option('showhover') == "P") ? 'checked="checked"' : ''; ?> type="radio" name="showhover" value="P" id="showhoverP" /> <?php _e('Permanently Show', SG2_PLUGIN_NAME); ?></label>
                        <label><input <?php echo ($this->get_option('showhover') == "H") ? 'checked="checked"' : ''; ?> type="radio" name="showhover" value="H" id="showhoverH" /> <?php _e('Mouse Hover Only', SG2_PLUGIN_NAME); ?></label>
                        <span class="howto"><?php _e('How do you want to display the information (caption) bar?', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="thumbnailsN"><?php _e('Show Thumbnails', SG2_PLUGIN_NAME); ?></label></th>
                <td>
                    <label><input onclick="jQuery('#thumbnails_div').show();" <?php echo ($this->get_option('thumbnails') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="thumbnails" value="Y" id="thumbnailsY" /> <?php _e('Yes', SG2_PLUGIN_NAME); ?></label>
                    <label><input onclick="jQuery('#thumbnails_div').hide();" <?php echo ($this->get_option('thumbnails') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="thumbnails" value="N" id="thumbnailsN" /> <?php _e('No', SG2_PLUGIN_NAME); ?></label>
                </td>
            </tr>
        </tbody>
    </table>
    <div id="thumbnails_div" style="display:<?php echo ($this->get_option('thumbnails') == "Y") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="thubmpositionbottom"><?php _e('Thumbnails Position', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <label><input <?php echo ($this->get_option('thumbposition') == "top") ? 'checked="checked"' : ''; ?> type="radio" name="thumbposition" value="top" id="thumbpositiontop" /> <?php _e('Top', SG2_PLUGIN_NAME); ?></label>
                        <label><input <?php echo ($this->get_option('thumbposition') == "bottom") ? 'checked="checked"' : ''; ?> type="radio" name="thumbposition" value="bottom" id="thumbpositionbottom" /> <?php _e('Bottom', SG2_PLUGIN_NAME); ?></label>
                    </td>
                </tr>
                <tr>
                    <th><label for="thumbopacity"><?php _e('Thumbnail Opacity', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <input style="width:45px;" type="text" name="thumbopacity" value="<?php echo $this->get_option('thumbopacity'); ?>" id="thumbopacity" /> <?php _e('&#37; <!-- percentage -->', SG2_PLUGIN_NAME); ?>
                        <span class="howto"><?php _e('default opacity of thumbnails when they are not hovered', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="thumbactive"><?php _e('Thumbnail Active Border', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <input style="width:65px;" type="text" name="thumbactive" value="<?php echo $this->get_option('thumbactive'); ?>" id="thumbactive" />
                        <span class="howto"><?php _e('border color (hexidecimal) for the active image thumbnail. default:#FFFFFF', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="thumbscrollspeed"><?php _e('Thumbnails Scroll Speed', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <input class="widefat" style="width:45px;" name="thumbscrollspeed" value="<?php echo $this->get_option('thumbscrollspeed'); ?>" id="thumbscrollspeed" /> <?php _e('speed', SG2_PLUGIN_NAME); ?>
                        <span class="howto"><?php _e('default:5 recommended:1-20', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for=""><?php _e('Thumbnail Spacing', SG2_PLUGIN_NAME); ?></label></th>
                    <td>
                        <input type="text" style="width:45px;" name="thumbspacing" value="<?php echo $this->get_option('thumbspacing'); ?>" id="thumbspacing" /> <?php _e('px', SG2_PLUGIN_NAME); ?>
                        <span class="howto"><?php _e('horizontal margin/spacing between thumbnails', SG2_PLUGIN_NAME); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>