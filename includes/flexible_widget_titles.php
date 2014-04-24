<?php

// http://premium.wpmudev.org/blog/how-to-prevent-widget-titles-appearing-on-your-wordpress-site/

function erric_flexible_widget_titles( $widget_title ) {

	// get rid of any leading and trailing spaces
	$title = trim( $widget_title );

	// check the first and last character, if [ and ] set the title to empty
	if ( ( '' != $widget_title ) && ( $title[0] == '[' && $title[strlen($title) - 1] == ']' ) )
		$title = '';

	return $title;

}

add_filter( 'widget_title', 'erric_flexible_widget_titles' );