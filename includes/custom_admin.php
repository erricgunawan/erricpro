<?php

// Customizing the WordPress Admin: The Login Screen
// http://wp.tutsplus.com/tutorials/creative-coding/customizing-the-wordpress-admin-the-login-screen/


// add a new logo to the login page
function erric_login_logo() { ?>
	<style type="text/css">
		.login #login h1 a {
			background-image: url( <?php echo 'http://placekitten.com/300/70'; ?> );
			background-size: 300px auto;
			height: 70px;
		}
		.login #nav a, .login #backtoblog a {
			color: #27adab !important;
		}
		.login #nav a:hover, .login #backtoblog a:hover {
			color: #d228bc !important;
		}
		.login .button-primary {
			background: #27adab; /* Old browsers */
            background: -moz-linear-gradient(top, #27adab 0%, #135655 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#27adab), color-stop(100%,#135655)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, #27adab 0%,#135655 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, #27adab 0%,#135655 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top, #27adab 0%,#135655 100%); /* IE10+ */
            background: linear-gradient(to bottom, #27adab 0%,#135655 100%); /* W3C */
		}
		.login .button-primary:hover {
			background: #85aaaa; /* Old browsers */
            background: -moz-linear-gradient(top, #85aaaa 0%, #208e8c 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#85aaaa), color-stop(100%,#208e8c)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, #85aaaa 0%,#208e8c 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, #85aaaa 0%,#208e8c 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top, #85aaaa 0%,#208e8c 100%); /* IE10+ */
            background: linear-gradient(to bottom, #85aaaa 0%,#208e8c 100%); /* W3C */
		}
	</style>
	<?php
}


add_action( 'login_enqueue_scripts', 'erric_login_logo' );



/********************************************************************************/



// Customizing the WordPress Admin – The Dashboard
// http://wp.tutsplus.com/tutorials/creative-coding/customizing-the-wordpress-admin-the-dashboard/


// remove unwanted dashboard widgets for relevant users
function erric_remove_dashboard_widgets() {

	$user = wp_get_current_user();
	if( ! $user->has_cap( 'manage_options' ) ) {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	}

}

add_action( 'wp_dashboard_setup', 'erric_remove_dashboard_widgets' );


// move the 'Right Now' dashboard widget to the right hand side
function erric_move_dashboard_widget() {

	$user = wp_get_current_user();
	if ( ! $user->has_cap( 'manage_options' ) ) {
		global $wp_meta_boxes;
		$widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'];
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_right_now'] = $widget;
	}

}

add_action( 'wp_dashboard_setup', 'erric_move_dashboard_widget' );


// add new dashboard widgets
function erric_add_dashboard_widgets() {

	wp_add_dashboard_widget( 'erric_dashboard_welcome', 'Welcome', 'erric_add_welcome_widget' );
	wp_add_dashboard_widget( 'erric_dashboard_links', 'Useful Links', 'erric_add_links_widget' );

}

add_action( 'wp_dashboard_setup', 'erric_add_dashboard_widgets' );

function erric_add_welcome_widget() { ?>

	This content management system lets you edit the pages and posts on your website.
 
    Your site consists of the following content, which you can access via the menu on the left:
 
    <ul>
        <li><strong>Pages</strong> - static pages which you can edit.</li>
        <li><strong>Posts</strong> - news or blog articles - you can edit these and add more.</li>
        <li><strong>Media</strong> - images and documents which you can upload via the Media menu on the left or within each post or page.</li>
    </ul>
 
    On each editing screen there are instructions to help you add and edit content.

    <?php
}

function erric_add_links_widget() { ?>

	Some links to resources which will help you manage your site:
 
    <ul>
        <li><a href="http://wordpress.org">The WordPress Codex</a></li>
        <li><a href="http://easywpguide.com">Easy WP Guide</a></li>
        <li><a href="http://www.wpbeginner.com">WP Beginner</a></li>
    </ul>

	<?php
}



/********************************************************************************/



// Customizing the WordPress Admin: Custom Admin Menus
// http://wp.tutsplus.com/tutorials/creative-coding/customizing-the-wordpress-admin-custom-admin-menus/


// Rename Posts to News in Menu
function erric_change_post_menu_label() {

	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'News Items';
	$submenu['edit.php'][10][0] = 'Add News Item';

}

add_action( 'admin_menu', 'erric_change_post_menu_label' );


// Edit submenus
function erric_change_post_object_label() {

	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News Item';
	$labels->add_new = 'Add News Item';
	$labels->add_new_item = 'Add News Item';
	$labels->edit_item = 'Edit News Item';
	$labels->new_item = 'News Item';
	$labels->view_item = 'View News Item';
	$labels->search_items = 'Search News Items';
	$labels->not_found = 'No News Items found';
	$labels->not_found_in_trash = 'No News Items found in Trash';
}

add_action( 'admin_menu', 'erric_change_post_object_label' );


// Remove Comments menu item for all but Administrators
function erric_remove_comments_menu_item() {

	$user = wp_get_current_user();
	if ( ! $user->has_cap( 'manage_options' ) ) {
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'tools.php' ); // testing
	}

}

add_action( 'admin_menu', 'erric_remove_comments_menu_item' );


// Move Pages above Media
function erric_change_menu_order( $menu_order ) {

	return array(
		'index.php',
		'edit.php',
		'edit.php?post_type=page',
		'upload.php'
	);

}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'erric_change_menu_order' );



/********************************************************************************/



// Customizing the WordPress Admin: Help Text
// http://wp.tutsplus.com/tutorials/creative-coding/customizing-the-wordpress-admin-help-text/


// Add metabox below editing pane
function erric_metabox_after_title() {

	add_meta_box( 'after-title-help', 'Using this Screen', 'erric_after_title_help_metabox_content', 'post', 'advanced', 'high' );

}

// callback function to populate metabox
function erric_after_title_help_metabox_content() { ?>
	<p>Use this screen to add new articles or edit existing ones. Make sure you click 'Publish' to publish a new article once you've added it, or 'Update' to save any changes.</p>
<?php }

add_action( 'add_meta_boxes', 'erric_metabox_after_title' );



// Add help text to right of screen in a metabox
function erric_metabox_top_right() {

	add_meta_box( 'top-right-help', 'Publishing and Saving Changes', 'erric_top_right_help_metabox_content', 'post', 'side', 'high' );

}

function erric_top_right_help_metabox_content() { ?>
	<p>Make sure you click 'Publish' below to publish a new article once you've added it, or 'Update' to save any changes.</p>
<?php }

add_action( 'add_meta_boxes', 'erric_metabox_top_right' );



// Add fake metabox above editing pane
function erric_text_after_title() { 

	$screen = get_current_screen();
	$edit_post_type = $screen->post_type;

	if ( 'post' != $edit_post_type )
		return;

	?>

	<div class="after-title-help postbox">
		<h3>Using this screen</h3>
		<div class="inside">
			<p>Use this screen to add new articles or edit existing ones. Make sure you click 'Publish' to publish a new article once you've added it, or 'Update' to save any changes.</p>
		</div><!-- .inside -->
	</div><!-- .postbox -->

<?php }

add_action( 'edit_form_after_title', 'erric_text_after_title' );



/********************************************************************************/



// Customizing the WordPress Admin – Listings Screens
// http://wp.tutsplus.com/tutorials/creative-coding/customizing-the-wordpress-admin-listings-screens/


// remove tags from posts listing screen
function erric_remove_posts_listing_tags( $columns ) {
	unset( $columns['tags'] );
	unset( $columns['comments'] );
	return $columns;
}

add_action( 'manage_posts_columns', 'erric_remove_posts_listing_tags' );

// resize columns in post listing screen
function erric_post_listing_column_resize() { ?>
	<style type="text/css">
		.edit-php .fixed .column-authors, .edit-php .fixed .column-categories {
			width: 15%;
		}
	</style>
	<?php
}

add_action( 'admin_enqueue_scripts', 'erric_post_listing_column_resize' );



/********************************************************************************/



// Customizing the WordPress Admin – Adding Styling
// http://wp.tutsplus.com/tutorials/creative-coding/customizing-the-wordpress-admin-adding-styling/


// let's start by enqueuing our styles correctly
function erric_admin_styles() {
	// use dirname(__FILE__) instead: http://codex.wordpress.org/Function_Reference/plugins_url
	wp_register_style( 'erric_admin_stylesheet', plugins_url( 'css/custom_admin.css', dirname(__FILE__) ) );
	wp_enqueue_style( 'erric_admin_stylesheet' );
}
add_action( 'admin_enqueue_scripts', 'erric_admin_styles' );

//change the footer text
function erric_admin_footer_text() {
	echo '<img src="' . plugins_url( 'images/logo.jpg', dirname(__FILE__) ) . '" />This tutorial is brought to you by <a href="http://wp.tutsplus.com">wptutsplus</a>.';
}
add_filter( 'admin_footer_text', 'erric_admin_footer_text' );




