<?php
/**
 * Enqueue AgamaPro Parent & Child Theme Stylesheets
 *
 * @since 1.0.0
 */
add_action( 'wp_enqueue_scripts', 'agamapro_enqueue_styles' );
function agamapro_enqueue_styles() {
    wp_enqueue_style( 'agama-pro-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'agama-pro-child', get_stylesheet_directory_uri() . '/style.css', array( 'agama-pro-style' ) );
}

#######################################################################################
#                            
# ADD YOUR CUSTOM CODE BELOW | Text Domain: agama-child
#
#######################################################################################

