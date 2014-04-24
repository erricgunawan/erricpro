<?php

// http://www.wpbeginner.com/wp-tutorials/how-to-display-a-list-of-last-updated-posts-in-wordpress/

function erric_lastupdated_posts() {

	// Query Arguments
	$lastupdated_args = array(
		'orderby' => 'modified',
		'ignore_sticky_posts' => 1,
		'posts_per_page' => 5
	);

	// Loop to display 5 recently updated posts
	$lastupdated_loop = new WP_Query( $lastupdated_args );
	// $counter = 1;

	// echo '<pre>';
	// var_dump($lastupdated_loop);
	// echo '</pre>';

	echo '<ul>';

	while( $lastupdated_loop->have_posts() ) : //&& $counter < 5 ) :

		$lastupdated_loop->the_post();

		echo '<li><a href="' . get_permalink( $lastupdated_loop->post->ID ) . '">' . 
			get_the_title( $lastupdated_loop->post->ID ) . '</a> (' . get_the_modified_date() . ')</li>';

		// echo $counter;
		// $counter++;

	endwhile;

	echo '</ul>';

	wp_reset_postdata();

}


// add a shortcode
add_shortcode( 'lastupdated-posts', 'erric_lastupdated_posts' );

