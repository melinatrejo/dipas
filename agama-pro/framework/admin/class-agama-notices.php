<?php
/**
 * Notices Class
 *
 * The admin notices class.
 *
 * @since 1.4.9.2
 */

namespace Agama\Admin;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Notices {
    
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
    public function __construct() {
        
        if( is_admin() ) {
            add_action( 'admin_notices', [ $this, 'theme_not_registered' ] );
            add_action( 'admin_notices', [ $this, 'vision_core_not_active' ] );
        }
        
    }
    
    /**
     * Theme Not Registered
     *
     * The Agama PRO theme not registered notice.
     *
     * @since 1.3.5
     * @since 1.4.9.2 Updated the code.
     * @access public
     * @return mixed
     */
    public function theme_not_registered() {
        if( ! get_option( 'vision_license' ) && is_plugin_active( 'vision-core/vision-core.php' ) ) {
            echo '<div class="notice notice-warning">';
                printf(
				    '<p>%s <a href="%s">%s</a></p>',
				    esc_html__( 'Agama PRO theme is not registered! Automatic theme & bundled plugins updates are disabled!', 'agama-pro' ),
				    admin_url( 'admin.php?page=vision-product' ),
				    esc_html__( 'Register Agama Pro Theme', 'agama-pro' )
                );
            echo '</div>';
        }
    }
    
    /**
     * Vision Core Not Active
     *
     * The Vision Core plugin is not active notice.
     *
     * @since 1.3.5
     * @since 1.4.9.2 Updated the code.
     * @access public
     * @return mixed
     */
    public function vision_core_not_active() {
        if( ! is_plugin_active( 'vision-core/vision-core.php' ) ) {
            echo '<div class="notice notice-warning">';
                printf(
                    '<p><strong>%s</strong> %s %s <a href="%s">%s</a>',
                    esc_html__( 'Vision Core', 'agama-pro' ),
                    esc_html__( 'plugin is not active or installed ! Agama Pro theme must have enabled Vision Core plugin.', 'agama-pro' ),
                    esc_html__( 'Theme updates, shortcodes & portfolio features are disabled!', 'agama-pro' ),
                    admin_url( 'themes.php?page=tgmpa-install-plugins' ),
                    esc_html__( 'Activate or Install Vision Core Plugin', 'agama-pro' )
                );
            echo '</div>';
        }
    }
    
}

Notices::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
