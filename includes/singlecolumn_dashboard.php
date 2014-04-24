<?php

// http://www.wprecipes.com/how-to-bring-back-single-column-dashboard-in-wordpress-3-8

// force one-column dashboard
function shapeSpace_screen_layout_columns( $columns ) {
	$columns['dashboard'] = 1;
	return $columns;
}
add_filter( 'screen_layout_columns', 'shapeSpace_screen_layout_columns' );

function shapeSpace_screen_layout_dashboard() { return 1; }
add_filter( 'get_user_option_screen_layout_dashboard', 'shapeSpace_screen_layout_dashboard' );
