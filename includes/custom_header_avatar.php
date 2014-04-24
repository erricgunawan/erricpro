<?php

// http://themeshaper.com/2014/02/15/using-custom-headers-for-avatars/

function erric_custom_header_setup() {
	add_theme_support( 'custom-header', 
		apply_filters( 'erric_custom_header_args', array( 
			'default-image' => erric_get_default_header_image()
			) 
		)
	);
}
add_action( 'after_setup_theme', 'erric_custom_header_setup' );

function erric_get_default_header_image() {

	// Get default from Discussion Settings.
	$default = get_option( 'avatar', 'mystery' ); // Mystery man default
	if ( 'mystery' == $default ) 
		$default = 'mm';
	elseif ( 'gravatar_default' == $default )
		$default = '';

	$protocol = ( is_ssl() ) ? 'https://secure.' : 'http://';
	$url = sprintf( '%1$sgravatar.com/avatar/%2$s', $protocol, md5( get_option( 'admin_email' ) ) );
	$url = add_query_arg( array(
		's' => 120,
		'd' => urlencode( $default )
	), $url);

	return esc_url_raw( $url );

} // erric_get_default_header_image