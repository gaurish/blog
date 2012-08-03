<?php get_header(); ?>
	
	<!-- posts -->
	<div id="posts_contain">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>


			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">



				<div class="post_header">
					<div class="post_header_header"></div>
					<div class="post_header_contain">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<div class="post_info">
						<small><?php edit_post_link('(Edit)', '', ' - '); ?><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --> Posted in <?php the_category(', ') ?></small>
						<div class="post_comment_count"><?php comments_popup_link('<span class="nocomments">No Comments</span>', '<span class="comment_ico"></span> 1 Comment &#187;', '<span class="comment_ico"></span> % Comments &#187;'); ?></div>
					</div>
					</div>
				</div><!-- End post_header -->
<!-- Start Adsense Block -->
<script type="text/javascript"><!--
google_ad_client = "ca-pub-8985332373283902";
/* 336x280, created 3/16/09 */
google_ad_slot = "7247748131";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<!-- End adsense block -->

				
				<div class="post_content">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
					<?php wp_link_pages(array('before' => '<div class="post_page_selection"><strong>Pages:</strong> ', 'after' => '</div>','pagelink' => '&nbsp;%&nbsp;', 'next_or_number' => 'number')); ?>
				</div> <!-- end post_content -->

				
				<div class="post_footer">
				<?php the_tags('<div class="post_tags_single"><div class="tags_icon"></div>', ', ', '</div>'); ?>


				<?php if($single) { ?>
				<div class="nextprev">

				<span class="prev">
				<span class="what">Previous Post</span><?php previous_post_link(); ?> </span>

				<span class="next">
				<span class="what">Next Post</span><?php next_post_link(); ?></span>

				</div>
				<?php } ?>

				</div><!-- end post_footer -->


			</div> <!-- end class entry -->

			<?php comments_template(); ?>


		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('<span>Older Entries</span>') ?></div>
			<div class="alignright"><?php previous_posts_link('<span>Newer Entries</span>') ?></div>
		</div>

		<?php else : ?>
			<h2 class="center">Not Found</h2>
			<p class="center">Sorry, but you are looking for something that isn't here.</p>
			<?php get_search_form(); ?>
		<?php endif; ?>

	</div><!-- end posts_contain -->


</div><!-- end left_col -->








<div id="right_col">
	
	<?php get_sidebar(); ?>
	

</div><!-- end right_col -->

 <!-- end main_center -->

<?php get_footer(); ?>

</div>


</body>
</html>