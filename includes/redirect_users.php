<?php

// http://wp.tutsplus.com/tutorials/creative-coding/redirect-users-to-custom-pages-by-role/

function erric_redirect_users_by_role() {

	if ( ! defined( 'DOING_AJAX' ) ) {

		$current_user = wp_get_current_user();
		$role_name = $current_user->roles[0];

		if ( 'subscriber' === $role_name ) {
			wp_redirect( 'http://localhost/wppro/sample-page' );
		} // if $role_name

	} // if DOING_AJAX

}
add_action( 'admin_init', 'erric_redirect_users_by_role' );
