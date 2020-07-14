<?php
/**
 * Do not customize functions.php file in Agama Pro theme.
 * Use Agama Pro Child theme for customizations:
 * http://docs.theme-vision.com/article/child-theme/
 */

use Agama\Theme;
use Agama\Framework;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Loads a agama theme template part into a template.
get_template_part( 'framework/class-agama-theme' );

// Load the theme translated strings.
load_theme_textdomain( 'agama-pro', get_template_directory() . '/languages' );

/**
 * Agama
 *
 * The access to Agama theme class object.
 *
 * @since 1.4.9.2
 * @return object
 */
function Agama() {
    return Theme::get_instance();
}

// Loads a framework template part into a template.
get_template_part( 'framework/class-agama-framework' );

// Fire a framework class.
Framework::get_instance();
 
/* Omit closing PHP tag to avoid "Headers already sent" issues. */ 
