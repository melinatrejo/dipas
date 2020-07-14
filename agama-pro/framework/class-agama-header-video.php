<?php
/**
 * Header Video
 *
 * The  Agama header video class.
 *
 * @since 1.4.6
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Header_Video {

    /** 
     * Enabled
     *
     * @access private
     */
    private $enabled;
    
    /**
     * Enabled on Pages
     *
     * @access private
     */
    private $onpages;
    
    /**
     * Enabled on Posts
     *
     * @access private
     */
    private $onposts;
    
    /**
     * Video Type
     *
     * @access private
     */
    private $type;
    
    /**
     * Video URL
     *
     * @access private
     */
    private $embed;
    
    /**
     * Video File
     *
     * @access private
     */
    private $file;
    
    /**
     * Video Size
     *
     * @access private
     */
    private $size;
    
    /**
     * The one, true instance of this object.
     *
     * @access private
     */
    private static $instance = null;
    
    /**
     * Class Constructor
     */
    function __construct() {
        
        $this->enabled      = esc_attr( get_theme_mod( 'agama_header_video_enabled', 'none' ) );
        $this->onpages      = get_theme_mod( 'agama_header_video_pages', '' );
        $this->onposts      = get_theme_mod( 'agama_header_video_posts', '' );
        $this->type         = esc_attr( get_theme_mod( 'agama_header_video_type', 'embed' ) );
        $this->embed        = get_theme_mod( 'agama_header_video_embed', '' );
        $this->file         = esc_url( get_theme_mod( 'agama_header_video_file', '' ) );
        $this->size         = get_theme_mod( 'agama_header_video_size', array( 'width' => '560px', 'height' => '315px' ) );
        
        $this->is_page      = ! empty( $this->onpages ) ? is_page( $this->onpages ) : null;
        $this->is_single    = ! empty( $this->onposts ) ? is_single( $this->onposts ) : null;
        
        if( $this->type == 'upload' && ! empty( $this->file ) ) {
            if( preg_match( '/.mp4/', $this->file ) ) {
                $this->ext = 'mp4';
            } elseif( preg_match( '/.ogg/', $this->file ) ) {
                $this->ext = 'ogg';
            } elseif( preg_match( '/.webm/', $this->file ) ) {
                $this->ext = 'webm';
            } else {
                $this->ext = 'unknown';
            }
        }
        
        // If enabled on pages but no page(s) selected.
        if( $this->enabled == 'onpages' && ! $this->is_page ) {
            return;
        }
        
        // If enabled on posts but no post(s) selected.
        if( $this->enabled == 'onposts' && ! $this->is_single ) {
            return;
        }
        
        $this->get_header_video();
    }
    
    /**
     * Get a unique instance of this object.
     *
     * @since 1.4.6
     * @return object
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Check if Enabled
     *
     * @since 1.4.6
     */
    private function is_enabled() {
        switch( $this->enabled ) {
            case 'none';
                return false;
            break;
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
                return true;
            break;
        }
    }
    
    /**
     * Render Header Video
     * 
     * @since 1.4.6
     */
    private function get_header_video() {
        $output = '';
        
        if( $this->is_enabled() ) {
            echo '<div id="agama-header-object" class="agama-header-object">';
                if( $this->type == 'embed' && ! empty( $this->embed ) ) {
                    $output .= html_entity_decode( $this->embed );
                } elseif( $this->type == 'upload' && ! empty( $this->file ) ) {
                    $output .= '<video ';
                    $output .= 'width="'. esc_attr( $this->size['width'] ) .'" ';
                    $output .= 'height="'. esc_attr( $this->size['height'] ) .'" controls>';
                    $output .= '<source src="'. esc_url( $this->file ) .'" type="video/'. esc_attr( $this->ext ) .'">';
                    $output .= esc_html__( 'Your browser does not support the video tag.', 'agama-pro' );
                    $output .= '</video>';
                }
                echo $output;
            echo '</div>';
        }
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
