<?php
// http://themehybrid.com/weblog/introduction-to-wordpress-term-meta

add_action( 'init', 'erric_register_meta' );
function erric_register_meta() {
	register_meta( 'term', 'color', 'erric_sanitize_hex' );
}

function erric_sanitize_hex( $color ) {
	$color = ltrim( $color, '#' );
	return preg_match( '/([A-Fa-f0-9]{3}){1,2}$/', $color ) ? $color : '';
}

function erric_get_term_color( $term_id, $hash = false ) {
	$color = get_term_meta( $term_id, 'color', true );
	$color = erric_sanitize_hex( $color );

	return $hash && $color ? "#{$color}" : $color;
}

add_action( 'category_add_form_fields', 'erric_new_term_color_field' );
function erric_new_term_color_field() {

	wp_nonce_field( basename( __FILE__ ), 'erric_term_color_nonce' ); ?>
	
	<div class="form-field erric-term-color-wrap">
		<label for="erric-term-color"><?php _e( 'Color', 'erric' ); ?></label>
		<input type="text" name="erric_term_color" id="erric-term-color" value="" class="erric-color-field" data-default-color="#ffffff" />
	</div>
	<?php
}

add_action( 'category_edit_form_fields', 'erric_edit_term_color_field' );
function erric_edit_term_color_field( $term ) {

	$default = '#ffffff';
	$color = erric_get_term_color( $term->term_id, true );

	if ( ! $color )
		$color = $default;

	?>
	<tr class="form-field erric-term-color-wrap">
		<th scope="row"><label for="erric-term-color"><?php _e( 'Coloring', 'erric' ); ?></label></th>
		<td>
			<?php wp_nonce_field( basename( __FILE__ ), 'erric_term_color_nonce' ); ?>
			<input type="text" name="erric_term_color" id="erric-term-color" value="<?php echo esc_attr( $color ); ?>" class="erric-color-field" data-default-color="<?php echo esc_attr( $default ); ?>" />
		</td>
	</tr>
	<?php
}

add_action( 'edit_category', 'erric_save_term_color' );
add_action( 'create_category', 'erric_save_term_color' );

function erric_save_term_color( $term_id ) {
	if ( ! isset( $_POST['erric_term_color_nonce'] ) || ! wp_verify_nonce( $_POST['erric_term_color_nonce'], basename( __FILE__ ) ) )
		return;

	$old_color = erric_get_term_color( $term_id );
	$new_color = isset( $_POST['erric_term_color'] ) ? erric_sanitize_hex( $_POST['erric_term_color']) : '';

	if ( $old_color && '' === $new_color )
		delete_term_meta( $term_id, 'color' );

	else if ( $old_color != $new_color )
		update_term_meta( $term_id, 'color', $new_color );
}


add_filter( 'manage_edit-category_columns', 'erric_edit_term_columns' );
function erric_edit_term_columns( $columns ) {
	$columns['color'] = __( 'Color', 'erric' );
	return $columns;
}

add_filter( 'manage_category_custom_column', 'erric_manage_term_custom_column', 10, 3 );
function erric_manage_term_custom_column( $out, $column, $term_id ) {

	if ( 'color' === $column ) {
		$color = erric_get_term_color( $term_id, true );

		if ( ! $color )
			$color = '#ffffff';
		
		$out = sprintf( '<span class="color-block" style="background:%s">&nbsp;</span>', esc_attr( $color ) );
	}

	return $out;
}

add_action( 'admin_enqueue_scripts', 'erric_admin_enqueue_scripts' );
function erric_admin_enqueue_scripts( $hook_suffix ) {

	if ( 'edit-tags.php' !== $hook_suffix || 'category' !== get_current_screen()->taxonomy )
		return;
	
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );

	add_action( 'admin_head', 'erric_term_colors_print_styles' );
	add_action( 'admin_footer', 'erric_term_colors_print_scripts' );
}

function erric_term_colors_print_styles() {
	?>
	<style type="text/css">
		.column-color { width: 50px; }
		.column-color .color-block { display: inline-block; width: 28px; height: 28px; border: 1px solid #ddd; }
	</style>
	<?php
}

function erric_term_colors_print_scripts() {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('.erric-color-field').wpColorPicker();
		});
	</script>
	<?php
}