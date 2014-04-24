<?php

/* http://www.wprecipes.com/how-to-change-the-title-attribute-of-wordpress-login-logo */
function erric_custom_login_title() {
	return 'You\'re entering Erric WP Zone';
}

add_filter( 'login_headertitle', 'erric_custom_login_title' );