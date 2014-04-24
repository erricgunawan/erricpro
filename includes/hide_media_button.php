<?php

// http://premium.wpmudev.org/blog/hide-wordpress-media-uploader-button/

function remove_media_buttons() {
	if ( ! current_user_can( 'level_7' ) ) {
		remove_action( 'media_buttons', 'media_buttons' );
	}
}
add_action( 'admin_head', 'remove_media_buttons' );
