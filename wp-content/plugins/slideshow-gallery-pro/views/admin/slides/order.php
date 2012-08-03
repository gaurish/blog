<div class="wrap"> 
	<h2><?php _e('Order Slides', SG2_PLUGIN_NAME); ?></h2>
	<div style="float:none;" class="subsubsub">
		<a href="<?php echo $this -> url; ?>"><?php _e('&larr; Manage All Slides', SG2_PLUGIN_NAME); ?></a>
	</div>
	<?php if (!empty($slides)) : ?>
	<?php $slidenum = $this->get_option('custslide'); ?>
	<?php foreach ($slides as $slide) : 
		for ($i=1;$i <= $slidenum; $i++) {
			if ($slide -> section == $i)
				$slide_array[$i][] = $slide;
		}
		endforeach;
	
		for ($i=1;$i <= $slidenum; $i++) {
		if (is_array($slide_array[$i])) {
		echo "Custom Slideshow ".$i;
		?>
		<ul id="slidelist<?php echo $i;?>">
			<?php foreach ($slide_array[$i] as $slide) : ?>
				<li class="lineitem" id="item_<?php echo $slide -> id; ?>">
					<span style="float:left; margin:5px 10px 0 5px;"><img src="<?php echo $this -> Html -> image_url($this -> Html -> thumbname($slide -> image, "small")); ?>" alt="<?php echo $this -> Html -> sanitize($slide -> title); ?>" /></span>
					<h4><?php echo $slide -> title; ?></h4>
					<hr class="clear" style="clear:both; visibility:hidden; height:1px; display:block;" />
				</li>
			<?php endforeach; ?>
		</ul>
		<div id="slidemessage<?php echo $i;?>"></div>
		
		<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("ul#slidelist<?php echo $i;?>").sortable({
				start: function(request) {
					jQuery("#slidemessage<?php echo $i;?>").slideUp();
				},
				stop: function(request) {
					jQuery("#slidemessage<?php echo $i;?>").load(SGProAjax + "?cmd=slides_order", jQuery("ul#slidelist<?php echo $i;?>").sortable('serialize')).slideDown("slow");
				},
				axis: "y"
			});
		});
		</script>
		<?php }} ?>
		
		<style type="text/css">
		li.lineitem {
			list-style: none;
			margin: 3px 135px !important;
			padding: 2px 5px 2px 5px;
			background-color: #F1F1F1 !important;
			border:1px solid #B2B2B2;
			cursor: move;
			vertical-align: middle !important;
			display: block;
			clear: both;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			width:300px;
		}
		</style>
	<?php else : ?>
		<p style="color:red;"><?php _e('No slides found', SG2_PLUGIN_NAME); ?></p>
	<?php endif; ?>
</div>