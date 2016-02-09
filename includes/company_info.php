<?php
// http://premium.wpmudev.org/blog/company-info-global-variables/

/*===================================================================================
* Add global options
* =================================================================================*/

/**
 *
 * The page content surrounding the settings fields. Usually you use this to instruct non-techy people what to do.
 *
 */
function erric_theme_settings_page() {
	?>
	<div class="wrap">
		<h1><?php _e( 'Contact Info', 'erric' ); ?></h1>
		<p><?php _e( 'This information is used around the website, so changing these here will update them across the website.', 'erric' ); ?></p>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'section' );
			do_settings_sections( 'theme-options' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 *
 * Next comes the settings fields to display. Use anything from inputs and textareas, to checkboxes multi-selects.
 *
 */

// Phone
function erric_display_phone_element() {
	?>
	<input type="tel" name="support_phone" placeholder="<?php _e( 'Enter phone number', 'erric' ); ?>" value="<?php echo esc_attr( get_option( 'support_phone' ) ); ?>" size="35">
	<?php
}

//Fax
function erric_display_fax_element() {
	?>
	<input type="tel" name="support_fax" placeholder="<?php _e( 'Enter fax number', 'erric' ); ?>" value="<?php echo esc_attr( get_option( 'support_fax' ) ); ?>" size="35">
	<?php
}

// Email
function erric_display_email_element() {
	?>
	<input type="email" name="support_email" placeholder="<?php _e( 'Enter email address', 'erric' ); ?>" value="<?php echo esc_attr( get_option( 'support_email' ) ); ?>" size="35">
	<?php
}

/**
 *
 * Here you tell WP what to enqueue into the <form> area. You need:
 *
 * 1. add_settings_section
 * 2. add_settings_field
 * 3. register_setting
 *
 */
function erric_display_custom_info_fields() {

	add_settings_section( 'section', __( 'Company Information', 'erric' ), null, 'theme-options' );

	add_settings_field( 'support_phone', __( 'Support Phone No.', 'erric' ), 'erric_display_phone_element', 'theme-options', 'section' );
	add_settings_field( 'support_fax', __( 'Support Fax No.', 'erric' ), 'erric_display_fax_element', 'theme-options', 'section' );
	add_settings_field( 'support_email', __( 'Support Email Address', 'erric' ), 'erric_display_email_element', 'theme-options', 'section' );

	register_setting( 'section', 'support_phone' );
	register_setting( 'section', 'support_fax' );
	register_setting( 'section', 'support_email' );
}
add_action( 'admin_init', 'erric_display_custom_info_fields' );

/**
 *
 * Tie it all together by adding the settings page to wherever you like. For this example it will appear
 * in Settings > Contact Info
 *
 */
function erric_add_custom_info_menu_item() {
	add_options_page( __( 'Company Info', 'erric' ), __( 'Contact Info', 'erric' ), 'manage_options', 'contact-info', 'erric_theme_settings_page' );
}
add_action( 'admin_menu', 'erric_add_custom_info_menu_item' );




/* ==== Contact Information ==== */

/**
 * 1. First we can check if the support phone number is filled out.
 * 2. If it is, let's show the phone number, otherwise we'll show a slightly famous message :).
 * 3. Hit the pub to celebrate!
 */
function erric_display_company_info() {
	if ( get_option( 'support_phone' ) ) {
		// phone number found, show the phone number as a link.
		?>
		<p><?php _e( 'Need support? Get us on ', 'erric' ); ?><a href="tel:<?php echo esc_attr( get_option( 'support_phone' ) ); ?>"><?php echo esc_html( get_option( 'support_phone' ) ); ?></a></p>
		<?php
	} else {
		// No phone number found, show fun message.
		?>
		<p><?php _e( 'Support silence is golden.', 'erric' ); ?></p>
		<?php
	}
	?>
	<hr />
	<?php 
}
add_action( 'twentysixteen_credits', 'erric_display_company_info' );

/* ==== Contact Information ==== */