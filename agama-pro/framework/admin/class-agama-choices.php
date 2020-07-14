<?php
/**
 * Choice
 *
 * The Agama choice class.
 *
 * @since 1.3.0
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama\Admin;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Choice {

    /**
     * Return All Posts
     *
     * @since 1.4.6
     * @return array
     */
    public static function posts() {
        if( is_customize_preview() ) { // Fixes Elementor PRO bug. (Class name must be a valid object or a string)
            $Query = new \WP_Query( 
                [
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => -1
                ]
            );

            $output = [];

            if( $Query->have_posts() ) {
                while( $Query->have_posts() ) : $Query->the_post();
                    $ID = get_the_ID();
                    $output[$ID] = esc_html( get_the_title() );
                endwhile;
            } 

            return $output;
        }
    }

    /**
     * Return All Pages
     *
     * @since 1.3.0
     * @return array
     */
    public static function pages() {
        if( is_customize_preview() ) {
            $pages = get_pages();
            if( is_array( $pages ) ) {
                foreach( $pages as $page ) {
                    $output[$page->ID] = $page->post_title; 
                }
            }
            if( is_admin() ) {
                return $output;
            }
        }
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
