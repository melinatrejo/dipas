<?php
/**
 * Customizer
 *
 * The Agama customizer class.
 *
 * @since 1.4.7
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama\Admin;

use Agama;
use Agama\Helper;
use Kirki;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Customizer {

    /**
     * Path to Customizer DIR
     *
     * @since 1.4.7
     * @access public
     */
    public $dir_path;

    /**
     * Path to Customizer URL
     *
     * @since 1.4.7
     * @access public
     */
    public $url_path;
    
    /**
	 * Instance
	 *
	 * Single instance of this object.
	 *
	 * @since 1.4.9.2
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * Get Instance
	 *
	 * Access the single instance of this class.
	 *
	 * @since 1.4.9.2
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

    /**
     * Class Constructor
     */
    function __construct() {

        $this->dir_path = get_template_directory() . '/framework/admin/customizer/';
        $this->url_path = get_template_directory_uri() . '/framework/admin/customizer/';

        add_action( 'customize_controls_print_styles', [ $this, 'customize_controls_print_styles' ] );
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customize_controls_enqueue_scripts' ] );
        add_action( 'customize_preview_init', [ $this, 'customize_preview_init' ] );
        add_action( 'customize_register', [ $this, 'customize_register' ] );
        add_action( 'wp_head', [ $this, 'frontend_css' ] );

        add_filter( 'kirki_telemetry', '__return_false' );
        add_filter( 'kirki/config', [ $this, 'kirki_update_url' ] );

        get_template_part( 'framework/admin/kirki/kirki' );
        get_template_part( 'framework/admin/customizer/controls/control-editor' );
        get_template_part( 'framework/admin/customizer/class-agama-page-builder' );
        get_template_part( 'framework/admin/modules/icon-picker/icon-picker-control' );
        get_template_part( 'framework/admin/customizer/customize-partial-refresh' );

        Kirki::add_config( 'agama_options', array(
            'option_type' => 'theme_mod',
            'capability'  => 'edit_theme_options'
        ) );

        get_template_part( 'framework/admin/customizer/customize-panels' );
        get_template_part( 'framework/admin/customizer/customize-sections' );
        get_template_part( 'framework/admin/customizer/customize-fields' );

    }

    /**
     * Customize Controls Print Scripts
     *
     * @since 1.4.7
     */
    function customize_controls_print_styles() {

        wp_enqueue_style( 'agama-customizer', $this->url_path . 'assets/css/customizer-style.css', array(), agama_version );

    }

    /**
     * Customize Live Preview
     *
     * @since 1.4.7
     */
    function customize_preview_init() {

        // Customize Preview JS
        wp_register_script( 'agama-customize-preview', $this->url_path . 'assets/js/customize-preview.js', [ 'jquery', 'customize-preview' ], agama_version, true );
        wp_enqueue_script( 'agama-customize-preview' );

        // Partial Refresh Stylesheet
        wp_register_style( 'agama-partial-refresh', $this->url_path . 'assets/css/partial-refresh.css', array(), agama_version );
        wp_enqueue_style( 'agama-partial-refresh' );

    }

    /**
     * Customize Controls Enqueue Scripts
     *
     * @since 1.4.7
     */
    function customize_controls_enqueue_scripts() {
        wp_register_script( 'agama-customize-controls', $this->url_path . 'assets/js/customize-controls.js', [ 'jquery' ], agama_version, true );
        wp_localize_script( 'agama-customize-controls', 'themevision', array(
            'wikiURL'       => esc_url( 'http://docs.theme-vision.com' ),
            'wikiLabel'     => esc_attr__( 'Documentation', 'agama-pro' ),
            'supportURL'    => esc_url( 'https://theme-vision.com/forums/' ),
            'supportLabel'  => esc_attr__( 'Theme Support', 'agama-pro' )
        ) );
        wp_enqueue_script( 'agama-customize-controls' );
    }

    /**
     * Kirki Update URL
     *
     * @since 1.4.7
     */
    function kirki_update_url() {
        $config['url_path'] = AGAMA_URI . 'framework/admin/kirki/';
        return $config;
    }

    /**
     * Customize Register
     *
     * @since 1.0
     */
    function customize_register( $wp_customize ) {
        $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        $wp_customize->remove_section('colors');
        $wp_customize->remove_section('static_front_page');
    }

    /**
     * Frontend CSS
     *
     * @since 1.0
     */
    function frontend_css() {
        $html = '<style type="text/css" id="agama-customize-css">';

            $html .= Helper::generate_stop_header_shrink_css();
            $html .= Helper::generate_logo_align_css();
            $html .= Helper::generate_vision_row_css();
            $html .= Helper::generate_layout_width_css(); 
            $html .= Helper::generate_404_page_css();

            // Single Page Background Image
            if( Agama::get_meta( '_agama_page_bg_img' ) ) {
                $page_id     = esc_attr( Agama::get_meta( '_agama_page_bg_img' ) );
                $page_bg_img = wp_get_attachment_image_src( $page_id, 'full' ); 
                $page_bg_img = esc_url( $page_bg_img[0] );
                $html .= '#page.site {';
                    $html .= 'background-image: url('. $page_bg_img .');';
                    $html .= 'background-size: cover';
                    $html .= 'background-position: top center';
                $html .= '}';
            }

            // Portfolio Full Width Template
            if( is_page_template( 'templates/portfolio-full-width.php' ) ) {
                $html .= 'div#page {';
                    $html .= 'padding: 0';
                $html .= '}';
                $html .= '.vision-row {';
                    $html .= 'max-width: 100%;';
                    $html .= 'width: 100%;';
                $html .= '}';
            }

            // Full Width Template
            if( is_page_template( 'templates/full-width.php' ) ) {
                $html .= 'body .site { padding: 0 !important; }';
                $html .= 'body .site, .vision-row { max-width: 100% !important; }';
            }

            // Header Style V2
            if( 'v2' == agama_header_style() && get_theme_mod( 'agama_header_transparent', false ) ) {
                $html .= '.header_transparent header.header_v2 .sticky-header:not(.sticky-header-shrink) { background: transparent; border-top-color: transparent; position: fixed; box-shadow: none; -moz-box-shadow: none; -webkit-box-shadow: none; border-bottom: 2px solid rgba(255,255,255, .1); }';
            }

            // Comment Author
            $html .= '.comment-content .comment-author cite {';
                $html .= 'background-color:'. esc_attr( get_theme_mod( 'agama_primary_color', '#A2C605' ) ) .';';
                $html .= 'border: 1px solid '. esc_attr( get_theme_mod( 'agama_primary_color', '#A2C605' ) ) .';';
            $html .= '}';

            // Blockquote RTL
            if( is_rtl() ) {
                $html .= 'blockquote {';
                    $html .= 'border-right: 3px solid '. esc_attr( get_theme_mod( 'agama_primary_color', '#A2C605' ) ) .';';
                $html .= '}';
            } else {
                $html .= 'blockquote {';
                    $html .= 'border-left: 3px solid '. esc_attr( get_theme_mod( 'agama_primary_color', '#A2C605' ) ) .';';
                $html .= '}';
            }

            // Blog Layout List
            if( ! get_theme_mod( 'agama_blog_date', true ) && get_theme_mod( 'agama_blog_layout', 'list' ) == 'list' ) {
                $html .= '.list-style .entry-content { margin-left: 0 !important; }';
            }

            // Blog Layout Grid & Infinite Scroll
            if( get_theme_mod( 'agama_blog_infinite_scroll', false ) && get_theme_mod( 'agama_blog_layout', 'list' ) == 'grid' ) {
                $html .= '#infscr-loading {';
                    $html .= 'position: absolute;';
                    $html .= 'bottom: 0;';
                    $html .= 'left: 25%;';
                $html .= '}';
            }

            // Vision Tabs
            $html .= '.vision_tabs #tabs li.active a {';
                $html .= 'border-top: 3px solid '. esc_attr( get_theme_mod( 'agama_primary_color', '#A2C605' ) ) .';';
            $html .= '}';

            // WooCommerce Menu Cart
            if( class_exists( 'Woocommerce' ) ) {
                $html .= '.vision-main-menu-cart .cart_count:before,';
                $html .= '#agama_wc_cart .cart_count:before {';
                    $html .= 'border-color: transparent '. esc_attr( get_theme_mod( 'agama_primary_color', '#A2C605' ) ) .' transparent;';
                $html .= '}';
            }

            // Sidebar Left
            if( get_theme_mod( 'agama_sidebar_position', 'right' ) == 'left' ) {
                $html .= '#primary { float: right; }';
                $html .= '.page-template-full-width #primary { float: none; }';
                $html .= '#vision-pagination, #infinite-loadmore { float: right; }';
            }

            // Contact Template
            if( is_page_template( 'templates/contact.php' ) ) {
                $html .= '.vision-row { max-width: 100% !important; }';
            }

            // Footer Background Image
            if( get_theme_mod( 'agama_footer_bg_image', '' ) !== '' ) {
                $html .= '.footer-widgets, footer[role=contentinfo] {';
                    $html .= 'background-color: transparent;';
                $html .= '}';
            }

        $html .= '</style>';

        echo $html;
    }

}

Customizer::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
