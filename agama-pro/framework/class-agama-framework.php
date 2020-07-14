<?php
/**
 * Framework
 *
 * The Agama theme framework class.
 *
 * @since 1.0.1
 * @since 1.3.8   Updated the code.
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Framework {
    
    /**
     * Updates API
     *
     * The theme-vision.com updates API URL.
     *
     * @since 1.4.9.2
     * @access private
     * @return string
     */
    private static $updates_api = 'https://updates.theme-vision.com';
    
    /**
     * License
     *
     * The license for downloading bundled plugins from external source.
     *
     * @since 1.4.9.2
     * @access private
     * @return string
     */
    private static $license = '43383523da06d532b4e09139f303bc7f7a0fc7094eded42e85f1bfa0fa36ca3c';
    
    /**
     * The ID
     *
     * The order ID used for external validation while downloading bundled plugins.
     *
     * @since 1.4.9.2
     * @access private
     * @return int
     */
    private static $ID = 670;
    
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
	 *
	 * @since 1.3.8
	 */
	public function __construct() {
		
		add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
		
		self::get_template_parts();
		
	}
	
	/**
	 * Get Template Parts
	 *
	 * @since 1.3.8
	 */
	private static function get_template_parts() {
        get_template_part( 'framework/agama-actions' );
        get_template_part( 'framework/agama-filters' );
		get_template_part( 'framework/class-agama-body-bg-animation' );
		get_template_part( 'framework/class-agama-frontpage-boxes' );
		get_template_part( 'framework/class-agama-helper' );
		get_template_part( 'framework/class-agama' );
		get_template_part( 'framework/class-agama-core' );
		get_template_part( 'framework/class-agama-preloader' );
		get_template_part( 'framework/class-agama-sliders' );
		get_template_part( 'framework/class-agama-header-image' );
        get_template_part( 'framework/class-agama-header-video' );
		get_template_part( 'framework/class-agama-woocommerce' );
        get_template_part( 'framework/class-agama-portfolio' );
		get_template_part( 'framework/admin/class-agama-admin' );
		get_template_part( 'framework/polylang' );
		get_template_part( 'framework/class-agama-nav-walker' );
		get_template_part( 'framework/class-agama-breadcrumb' );
		get_template_part( 'framework/frontpage-boxes' );
		get_template_part( 'framework/class-agama-plugin-activation' );
		get_template_part( 'framework/widgets/widgets' );
		get_template_part( 'framework/agama-functions' );
	}

	/**
	 * Register Required Plugins
	 *
	 * @since 1.0.1
	 */
	public function register_required_plugins() {
        $plugin = [];
        
        // Build Vision Core Download URL
        $plugin['vision-core'] = add_query_arg(
            [
                'action'   => esc_attr( 'download' ),
                'slug'     => esc_attr( 'vision-core' ),
                'order_id' => esc_attr( self::$ID ),
                'license'  => esc_attr( self::$license )
            ],
            esc_url( self::$updates_api )
        );
        
        // Build LayerSlider Download URL
        $plugin['LayerSlider'] = add_query_arg(
            [
                'action'   => esc_attr( 'download' ),
                'slug'     => esc_attr( 'LayerSlider' ),
                'order_id' => esc_attr( self::$ID ),
                'license'  => esc_attr( self::$license )
            ],
            esc_url( self::$updates_api )
        );
        
        // Build Revolution Slider Download URL
        $plugin['revslider'] = add_query_arg(
            [
                'action'   => esc_attr( 'download' ),
                'slug'     => esc_attr( 'revslider' ),
                'order_id' => esc_attr( self::$ID ),
                'license'  => esc_attr( self::$license )
            ],
            esc_url( self::$updates_api )
        );
        
		$plugins = [
			[
				'name'				 => 'Vision Core',
				'slug'				 => 'vision-core',
				'source'			 => $plugin['vision-core'],
				'required'			 => true,
				'version'			 => '',
				'force_activation'	 => false,
				'force_deactivation' => false,
				'image_url'			 => esc_url( AGAMA_FMW_URI . 'admin/assets/img/visioncore-logo.jpg' )
			],
            [ 
                'name'               => 'Elementor',
                'slug'               => 'elementor',
                'required'           => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'image_url'          => esc_url( AGAMA_FMW_URI . 'admin/assets/img/elementor-logo.png' )
            ],
            [
                'name'              => 'Multiple Featured Images',
                'slug'              => 'multiple-featured-images',
                'required'          => false,
                'force_activation'  => false,
                'image_url'         => esc_url( AGAMA_FMW_URI . 'admin/assets/img/multiplefeaturedimages-logo.jpg' )
            ],
			[
				'name'               => 'Layer Slider',
				'slug'               => 'LayerSlider',
				'source'             => $plugin['LayerSlider'],
				'required'           => false,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'image_url'			 => esc_url( AGAMA_FMW_URI . 'admin/assets/img/layerslider-logo.jpg' )
			],
			[
				'name'               => 'Revolution Slider',
				'slug'               => 'revslider',
				'source'             => $plugin['revslider'],
				'required'           => false,
				'version'            => '',
				'force_activation'   => false,
				'force_deactivation' => false,
				'image_url'			 => esc_url( AGAMA_FMW_URI . 'admin/assets/img/revslider-logo.jpg' )
			],
		];
        
        $goldaddons = [ 
            [
                'name'               => 'Gold Addons for Elementor',
                'slug'               => 'gold-addons-for-elementor',
                'required'           => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'image_url'          => esc_url( AGAMA_FMW_URI . 'admin/assets/img/elementor-logo.png' )
            ]
        ];
        
        /**
         * If Elementor plugin installed & active
         * suggest GoldAddons plugin installation.
         */
        if( is_plugin_active( 'elementor/elementor.php' ) ) {
            $plugins = array_merge( $plugins, $goldaddons );
        }

		$config = [
            'id'           => 'agama-pro',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
			'strings'      => [
				'page_title' => esc_html__( 'Install Required Plugins', 'agama-pro' ),
				'menu_title' => esc_html__( 'Install Plugins', 'agama-pro' ),
				'installing' => __( 'Installing Plugin: %s', 'agama-pro' ), // %s = plugin name.
				'oops' => esc_html__( 'Something went wrong with the plugin API.', 'agama-pro' ),
				'notice_can_install_required' => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
				'notice_can_install_recommended' => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_install' => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
				'notice_can_activate_required' => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_activate' => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
				'notice_ask_to_update' => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_update' => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
				'install_link' => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link' => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
				'return' => esc_html__( 'Return to Required Plugins Installer', 'agama-pro' ),
				'plugin_activated' => esc_html__( 'Plugin activated successfully.', 'agama-pro' ),
				'complete' => __( 'All plugins installed and activated successfully. %s', 'agama-pro' ), // %s = dashboard link.
				'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			]
		];
		tgmpa( $plugins, $config );
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
