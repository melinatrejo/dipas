<?php
/**
 * Customize Page Builder
 *
 * The customize page builder.
 *
 * @since 1.4.7
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama\Admin\Customize;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Builder {

    /**
     * Path to Builder DIR
     *
     * @since 1.4.7
     * @access public
     */
    public $dir_path;

    /**
     * Path to Builder URL
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

        add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
        add_action( 'customize_controls_print_scripts', [ $this, 'customize_controls_print_scripts' ], 30 );
        add_action( 'agama_add_widget', [ $this, 'add_widget' ] );

    }

    /**
     * Enqueue Admin Scripts
     *
     * @since 1.4.7
     */
    function admin_scripts( $hook ) {
        wp_enqueue_style( 'agama-page-builder-misc', $this->url_path . 'assets/css/widgets.css', array(), agama_version );
        if( 'widgets.php' == $hook || 'post.php' == $hook ){
            wp_enqueue_style( 'wp-color-picker' );        
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'agama-widgets', $this->url_path . 'assets/js/widgets.js', ['jquery'], agama_version );
        }
    }

    /**
     * Customize Controls Print Scripts
     *
     * @since 1.4.7
     */
    function customize_controls_print_scripts() {
        $strings = array(
            'ajax_url'          => admin_url( 'admin-ajax.php' ),
            'agamaWidgetsLabel' => esc_html__( 'Agama Widgets', 'agama-pro' ),
            'otherWidgetsLabel' => esc_html__( 'Other Widgets', 'agama-pro' )
        );

        // Enqueue Page Builder Script
        wp_register_script( 'agama-page-builder', $this->url_path . 'assets/js/page-builder.js', ['jquery'], agama_version );
        wp_localize_script( 'agama-page-builder', 'agama_builder', $strings );
        wp_enqueue_script( 'agama-page-builder' );

        // Enqueue Page Builder Stylesheet
        wp_register_style( 'agama-page-builder', $this->url_path . 'assets/css/page-builder.css', array(), agama_version );
        wp_enqueue_style( 'agama-page-builder' );
    }

    /**
     * Add New Widget Button
     *
     * @since 1.4.7
     * @is_customize_preview
     */
    function add_widget( $page_id ) {
        if( is_customize_preview() ) {

            $html  = '<div class="agama-page-builder-add-widget" data-id="sidebar-widgets-page-widget-'. esc_attr( $page_id ) .'">';
                $html .= '<a class="add-new-widget" data-toggle="tooltip" data-placement="top" title="'. esc_html__( 'Add New', 'agama-pro' ) .'"><i class="fa fa-plus"></i></a>';
            $html .= '</div>';

            echo $html;
        }
    }

}

Builder::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
