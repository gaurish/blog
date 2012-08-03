
<?php
if (!empty($slides)) :
    ?>
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
                        /*jsSlideshow.push("<?php echo($full_image_href2[0]); ?>");*/
            <?php
            $slidenums += 1;
        endforeach;
    else:
        foreach ($slides as $single):
            ?>
                        /*jsSlideshow.push("<?php echo SG2_UPLOAD_URL ?>/<?php echo $single->image; ?>");*/
            <?php
            $slidenums += 1;
        endforeach;
    endif;

    /*     * *** END ARRAY OF IMAGES *** */
    ?>
    </script>
    <?php
    $style = $this->get_option('styles');
    $imagesbox = $this->get_option('imagesbox');
    if ($this->get_option('autoslide') == "Y") {
        $autospeed = $this->get_option('autospeed');
        $autospeed2 = $this->get_option('autospeed2');
    }
    if ($this->get_option('transition_temp') == "OF") { // fade, horizontal-slide, vertical-slide, horizontal-push
        $transition = "fade";
    } elseif ($this->get_option('transition_temp') == "OHS") {
        $transition = "horizontal-slide";
    } elseif ($this->get_option('transition_temp') == "OVS") {
        $transition = "vertical-slide";
    } elseif ($this->get_option('transition_temp') == "OHP") {
        $transition = "horizontal-push";
    }
    ?>

    <?php if ($frompost) : ?>
        <!-- =======================================
        THE ORBIT SLIDER CONTENT 
        ======================================= -->
        <div>
            <div id="featured"> 
                <?php foreach ($slides as $slider) : ?>  
                    <?php $full_image_href = wp_get_attachment_image_src($slider->ID, 'full', false); ?>

                    <?php
                    if (SG2_PRO) {
                        require SG2_PLUGIN_DIR . '/pro/image_tall_frompost_orbit.php';
                    } else {
                        echo "<div class='sorbit-basic' data-caption='#post<?php echo $slider->ID; ?>'>";
                    }
                    ?>
                    <?PHP if ($imagesbox == ("T" || "S" || "P")) { ?>
                        <a class="thickbox" href="<?php echo $full_image_href[0]; ?>" rel="" title="<?php echo $slider->post_title; ?>">
                    <?PHP } ?>
                        <img src="<?php echo $full_image_href[0]; ?>" 
                             alt="<?php echo $imagesbox . $slider->post_title; ?>" />
                        <?PHP if ($imagesbox == ("T" || "S" || "P")) { ?></a><?PHP } ?>
                </div>
                <span class="orbit-caption" id="post<?php echo $slider->ID; ?>">
                    <h1><?php echo $slider->post_title; ?></h1>
                </span>
            <?php endforeach;  ?>

        </div>
        <!-- Captions for Orbit -->
        <!--span class="sorbit-caption" id="htmlCaption"><strong>I'm A Badass Caption:</strong> I can haz <a href="#">links</a>, <em>style</em> or anything that is valid markup :)</span-->
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#featured').orbit({
                    animation: '<?PHP echo ($transition) ? $transition : $this->get_option('transition'); ?>',                  // fade, horizontal-slide, vertical-slide, horizontal-push
                    animationSpeed: <?php echo($this->get_option('duration')); ?>,                // how fast animations are
                    timer: <?PHP echo ($autospeed2) ? 'true' : 'false'; ?>, 			 // true or false to have the timer
                    advanceSpeed: <?PHP echo ($autospeed2); ?>, 		 // if timer is enabled, time between transitions 
                    pauseOnHover: false, 		 // if you hover pauses the slider
                    startClockOnMouseOut: false, 	 // if clock should start on MouseOut
                    startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
                    directionalNav: true, 		 // manual advancing directional navs
                    captions: <?php echo($this->get_option('orbitinfo') == 'Y') ? 'true' : 'false'; ?>,	 // do you want captions?
                    captionAnimation: 'slideOpen', 		 // fade, slideOpen, none
                    captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
                    bullets: <?php echo($this->get_option('othumbs') == 'B') ? 'true' : 'false'; ?>,		// true or false to activate the bullet navigation
                    bulletThumbs: true,		 // thumbnails for the bullets
                    bulletThumbLocation: '',		 // location from this file where thumbs will be
                    afterSlideChange: function(){},    // empty function 
                    centerBullets: <?php echo $this->get_option('bullcenter'); ?>                    
                });				
            });            
        </script> 
    <?php else : ?>
        <div>
            <div id="featured"> 
                <?php $i = 0; ?>
                <?php foreach ($slides as $slider) : ?>     
                    <?php
                    if (SG2_PRO) {
                        require SG2_PLUGIN_DIR . '/pro/image_tall_custom_orbit.php';
                    } else {
                        echo "<div class='sorbit-basic' data-caption='custom<?php echo $i; ?>'>";
                    }
                    ?>						
                    <?php if ($slider->uselink == "Y" && !empty($slider->link)) : ?>
                        <a href="<?php echo $slider->link; ?>" title="<?php echo $slider->title; ?>">

                        <?PHP elseif ($imagesbox == ("T" || "S" || "P")) : ?>
                            <a class="thickbox" href="<?php echo $this->Html->image_url($slider->image); ?>" rel="" title="<?php echo $slider->title; ?>">
                            <?PHP endif; ?>
                            <img src="<?php echo $this->Html->image_url($slider->image); ?>" alt="<?php echo $slider->description; ?>" />
                            <?PHP if ($imagesbox == ("T" || "S" || "P") || $slider->uselink == "Y") : ?></a><?PHP endif; ?>
                </div>
                <span class="orbit-caption" id="custom<?php echo $i; ?>">
                    <h1><?php echo $slider->title; ?></h1>
                    <h3><?php echo $slider->description; ?></h3>
                </span>       
                <?php $i = $i +1; ?>
            <?php endforeach; ?>
        </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#featured').orbit({
                    animation: '<?PHP echo ($transition) ? $transition : $this->get_option('transition'); ?>',                  // fade, horizontal-slide, vertical-slide, horizontal-push
                    animationSpeed: <?php echo($this->get_option('duration')); ?>,                // how fast animations are
                    timer: <?PHP echo ($autospeed2) ? 'true' : 'false'; ?>, 			 // true or false to have the timer
                    advanceSpeed: <?PHP echo ($autospeed2); ?>, 		 // if timer is enabled, time between transitions 
                    pauseOnHover: false, 		 // if you hover pauses the slider
                    startClockOnMouseOut: false, 	 // if clock should start on MouseOut
                    startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
                    directionalNav: true, 		 // manual advancing directional navs
                    captions: <?php echo($this->get_option('orbitinfo') == 'Y') ? 'true' : 'false'; ?>,	 // do you want captions?
                    captionAnimation: 'slideOpen', 		 // fade, slideOpen, none
                    captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
                    bullets: <?php echo($this->get_option('othumbs') == 'B') ? 'true' : 'false'; ?>,		// true or false to activate the bullet navigation
                    bulletThumbs: true,		 // thumbnails for the bullets
                    bulletThumbLocation: '',		 // location from this file where thumbs will be
                    afterSlideChange: function(){},    // empty function 
                    centerBullets: <?php echo $this->get_option('bullcenter'); ?>                    
                });				
            });            
        </script> 
    <?php endif; ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery(window).keyup(function (event) {
                if (event.keyCode == 37) {
                    jQuery('#iprev').click();
                }
                if (event.keyCode == 39) {
                    jQuery('#inext').click();
                }
            });
        });
    </script>
    <!--<img style="height:75px;" src="<?php echo $this->Html->image_url($this->Html->thumbname(basename($slide->image_url))); ?>" alt="<?php echo $this->Html->sanitize($slide->title); ?>" />-->
<?php endif; ?>