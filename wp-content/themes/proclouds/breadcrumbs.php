<?php
/*
	Wordpress Breadcrumbs code by Banhawi.com

*/

	if ( is_home() ){}

	else {

		echo "<div class=\"breadcrumbs\"><ul class=\"breadcrumbs\"> ";

		echo "<li><a href=\" ".get_settings('home')." \">";
		echo  bloginfo('name')."</a></li>";

		if ( is_category() ) {
			$cate = single_cat_title("",false);
			$cat = get_cat_ID($cate);
			echo "<li>".(get_category_parents($cat, TRUE," &raquo; "))."</li>";
		}
		elseif ( is_archive() && !is_category() ) {
			echo "<li>Archives</li>";
		}
		elseif ( is_search() ) {
			echo "<li>Search Results</li>";
		}
		elseif ( is_404() ) {
			echo "<li>404 Not Found</li>";
		}
		elseif ( is_single() ) {
			$category = get_the_category();
			$category_id = get_cat_ID($category[0]->cat_name);
			$cat_link = get_category_link( $category_id );
			echo "<li>".(get_category_parents($category, TRUE,""))."</li>";
			echo "<li><a href=\" ". $cat_link ." \">" . $category[0]->cat_name."</a></li>";
			echo "<li>";
			echo the_title()."</li>";
		}
		elseif ( is_page() ) {

			if ($post->post_parent) {

 					$children = $post->post_title;

 					$parent = get_page($post->post_parent);

 					echo "<li>".$parent->post_title."</li>"."<li>".$children."</li>";
			}
			elseif ( $post->post_parent == 0 ) {

				echo "<li>";

				echo the_title()."</li>";

			}
		}

		echo "</ul></div>";
	}
?>