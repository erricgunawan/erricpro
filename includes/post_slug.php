<?php

// http://www.wprecipes.com/wordpress-function-to-get-postpage-slug

/* alt 1
function the_slug() {
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug; 
} */
// use: echo the_slug();


/* alt 2 */
function get_the_slug() {
	global $post;
	return $post->post_name;
}

function the_slug() {
	echo get_the_slug();
}