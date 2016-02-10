<?php
// https://www.smashingmagazine.com/2015/12/how-to-use-term-meta-data-in-wordpress/

add_action( 'init', 'erric_register_feature_taxonomy' );

function erric_register_feature_taxonomy() {
	$labels = array(
		'name'                  => _x( 'Features', 'taxonomy general name', 'erric' ),
		'singular_name'         => _x('Features', 'taxonomy singular name', 'erric'),
		'search_items'          => __('Search Feature', 'erric'),
		'popular_items'         => __('Common Features', 'erric'),
		'all_items'             => __('All Features', 'erric'),
		'edit_item'             => __('Edit Feature', 'erric'),
		'update_item'           => __('Update Feature', 'erric'),
		'add_new_item'          => __('Add new Feature', 'erric'),
		'new_item_name'         => __('New Feature:', 'erric'),
		'add_or_remove_items'   => __('Remove Feature', 'erric'),
		'choose_from_most_used' => __('Choose from common Feature', 'erric'),
		'not_found'             => __('No Feature found.', 'erric'),
		'menu_name'             => __('Features', 'erric'),
	);

	$args = array(
		'hierarchical' => false,
		'labels'       => $labels,
		'show_ui'      => true
	);

	register_taxonomy( 'post_feature', array( 'post' ), $args );
}


global $feature_groups;
$feature_groups = array(
	'bedroom' => __( 'Bedroom', 'erric' ),
	'living'  => __( 'Living room', 'erric' ),
	'kitchen' => __( 'Kitchen', 'erric' )
);

add_action( 'post_feature_add_form_fields', 'erric_add_feature_group_field', 10, 2 );
function erric_add_feature_group_field( $taxonomy ) {
	global $feature_groups;
	?>
	<div class="form-field term-group">
		<label for="feature-group"><?php _e( 'Feature Group', 'erric' ); ?></label>
		<select class="postform" name="feature-group" id="equipment-group">
			<option value="-1"><?php _e( 'none', 'erric' ); ?></option>
			<?php foreach ( $feature_groups as $group_key => $group ) : ?>
				<option value="<?php echo esc_attr( $group_key ); ?>"><?php echo $group; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<?php
}

add_action( 'created_post_feature', 'erric_save_feature_meta', 10, 2 );
function erric_save_feature_meta( $term_id, $tt_id ) {
	if ( isset( $_POST['feature-group'] ) && '' !== $_POST['feature-group'] ) {
		$group = sanitize_title( $_POST['feature-group'] );
		add_term_meta( $term_id, 'feature-group', $group, true );
	}
}

add_action( 'post_feature_edit_form_fields', 'erric_edit_feature_group_field', 10, 2 );
function erric_edit_feature_group_field( $term, $taxonomy ) {
	global $feature_groups;

	// get current group
	$feature_group = get_term_meta( $term->term_id, 'feature-group', true );
	?>
	<tr class="form-field term-group-wrap">
		<th scope="row"><label for="feature-group"><?php _e( 'Feature Group', 'erric' ); ?></label></th>
		<td>
			<select class="postform" name="feature-group" id="equipment-group">
				<option value="-1"><?php _e( 'none', 'erric' ); ?></option>
				<?php foreach ( $feature_groups as $group_key => $group ) : ?>
					<option value="<?php echo esc_attr( $group_key ); ?>" <?php selected( $feature_group, $group_key ); ?>><?php echo $group; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<?php
}

add_action( 'edited_post_feature', 'erric_update_feature_meta', 10, 2 );
function erric_update_feature_meta( $term_id, $tt_id ) {
	if ( isset( $_POST['feature-group'] ) && '' !== $_POST['feature-group'] ) {
		$group = sanitize_title( $_POST['feature-group'] );
		update_term_meta( $term_id, 'feature-group', $group );
	}
}


add_filter( 'manage_edit-post_feature_columns', 'erric_add_feature_group_column' );
function erric_add_feature_group_column( $columns ) {
	$columns['feature_group'] = __( 'Group', 'erric' );
	return $columns;
}

add_filter( 'manage_post_feature_custom_column', 'erric_add_feature_group_column_content', 10, 3 );
function erric_add_feature_group_column_content( $content, $column_name, $term_id ) {
	global $feature_groups;

	if ( 'feature_group' !== $column_name )
		return $content;

	$term_id = absint( $term_id );
	$feature_group = get_term_meta( $term_id, 'feature-group', true );

	if ( ! empty( $feature_group ) ) {
		$content .= esc_attr( $feature_groups[ $feature_group ] );
	}

	return $content;
}

add_filter( 'manage_edit-post_feature_sortable_columns', 'erric_add_feature_group_column_sortable' );
function erric_add_feature_group_column_sortable( $sortable ) {
	$sortable['feature_group'] = 'feature_group';
	return $sortable;
}



add_action( 'twentysixteen_credits', 'erric_display_post_features' );
function erric_display_post_features() {
	$args = array(
		'hide_empty' => false, // also retrieve terms which are not used yet
		'meta_query' => array(
			array(
				'key'     => 'feature-group',
				'value'   => 'kitchen',
				'compare' => 'NOT LIKE' // 'LIKE'
			)
		)
	);
	$terms = get_terms( 'post_feature', $args );

	if ( ! empty ( $terms ) && ! is_wp_error( $terms ) ) {
		echo '<ul>';
		foreach ( $terms as $term ) {
			echo '<li>' . $term->name . ' (' . get_term_meta( $term->term_id, 'feature-group', true ) . ')</li>';
		}
		echo '</ul>';
	}
}