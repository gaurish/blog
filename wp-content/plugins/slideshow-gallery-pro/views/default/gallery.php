<?php
$style = $this->get_option('styles');
?>
<?php if (!empty($slides)) : ?>
    <script type="text/javascript">
        var jsSlideshow = new Array();

    <?php
    /*     * ************  CREATING ARRAY OF IMAGES ************* */
    $slidenums = 0;
    if ($frompost) :
        foreach ($slides as $single) :
            $full_image_href2 = wp_get_attachment_image_src($single->ID, 'full', false);
            $slideshow[] = $full_image_href2;
            ?>
                                        jsSlideshow.push("<?php echo($full_image_href2[0]); ?>");
            <?php
            $slidenums += 1;
        endforeach;
    else:
        foreach ($slides as $single):
            ?>
                                jsSlideshow.push("<?php echo SG2_UPLOAD_URL ?>/<?php echo $single->image; ?>");
            <?php
            $slidenums += 1;
        endforeach;
    endif;

    /*     * *** END ARRAY OF IMAGES *** */
    ?>
    </script>
    <ul id="sgpro_slideshow" style="display:none;">
            <?php if ($frompost) : // WORDPRESS IMAGE GALLERY ONLY   ?>
                <?php foreach ($slides as $slide) : ?>
                <li>
                    <h5><?php echo $slide->post_title; ?></h5>

            <?php $full_image_href = wp_get_attachment_image_src($slide->ID, 'full', false); ?>
                    <?php
                    if (SG2_PRO) {
                        require SG2_PLUGIN_DIR . '/pro/image_tall_frompost.php';
                    } else {
                        echo "<h4>&nbsp;</h4>";
                    }
                    ?>
                    <span><?php echo $full_image_href[0]; ?></span>

                    <p><?php echo $slide->post_content; ?></p>
                    <?php $thumbnail_link = wp_get_attachment_image_src($slide->ID, 'thumbnail', false); ?>
                    <?php if ($this->get_option('thumbnails_temp') == "Y") : ?>
                        <?php if (!empty($slide->guid)) : ?>
                            <?php
                            if (SG2_PRO) :
                                require SG2_PLUGIN_DIR . '/pro/caption_link-frompost.php';
                            else :
                                ?>
                                <a rel="lightbox" href="<?php echo $slide->guid; ?>" title="<?php echo $slide->post_title; ?>"><img style="height:<?php echo $style['thumbheight'] ?>px;" src="<?php echo $thumbnail_link[0]; ?>" alt="<?php echo $this->Html->sanitize($slide->post_title); ?>" />la</a>                                
                            <?php endif; ?>
                        <?php else : ?>
                        <?php list($width, $height, $type, $attr) = getimagesize($full_image_href[0]); ?>
                            <img style="height:<?php echo $style['thumbheight'] ?>px;" src="<?php echo $thumbnail_link[0]; ?>" alt="<?php echo $this->Html->sanitize($slide->post_title); ?>" />
                    <?php endif; ?>
                <?php else : // NO thumbnails_temp?>

                        <?php
                        if (SG2_PRO):
                            require SG2_PLUGIN_DIR . '/pro/caption_link-frompost-nothumb.php';
                        else:
                            ?>
                            <a href="<?php echo $slide->guid; ?>" title="<?php echo $slide->post_title; ?>"> </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            <?php else : // CUSTOM SLIDES - MANAGE SLIDES ONLY   ?>
                <?php foreach ($slides as $slide) : ?>		
                <li>
                    <h5><?php echo $slide->title; ?></h5>
                    <?php
                    if (SG2_PRO) {
                        require SG2_PLUGIN_DIR . '/pro/image_tall_custom.php';
                    } else {
                        echo "<h4>&nbsp;</h4>";
                    }
                    ?>
                    <span><?php echo SG2_UPLOAD_URL ?>/<?php echo $slide->image; ?></span>
                    <p><?php echo $slide->description; ?></p>
                <?php if ($this->get_option('thumbnails_temp') == "Y") : ?>
                    <?php if ($slide->uselink == "Y" && !empty($slide->link)) : ?>
                            <a href="<?php echo $slide->link; ?>" title="<?php echo str_replace('"', '', $slide->title); ?>"><img style="height:<?php echo $style['thumbheight'] ?>px;" src="<?php echo $this->Html->image_url($this->Html->thumbname($slide->image)); ?>" alt="<?php echo $this->Html->sanitize($slide->title); ?>" /></a>
                <?php else : ?>
                            <a href="<?php echo $this->Html->image_url($slide->image); ?>" title="<?php echo $this->Html->sanitize($slide->title); ?>" rel="shadowbox[post-<?php echo the_ID(); ?>]"><img style="height:<?php echo $style['thumbheight'] ?>px;" src="<?php echo $this->Html->image_url($this->Html->thumbname($slide->image)); ?>" alt="<?php echo $this->Html->sanitize($slide->title); ?>" /></a>
                <?php endif; ?>
            <?php else : // NO THUMBNAILS  ?>
                <?php if ($slide->uselink == "N" || empty($slide->link)) : ?>
                            <a href="<?php echo $this->Html->image_url($slide->image); ?>" title="<?php echo str_replace('"', '', $slide->title); ?>" rel="shadowbox[post-<?php echo the_ID(); ?>]"></a>
                    <?php else : ?>
                            <a href="<?php echo $slide->link; ?>" title="<?php echo str_replace('"', '', $slide->title); ?>"></a>
                <?php endif; ?>
            <?php endif; ?>
                </li>
        <?php endforeach; ?>
            <?php endif; ?>
    </ul>
    <div id="slideshow-wrapper">
    <?php if ($this->get_option('thumbnails_temp') == "Y" && $this->get_option('thumbposition') == "top") : ?>
            <div id="thumbnails" class="thumbstop">
                <div id="slideleft" title="<?php _e('Slide Left', SG2_PLUGIN_NAME); ?>"></div>
                <div id="slidearea">
                    <div id="thumbslider"></div>
                </div>
                <div id="slideright" title="<?php _e('Slide Right', SG2_PLUGIN_NAME); ?>"></div>
                <br style="clear:both; visibility:hidden; height:1px;" />
            </div>
    <?php endif; ?>
        <div id="fullsize">
            <div id="imgprev" class="imgnav" title="Previous Image"></div>
            <div id="imglink"></div>
            <div id="imgnext" class="imgnav" title="Next Image"></div>
            <div id="sgpro_image"></div>
    <?php if ($this->get_option('information_temp') == "Y") : ?>
                <div id="information">
                    <h5></h5>
                    <p></p>
                </div>
    <?php endif; ?>
        </div>            
    <?php if ($this->get_option('thumbnails_temp') == "Y" && $this->get_option('thumbposition') == "bottom") : ?>
            <div id="thumbnails" class="thumbsbot">
                <div id="slideleft" title="<?php _e('Slide Left', SG2_PLUGIN_NAME); ?>"></div>
                <div id="slidearea">
                    <div id="thumbslider"></div>
                </div>
                <div id="slideright" title="<?php _e('Slide Right', SG2_PLUGIN_NAME); ?>"></div>
                <br style="clear:both; visibility:hidden; height:1px;" />
            </div>
    <?php endif; ?>


    </div>
    <?php
    if ($this->get_option('imagesbox') == "T")
        $imgbox = "thickbox";
    elseif ($this->get_option('imagesbox') == "S")
        $imgbox = "shadowbox";
    elseif ($this->get_option('imagesbox') == "P")
        $imgbox = "prettyphoto";
    elseif ($this->get_option('imagesbox') == "N")
        $imgbox = "nolink";
    else
        $imgbox = "window";
    IF ($style['height_temp']) {
        $style['height'] = $style['height_temp'];
    }
    IF ($style['width_temp']) {
        $style['width'] = $style['width_temp'];
    }
    ?>
    <script type="text/javascript">
        jQuery.noConflict();
        tid('sgpro_slideshow').style.display = "none";
        tid('slideshow-wrapper').style.display = 'block';
        tid('slideshow-wrapper').style.visibility = 'hidden';	
        jQuery("#fullsize").append('<div id="spinner"><img src="<?php echo SG2_PLUGIN_URL ?>/images/spinner.gif"></div>');
        tid('spinner').style.visibility = 'visible';
        var sgpro_slideshow = new TINY.sgpro_slideshow("sgpro_slideshow");
    <?php $preload = "off"; ?>
    <?php if (SG2_PRO && $slidenums > 4 && $preload == "on") : ?>
            jQuery.preLoadImages(
            [jsSlideshow[0],jsSlideshow[1],jsSlideshow[2],jsSlideshow[3],jsSlideshow[4]],function(){
    <?php endif; ?>

            jQuery(document).ready(function($) {
    	
                // set a timeout before launching the sgpro_slideshow
                window.setTimeout(function() {
                    sgpro_slideshow.slidearray = jsSlideshow;
                    sgpro_slideshow.auto = <?php echo ($this->get_option('autoslide_temp') == "Y") ? 1 : 0; ?>;	
                    sgpro_slideshow.nolink = <?php echo ($this->get_option('nolinker') == "N") ? 0 : 1; ?>;
                    sgpro_slideshow.nolinkpage = <?php echo ($this->get_option('nolinkpage') == "N") ? 0 : 1; ?>;	
                    sgpro_slideshow.pagelink="<?php echo ($this->get_option('pagelink') == "S") ? 'self' : 'blank'; ?>";
                    sgpro_slideshow.speed = <?php echo $this->get_option('autospeed'); ?>;
                    sgpro_slideshow.imgSpeed = <?php echo $this->get_option('fadespeed'); ?>;
                    sgpro_slideshow.navOpacity = <?php echo $this->get_option('navopacity'); ?>;
                    sgpro_slideshow.navHover = <?php echo $this->get_option('navhover'); ?>;
                    sgpro_slideshow.letterbox = "<?php echo $style['background'] ?>";
                    sgpro_slideshow.info = "<?php echo ($this->get_option('information_temp') == "Y") ? 'information' : ''; ?>";
                    sgpro_slideshow.infoShow = "<?php echo $this->get_option('showhover'); ?>";
                    sgpro_slideshow.infoSpeed = <?php echo $this->get_option('infospeed'); ?>;
                    //	sgpro_slideshow.transition = <?php echo $this->get_option('transition_temp'); ?>;
                    sgpro_slideshow.left = "slideleft";
                    sgpro_slideshow.wrap = "slideshow-wrapper";
                    sgpro_slideshow.widecenter = <?php echo ($this->get_option('widecenter') == "N") ? 0 : 1; ?>;
                    sgpro_slideshow.right = "slideright";
                    sgpro_slideshow.link = "linkhover";
                    sgpro_slideshow.gallery = "post-<?php echo the_ID(); ?>";
                    sgpro_slideshow.thumbs = "<?php echo ($this->get_option('thumbnails_temp') == "Y") ? 'thumbslider' : ''; ?>";
                    sgpro_slideshow.thumbOpacity = <?php echo $this->get_option('thumbopacity'); ?>;
                    sgpro_slideshow.thumbHeight = <?php echo ($styles['thumbheight'] > 0) ? $styles['thumbheight'] : "75" ?>;
                    //		sgpro_slideshow.scrollSpeed = <?php echo $this->get_option('thumbscrollspeed'); ?>;
                    sgpro_slideshow.scrollSpeed = <?php if (sizeof($slides) > 5) {
        echo $this->get_option('thumbscrollspeed');
    } else {
        echo 0;
    } ?>;
                    sgpro_slideshow.spacing = <?php echo $this->get_option('thumbspacing'); ?>;
                    sgpro_slideshow.active = "<?php echo $this->get_option('thumbactive'); ?>";
                    sgpro_slideshow.imagesbox = "<?php echo ($imgbox); ?>";	
                    jQuery("#spinner").remove();
                    sgpro_slideshow.init("sgpro_slideshow","sgpro_image","imgprev","imgnext","imglink");
                }, 1000);
                tid('slideshow-wrapper').style.visibility = 'visible';
            });
    	
    <?php if (SG2_PRO && $slidenums > 4 && $preload == "on") : ?>
            }); // preloader
    <?php endif; ?>

    </script>
<?php endif; ?>