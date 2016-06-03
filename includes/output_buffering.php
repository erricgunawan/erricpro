<?php
// http://wpshout.com/understanding-php-output-buffering-and-why-its-great-for-shortcodes/

add_shortcode( 'erric_fake_shortcode', 'erric_fake_shortcode_function' );

function erric_fake_shortcode_function() {
	ob_start();
	echo '<hr />';
	echo 'REPLACED THAT SHORTCODE!!';
	include 'output_buffering_template.php';
	return ob_get_clean();
}