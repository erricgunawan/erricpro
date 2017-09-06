<?php
// https://tomjn.com/2017/01/23/writing-wp-rest-api-endpoint-2-minutes/

function erric_rest_test() {
	return 'crispy me';
}

add_action( 'rest_api_init', function() {
	register_rest_route( 'erric/v1', '/test/', array(
		'methods' => GET,
		'callback' => 'erric_rest_test'
	) );
} );

/**
 * put in index.php
 *

	<div id="erricword">... take my word ...</div>

	<script type="text/javascript">
		jQuery.ajax({
		  url: <?php echo wp_json_encode( esc_url_raw( rest_url( 'erric/v1/test/') ) ); ?>
		}).done(function( data ) {
			jQuery( '#erricword' ).text( data );
		});
	</script>

 */