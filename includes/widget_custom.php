<?php 

// http://www.wpbeginner.com/wp-tutorials/how-to-create-a-custom-wordpress-widget/

/**
* Creating the widget 
*/
class Erric_Widget extends WP_Widget {
	
	function __construct() {
		
		parent::__construct(
			// Base ID of your widget
			'erric_widget',

			// Widget name will appear in UI
			__( 'Erric Widget', 'erric_widget_domain' ),

			// Widget description
			array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'erric_widget_domain' ) )

			);

	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) 
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		echo __( 'Halo Dunia!', 'erric_widget_domain' );
		echo $args['after_widget'];

	}

	// Widget Backend 
	public function form( $instance ) {

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Ini Judulnya', 'erric_widget_domain' );
		}

		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'erric_widget_domain' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '' );

		return $instance;

	}

} // Class Erric_Widget ends here

// Register and load the widget
function erric_load_widget() {
	register_widget( 'erric_widget' );
}

add_action( 'widgets_init', 'erric_load_widget' );