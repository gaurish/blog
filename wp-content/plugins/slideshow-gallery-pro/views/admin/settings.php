<?php
global $post, $post_ID;
$post_ID = 1;
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
?>
<div class="wrap">
	<h2><?php _e('Configuration Settings', SG2_PLUGIN_NAME); ?></h2>
	
	<form action="<?php echo $this -> url; ?>" name="post" id="post" method="post">
		<div id="poststuff" class="metabox-holder has-right-sidebar">			
			<div id="side-info-column" class="inner-sidebar">		
				<?php do_action('submitpage_box'); ?>	
				<?php do_meta_boxes($this -> menus['sgpro'], 'side', $post); ?>
                <?php do_action('submitpage_box'); ?>
				<div id="submitdiv" class="postbox">
							<?php if(SG2_PRO) {?>
                	<h3>Thank you plugin supporter!</h3>
								<?php $sgprobtn = "Get Support";?>
								<?php } else { ?>
                	<h3>Slideshow Gallery Pro Premium!</h3>
								<?php $sgprobtn = "Learn More & Get it";?>
								<?php } ?>
                    <div class="inside">
                        <div id="minor-publishing">
                            <div id="#misc-publishing-actions">
                                <h4>What's different on the Premium Edition?</h4>
                                <p>Vertical images will show completely entire height</p>
                                <p>Customize your slideshow height and width per use</p>
                                <p>Have multiple custom slideshows</p>
                                <p>Have multiple arrow options</p>
								<p>And more!</p>
                            </div>
                        </div>
                        <div id="major-publishing-actions">
                            <div id="publishing-action">
                                <a href="http://c-pr.es/projects/satellite/" class="button-primary" target="_blank"><?php echo($sgprobtn); ?></a>
                            </div>
                            <br class="clear" />
                        </div>
                    </div>
                </div>
           
			</div>
			<div id="post-body">
				<div id="post-body-content">
					<?php do_meta_boxes($this -> menus['sgpro'], 'normal', $post); ?>
				</div>
			</div>
			<div id="side-info-column" class="inner-sidebar" style="margin-top:450px">		
				<?php do_meta_boxes($this -> menus['sgpro'], 'side', $post); ?>
                <?php do_action('submitpage_box'); ?>
			</div>
			<br class="clear" />
			
		</div>
	</form>
</div>