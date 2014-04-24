<?php

// http://wp.tutsplus.com/tutorials/plugins/random-quote-plugin-with-custom-post-type/


// Register custom post type
add_action( 'init', 'erric_random_quote' );
function erric_random_quote() {
    register_post_type( 'random_quote',
        array(
            'labels' => array(
                'name' => __( 'Random Quotes' ),
                'singular_name' => __( 'Random Quote' )
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-editor-quote' // http://code.tutsplus.com/articles/quick-tip-using-dashicons-for-menu-items--wp-35565
        )
    );
}


// Create admin interface

add_filter("manage_edit-random_quote_columns", "erric_project_edit_columns");
function erric_project_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Person",
        "description" => "Quote",
    );
 
    return $columns;
}
 
add_action("manage_posts_custom_column",  "erric_project_custom_columns"); 
function erric_project_custom_columns($column) {
    global $post;
    switch ($column) {
        case "description":
            the_excerpt(); echo 'you...';
            break;
    }
}


// Main function to get quotes
function erric_quote_generate() {
    // Retrieve one random quote
    $args = array(
        'post_type' => 'random_quote',
        'posts_per_page' => 1,
        'orderby' => 'rand'
    );
    $query = new WP_Query( $args );
 
    // Build output string
    $quo = '';
    $quo .= $query->post->post_title;
    $quo .= ' said "';
    $quo .= $query->post->post_content;
    $quo .= '"';
 
    return $quo;
}
 
// Helper function
function erric_change_bloginfo( $text, $show ) {
    if( 'description' == $show ) {
        $text = erric_quote_generate();
    }
    return $text;
}

// Override default filter with the new quote generator
add_filter( 'bloginfo', 'erric_change_bloginfo', 10, 2 );