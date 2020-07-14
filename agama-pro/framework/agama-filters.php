<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Featured Image Class
 *
 * @since 1.4.5
 */
function agama_featured_image_class_filter( $class ) {
    $hover_effect   = esc_attr( get_theme_mod( 'agama_blog_thumbnails_hover_effect', true ) );
    $blog_layout    = esc_attr( get_theme_mod( 'agama_blog_layout', 'list' ) );
    
    if( $hover_effect && $blog_layout == 'list' ) {
        $class[] = 'image_fade';
    }
    else
    if( $hover_effect && $blog_layout == 'grid' ) {
        $class[] = 'image_fade';
    }
    else
    if( $hover_effect && $blog_layout == 'small_thumbs' ) {
        $class[] = 'image-grow';
    }
    
    return implode( ' ', $class );
}
add_filter( 'agama_featured_image_class', 'agama_featured_image_class_filter', 10, 3 );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
