<?php

// http://www.wpbeginner.com/wp-tutorials/how-to-add-jquery-tabber-widget-in-wordpress/

class ErricTabberWidget extends WP_Widget {

	function ErricTabberWidget() {
		$widget_ops = array(
			'classname' => 'ErricTabberWidget',
			'description' => __( 'Simple jQuery Tabber Widget', 'erric_widget_domain' )
			);

		$this->WP_Widget( 'ErricTabberWidget', __( 'Erric Tabber Widget', 'erric_widget_domain' ), $widget_ops );
	}

	function widget( $args, $instance ) {

		function erric_tabber() {

			// Now we enqueue our stylesheet and jQuery script
			wp_register_style( 'erric-tabber-style', ERRIC_PLUGIN_URL . '/css/tabber_widget.css' );
			wp_enqueue_style( 'erric-tabber-style' );
			wp_register_script( 'erric-tabber-widget-js', ERRIC_PLUGIN_URL . '/js/tabber_widget.js', array( 'jquery' ) );
			wp_enqueue_script( 'erric-tabber-widget-js' );

			// Creating tabs you will be adding your own code inside each tab
		?>

			<ul class="tabs">
				<li class="active"><a href="#tab1">Tab 1</a></li>
				<li><a href="#tab2">Tab 2</a></li>
				<li><a href="#tab3">Tab 3</a></li>
			</ul>

			<div class="tab_container">
				
				<div id="tab1" class="tab_content">
					<ul>
						<?php wp_list_pages( 'title_li=' ); ?>
					</ul>
				</div>

				<div id="tab2" class="tab_content" style="display:none">
					<ul>
						<?php $posts = get_posts( 'orderby=rand&numberposts=5' );
						// echo '<pre>' . var_dump($posts) . '</pre>';
						foreach ( $posts as $post ) : ?>
							<li><a href="<?php echo get_permalink( $post->ID ); ?>" title="<?php echo $post->post_title; ?>"><?php echo $post->post_title; ?></a></li>	
						<?php endforeach; ?>
					</ul>
				</div>

				<div id="tab3" class="tab_content" style="display:none">
					<?php 
					$args = array(
						'status' => 'approve',
						'number' => 5
					);
					$comments = get_comments( $args );
					// var_dump($comments);
					foreach ( $comments as $comment ) {
						echo $comment->comment_author . '<br />' . $comment->comment_content . '<br /><br />';
					}
					?>
				</div>

			</div>

			<div class="tab-clear"></div>


		<?php
		} // erric_tabber()

		extract( $args, EXTR_SKIP );
		// pre-widget code from theme
		echo $before_widget;
		$tabs = erric_tabber();
		// output tabs HTML
		echo $tabs;
		// post-widget code from theme
		echo $after_widget;

	} // widget()

} // class ErricTabberWidget

// registering and loading widget
add_action( 'widgets_init', create_function( '', 'return register_widget("ErricTabberWidget");' ) );