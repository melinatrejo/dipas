<?php
/**
 * Admin Setup
 *
 * The admin setup class.
 *
 * @since 1.3.5
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama\Admin;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Setup {
    
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
        
        $this->get_template_parts();
        
    }
    
    /**
     * Get Template Parts
     *
     * Load all necessary backend template parts.
     *
     * @since 1.3.5
     * @since 1.4.9.2 Updated the code.
     * @access private
     * @return void
     */
    private function get_template_parts() {
        get_template_part( 'framework/admin/class-agama-notices' );
        get_template_part( 'framework/admin/class-agama-animate' );
        get_template_part( 'framework/admin/class-agama-choices' );
        get_template_part( 'framework/admin/customizer/class-agama-customizer' );
        get_template_part( 'framework/admin/class-agama-metaboxes' );
    }
    
}

Setup::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
