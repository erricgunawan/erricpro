<?php

// http://www.wpbeginner.com/wp-tutorials/how-to-add-search-form-in-your-post-with-a-wordpress-search-shortcode/


// default search form
//add_shortcode('erricsearch', 'get_search_form');


// custom search form
add_shortcode('erricsearch', 'erric_search_form');
function erric_search_form($form) {

	$form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" >
    <div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="' . esc_attr__('Search') . '" />
    </div>
    </form>';

	return $form;
}