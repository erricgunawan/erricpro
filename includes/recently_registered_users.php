<?php

// http://www.wpbeginner.com/wp-tutorials/how-to-display-recently-registered-users-in-wordpress/

function erric_recently_registered_users() {

	global $wpdb;

	$recentusers = "<ul class='recently-user'>";

	$usernames = $wpdb->get_results( "SELECT user_nicename, user_url, user_email FROM $wpdb->users ORDER BY ID DESC LIMIT 5");

	foreach ($usernames as $username) {

		if ( ! $username->user_url ) {
			$recentusers .= '<li>' . get_avatar( $username->user_email, 45 ) . $username->user_nicename . '</li>';
		} else {
			$recentusers .= '<li>' . get_avatar( $username->user_email, 45 ) . 
			'<a href="' . $username->user_url . '">' . $username->user_nicename . '</a></li>';
		}
	}

	$recentusers .= '</ul>';

	echo $recentusers;

}


add_shortcode( 'erric_newusers', 'erric_recently_registered_users' );