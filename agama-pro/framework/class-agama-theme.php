<?php
/**
 * Agama Theme
 *
 * The Agama theme class holding all details about the theme.
 *
 * @since 1.4.9.2
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Theme {
    
    /**
     * Version
     *
     * The Agama theme version.
     *
     * @since 1.1.99
     * @since 1.4.9.2 Updated the code.
     * @access public
     * @return string
     */
    public $version = '1.4.9.2';
    
    /**
     * Development
     *
     * The development mode.
     *
     * @since 1.3.7
     * @since 1.4.9.2 Updated the code.
     * @access private
     * @return bool
     */
    private $development = true;
    
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
     * Version
     *
     * Return the Agama theme version.
     *
     * @since 1.4.9.2
     * @access public
     * @return string
     */
    public function version() {
        if( $this->development ) {
            return esc_attr( uniqid() );
        }
        
        return esc_attr( $this->version );
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
