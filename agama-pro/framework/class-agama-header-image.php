<?php
/**
 * Header Image
 *
 * The header image class.
 *
 * @since 1.3.0
 * @since 1.3.8   Updated the code.
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama;

use Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Header_Image {

    /**
     * Is Header Image Enabled ?
     *
     * @since 1.3.8
     * @access private
     */
    private $enabled;

    /**
     * Header Image
     *
     * @since 1.4.6
     * @access private
     */
    private $image;

    /**
     * Header Image Thru Meta
     *
     * @since 1.4.3
     * @access private
     */
    private $meta;

    /**
     * Show on Frontpage ?
     *
     * @since 1.3.8
     * @access private
     */
    private $show_on_front;

    /**
     * Is Particles Enabled ?
     *
     * @since 1.3.8
     * @access private
     */
    private $particles;

    /**
     * Pages in Array
     *
     * @since 1.3.8
     * @access private
     */
    private $pages;

    /**
     * Get Pages IDs
     *
     * @since 1.3.8
     * @access private
     */
    private $pages_id;

    /**
     * The one, true instance of this object.
     *
     * @static
     * @since 1.3.8
     * @access private
     * @var null|object
     */
    private static $instance = null;

    /**
     * Class Constructor
     * 
     * @since 1.3.8
     */
    function __construct() {

        $this->enabled 			= esc_attr( get_theme_mod( 'agama_header_image_enabled', 'none' ) );

        $this->image            = esc_attr( get_theme_mod( 'agama_header_image', '' ) );
        $this->meta             = esc_attr( Agama::get_meta( '_agama_header_image' ) );

        // If header image set via metabox
        // override customize settings.
        if( $this->meta ) {
            $this->enabled = 'onmeta';
            $this->image = $this->meta;
        }

        $this->show_on_front	= get_option( 'show_on_front' );
        $this->particles		= esc_attr( get_theme_mod( 'agama_header_image_particles', true ) );

        $this->posts            = get_theme_mod( 'agama_header_image_posts', '' );
        $this->is_single        = is_single( $this->posts );

        $this->pages			= get_theme_mod( 'agama_header_image_pages', '' );
        $this->pages_id			= Helper::get_pages_id( $this->pages );
        $this->is_page          = is_page( $this->pages_id );

        // If enabled on posts but not selected any post.
        if( $this->enabled == 'onposts' && empty( $this->posts ) ) {
            return;
        }

        // If enabled on pages but not selected any page.
        if( $this->enabled == 'onpages' && empty( $this->pages_id ) ) {
            return;
        }

        $this->get_custom_header();
    }

    /**
     * Get a unique instance of this object.
     *
     * @since 1.3.8
     * @return object
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * Check if Header Image is Enabled
     *
     * @since 1.4.6
     */
    private function is_enabled() {
        switch( $this->enabled ) {
            case 'homepage':
                return is_front_page();
            break;
            case 'onpages':
                return $this->is_page;
            break;
            case 'onposts':
                return $this->is_single;
            break;
            case 'onall':
            case 'onmeta':
                return true;
            break;
            default: false;
        }
    }

    /**
     * Render Particles
     *
     * @since 1.3.8
     */
    private function get_particles() {
        // If particles enabled via metabox.
        if( Agama::get_meta( '_agama_header_image_particles' ) == 'on' ) {
            $particles = true;
        }
        else // Else if particle disabled via metabox.
        if( Agama::get_meta( '_agama_header_image_particles' ) == 'off' ) {
            $particles = false;
        } else { // Else get particles setting from customizer.
            $particles = $this->particles;
        }

        if( $particles ) {
            echo '<div id="particles-header-image" class="agama-particles"></div>';
        }
    }

    /**
     * Render Header Image or Header Video
     *
     * @since 1.3.8
     */
    public function get_custom_header() {
        if( $this->is_enabled() ) {
            echo '<div id="agama-header-object" class="agama-header-object">';

                // Particles Effect
                self::get_particles();

                // If header image set thru meta box, give priority.
                if( $this->image ) {
                    $header_image = wp_get_attachment_image_src( $this->image, 'full' );
                    $srcset = wp_get_attachment_image_srcset( $this->image, 'full' );
                    $alt = get_post_meta( $this->image, '_wp_attachment_image_alt', true );
                    $alt = ! empty( $alt ) ? 'alt="'. $alt .'"' : '';
                    echo '<div id="wp-custom-header" class="wp-custom-header">';
                        echo '<img  src="'. esc_url( $header_image[0] ) .'" 
                                    width="'. esc_attr( $header_image[1] ) .'" 
                                    height="'. esc_attr( $header_image[2] ) .'" 
                                    srcset="'. esc_attr( $srcset ) .'" 
                                    '. $alt .'>';
                    echo '</div>';
                }

            echo '</div>';
        }
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
