<?php
/**
 * Metabox
 *
 * The Agama theme posts/pages metabox.
 *
 * @since 1.0.1
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama\Admin;

use Agama\Core;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Metabox {
    
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
	 * Class constructor
	 */
	public function __construct() {
        if( ! is_admin() ) {
            return;
        }
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}
    
    /**
     * Enqueue Scripts
     * 
     * Enqueue meta box styles & scripts
     *
     * @since 1.3.9.3
     * @access public
     * @return void
     */
    function admin_enqueue_scripts() {
         wp_enqueue_media();
        
        // Enqueue Modernizr custom build jQuery.
        wp_enqueue_script( 
            'agama-modernizr-custom', 
            AGAMA_ADMIN_DIR_URI . 'js/modernizr.custom.js', 
            [], 
            Agama()->version() 
        );
        
        // Enqueue Meta Box jQuery.
        wp_enqueue_script( 
            'agama-meta-box', 
            AGAMA_ADMIN_DIR_URI . 'js/meta-boxes.js', 
            [],  
            Agama()->version(), 
            true 
        );
        
        // Enqueue Meta Box styles stylesheet file.
        wp_enqueue_style( 
            'agama-meta-box-styles', 
            AGAMA_ADMIN_DIR_URI . 'css/meta-boxes-styles.css', 
            [], 
            Agama()->version() 
        );
        
        // Enqueue Meta Box stylesheet.
        wp_enqueue_style( 
            'agama-meta-box', 
            AGAMA_ADMIN_DIR_URI . 'css/meta-boxes.css', 
            [],  
            Agama()->version() 
        );
    }

	/**
     * Add Meta Box
     *
	 * Adds a meta box to one or more screens.
	 *
	 * @since 1.0.1
     * @access public
     * @return void
	 */
	public function add_meta_box( $post_type ) {
		add_meta_box(
			'agama_options_metabox',
			esc_html__( 'Agama Options', 'agama-pro' ),
			[ $this, 'render_meta_box_content' ],
			$post_type,
			'advanced',
			'high'
		);
	}
	
	/**
     * Get Meta
     * 
	 * Get post or page meta.
	 *
	 * @since 1.3.8
     * @access private
     * @return string
	 */
	private function get_meta( $meta_key, $default = false, $post_id = false ) {
		global $post;
		
		// If post id is not set, get it from global $post object.
		if( ! $post_id && ! empty( $post->ID ) ) {
			$post_id = $post->ID;
		}
		
		// If default value set & there is no meta_key in post meta, return default
		if( ! empty( $default ) && ! get_post_meta( $post_id, $meta_key, true ) ) {
			return $default;
		} else {
			return get_post_meta( $post_id, $meta_key, true );
		}
	}

	/**
     * Save
     *
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id (required) The ID of the post being saved.
     *
	 * @since 1.0.1
     * @access public
     * @return bool
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['agama_options_nonce'] ) ) {
			return $post_id;
        }

		$nonce = $_POST['agama_options_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'agama_options' ) ) {
			return $post_id;
        }

		// If this is an autosave, our form has not been submitted,
        // so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize and prepare options for saving into database.
		$options = array();
        
        // Portfolio article, project info heading.
        if( isset( $_POST['_agama_pt_project_info'] ) ) {
            $option['_agama_pt_project_info'] = esc_html( $_POST['_agama_pt_project_info'] );
            $options = array_merge( $options, $option );
        }

		// Portfolio article, created by input field.
		if( isset( $_POST['_agama_pt_created_by'] ) && ! empty( $_POST['_agama_pt_created_by'] ) ) {
			$option['_agama_pt_created_by'] = esc_attr( $_POST['_agama_pt_created_by'] );
			$options = array_merge( $options, $option );
		}

		// Portfolio article, completed on input field.
		if( isset( $_POST['_agama_pt_completed_on'] ) && ! empty( $_POST['_agama_pt_completed_on'] ) ) {
			$option['_agama_pt_completed_on'] = esc_attr( $_POST['_agama_pt_completed_on'] );
			$options = array_merge( $options, $option );
		}

		// Portfolio article, project url input field.
		if( isset( $_POST['_agama_pt_project_url'] ) && ! empty( $_POST['_agama_pt_project_url'] ) ) {
			$option['_agama_pt_project_url'] = esc_url_raw( $_POST['_agama_pt_project_url'] );
			$options = array_merge( $options, $option );
		}

		// Portfolio article, project url text input field. <a href="">Text</a>
		if( isset( $_POST['_agama_pt_project_url_txt'] ) && ! empty( $_POST['_agama_pt_project_url_txt'] ) ) {
			$option['_agama_pt_project_url_txt'] = sanitize_text_field( $_POST['_agama_pt_project_url_txt'] );
			$options = array_merge( $options, $option );
		}
        
        // Portfolio article, project embed video.
        if( isset( $_POST['_agama_pt_video'] ) ) {
            $option['_agama_pt_video'] = $_POST['_agama_pt_video'];
            $options = array_merge( $options, $option );
        }
        
        // Portfolio article, rollover icons.
        if( isset( $_POST['_agama_pt_rollover_icons'] ) ) {
            $option['_agama_pt_rollover_icons'] = esc_attr( $_POST['_agama_pt_rollover_icons'] );
            $options = array_merge( $options, $option );
        }
        
        // Portfolio article, custom url.
        if( isset( $_POST['_agama_pt_custom_url'] ) ) {
            $option['_agama_pt_custom_url'] = esc_url_raw( $_POST['_agama_pt_custom_url'] );
            $options = array_merge( $options, $option );
        }
        
        // Posts - Pages - header style.
        if( isset( $_POST['_agama_header_style'] ) ) {
            $option['_agama_header_style'] = esc_attr( $_POST['_agama_header_style'] );
            $options = array_merge( $options, $option );
        }
        
        // Posts - Pages - custom logo.
        if( isset( $_POST['_agama_custom_logo'] ) ) {
            $option['_agama_custom_logo'] = esc_attr( $_POST['_agama_custom_logo'] );
            $options = array_merge( $options, $option );
        }
        
        // Posts - Pages - header image.
        if( isset( $_POST['_agama_header_image'] ) ) {
            $option['_agama_header_image'] = esc_attr( $_POST['_agama_header_image'] );
            $options = array_merge( $options, $option );
        }
        
        // Posts - Pages - enable particles.
        if( isset( $_POST['_agama_header_image_particles'] ) ) {
            $option['_agama_header_image_particles'] = esc_attr( $_POST['_agama_header_image_particles'] );
            $options = array_merge( $options, $option );
        }

		// Posts || Pages - enable slider.
		if( isset( $_POST['_agama_enable_slider'] ) && ! empty( $_POST['_agama_enable_slider'] ) ) {
			$option['_agama_enable_slider'] = esc_attr( $_POST['_agama_enable_slider'] );
			$options = array_merge( $options, $option );
		}

		// Posts || Pages - slider type.
		if( isset( $_POST['_agama_slider_type'] ) && ! empty( $_POST['_agama_slider_type'] ) ) {
			$option['_agama_slider_type'] = sanitize_text_field( $_POST['_agama_slider_type'] );
			$options = array_merge( $options, $option );
		}

		// Posts || Pages - select slider from layer slider sliders.
		if( isset( $_POST['_layer_slider'] ) && ! empty( $_POST['_layer_slider'] ) ) {
			$option['_layer_slider'] = esc_attr( $_POST['_layer_slider'] );
			$options = array_merge( $options, $option );
		}

		// Posts || Pages - select slider from revolution slider sliders.
		if( isset( $_POST['_revolution_slider'] ) && ! empty( $_POST['_revolution_slider'] ) ) {
			$option['_revolution_slider'] = esc_attr( $_POST['_revolution_slider'] );
			$options = array_merge( $options, $option );
		}
		
		// Posts || Pages - Breadcrumb enable / disable.
		if( isset( $_POST['_agama_breadcrumb'] ) ) {
			$option['_agama_breadcrumb'] = esc_attr( $_POST['_agama_breadcrumb'] );
			$options = array_merge( $options, $option );
		}
		
		// Posts || Pages - Breadcrum custom title.
		if( isset( $_POST['_agama_breadcrumb_title'] ) ) {
			$option['_agama_breadcrumb_title'] = esc_attr( $_POST['_agama_breadcrumb_title'] );
			$options = array_merge( $options, $option );
		}
		
		// Posts || Pages - set content top padding.
		if( isset( $_POST['_vision_row_top_padding'] ) ) {
			$option['_vision_row_top_padding'] = esc_attr( $_POST['_vision_row_top_padding'] );
			$options = array_merge( $options, $option );
		}
        
        // Posts || Pages - set custom page background image.
        if( isset( $_POST['_agama_page_bg_img'] ) ) {
            $option['_agama_page_bg_img'] = esc_attr( $_POST['_agama_page_bg_img'] );
            $options = array_merge( $options, $option );
        }
		
		// Posts || Pages - set content bottom padding.
		if( isset( $_POST['_vision_row_bottom_padding'] ) ) {
			$option['_vision_row_bottom_padding'] = esc_attr( $_POST['_vision_row_bottom_padding'] );
			$options = array_merge( $options, $option );
		}

		// Posts || Pages - enable / disable sidebar.
		if( isset( $_POST['_agama_enable_sidebar'] ) && ! empty( $_POST['_agama_enable_sidebar'] ) ) {
			$option['_agama_enable_sidebar'] = esc_attr( $_POST['_agama_enable_sidebar'] );
			$options = array_merge( $options, $option );
		}
		
		// Posts || Pages - enable / disable social share icons.
		if( isset( $_POST['_agama_enable_social_share'] ) && ! empty( $_POST['_agama_enable_social_share'] ) ) {
			$option['_agama_enable_social_share'] = esc_attr( $_POST['_agama_enable_social_share'] );
			$options = array_merge( $options, $option );
		}
        
        // Posts || Pages - video embed code.
        if( isset( $_POST['_agama_post_video'] ) ) {
            $option['_agama_post_video'] = $_POST['_agama_post_video'];
            $options = array_merge( $options, $option );
        }
        
		// Update post or page meta fields.
		foreach( $options as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}
	}

	/**
     * Metabox Content
     *
	 * Render the metabox content.
	 *
	 * @param WP_Post $post (required) The post object.
     *
	 * @since 1.0.1
     * @access public
     * @return mixed
	 */
	public function render_meta_box_content( $post ) {
		$current_screen = get_current_screen();
		
        $portfolio_slug = esc_attr( get_theme_mod( 'agama_portfolio_page_slug', 'agama_portfolio' ) );
        $portfolio_slug = str_replace( ' ', '_', $portfolio_slug );
        
        if( $current_screen->post_type == 'post' ) {
            $tab['page_title'] = esc_html__( 'Post', 'agama-pro' );
        }
        else
        if( $current_screen->post_type == 'page' ) {
            $tab['page_title'] = esc_html__( 'Page', 'agama-pro' );
        } else {
            $tab['page_title'] = esc_html__( 'Post', 'agama-pro' );
        }
        
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'agama_options', 'agama_options_nonce' );
        
        $post_video['embed'] = '';
        if( $this->get_meta( '_agama_post_video', '' ) ) {
            $post_video['embed'] = $this->get_meta( '_agama_post_video', '' );
        }
        
		$sliders = array( 
			'none' 	=> esc_html__( 'Select Slider', 'agama-pro' ),
			'agama'	=> esc_html__( 'Agama Slider', 'agama-pro' )
		);

		// Detect if LayerSlider is installed & put it into slider option array
		if( class_exists( 'LS_Sliders' ) ) {
			$slider['layer'] = esc_html__( 'Layer Slider', 'agama-pro' );
			$sliders = array_merge( $sliders, $slider );
		}
		// Detect if Revolution slider is installed & put it into slider option array
		if( class_exists( 'RevSliderAdmin' ) ) {
			$slider['revolution'] = esc_html__( 'Revolution Slider', 'agama-pro' );
			$sliders = array_merge( $sliders, $slider );
		}
        
        // Get WordPress' media upload URL
        $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
        
        // Custom Logo
        $custom_logo_img_id = get_post_meta( $post->ID, '_agama_custom_logo', true );
        $custom_logo_img_src = wp_get_attachment_image_src( $custom_logo_img_id, 'full' );
        $have_custom_logo_img = is_array( $custom_logo_img_src ); 
        
        // Custom Header Image
        $header_img_id = get_post_meta( $post->ID, '_agama_header_image', true );
        $header_img_src = wp_get_attachment_image_src( $header_img_id, 'full' ); 
        $have_header_img = is_array( $header_img_src ); 
        
        // Page Content Background Image
        $page_bg_img_id = get_post_meta( $post->ID, '_agama_page_bg_img', true );
        $page_bg_img_src = wp_get_attachment_image_src( $page_bg_img_id, 'full' );
        $have_page_bg_img = is_array( $page_bg_img_src ); ?>
        
        <!-- Agama Meta Box Wrapper -->
        <div class="agama-tabs agama-tabs-style-underline">
            <nav>
                <ul>
                    <?php if( $current_screen->post_type == $portfolio_slug ): ?>
                    <li>
                        <a href="#agama-portfolio-section" class="agama-meta-icon agama-meta-icon-portfolio"><span><?php esc_html_e( 'Portfolio', 'agama-pro' ); ?></span></a>
                    </li>
                    <?php endif; ?>
                    <li>
                        <a href="#agama-header-section" class="agama-meta-icon agama-meta-icon-browser"><span><?php esc_html_e( 'Header', 'agama-pro' ); ?></span></a>
                    </li>
                    <li>
                        <a href="#agama-post-section" class="agama-meta-icon agama-meta-icon-news-paper"><span><?php echo $tab['page_title']; ?></span></a>
                    </li>
                    <li>
                        <a href="#agama-slider-section" class="agama-meta-icon agama-meta-icon-map"><span><?php esc_html_e( 'Slider', 'agama-pro' ); ?></span></a>
                    </li>
                    <li>
                        <a href="#agama-breadcrumb-section" class="agama-meta-icon agama-meta-icon-albums"><span><?php esc_html_e( 'Breadcrumb', 'agama-pro' ); ?></span></a>
                    </li>
                </ul>
            </nav>
            <div class="agama-content-wrap">
                
                <?php if( $current_screen->post_type == $portfolio_slug ): ?>
                <!-- Portfolio Section -->
                <section id="agama-portfolio-section">
                    <p>
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_pt_project_info"><?php esc_html_e( 'Project Info Heading', 'agama-pro' ); ?></label>
                            <p class="description"><?php esc_html_e( 'Set custom project info heading text.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <input id="agama_pt_project_info" name="_agama_pt_project_info" type="text" placeholder="<?php esc_html_e( 'Project Info', 'agama-pro' ); ?>" value="<?php echo $this->get_meta( '_agama_pt_project_info', esc_html__( 'Project Info', 'agama-pro' ) ); ?>">
                        </div>
                    </div>
                    <div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_pt_created_by"><?php _e( 'Created By', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'Write portfolio author name.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<input id="agama_pt_created_by" name="_agama_pt_created_by" type="text" placeholder="John Doe" value="<?php echo $this->get_meta('_agama_pt_created_by', ''); ?>">
						</div>
					</div>

					<div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_pt_completed_on"><?php _e( 'Completed On', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'Enter the date of project completion.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<input id="agama_pt_completed_on" name="_agama_pt_completed_on" type="text" placeholder="31 December 2015" value="<?php echo $this->get_meta('_agama_pt_completed_on', ''); ?>">
						</div>
					</div>

					<div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_pt_project_url"><?php _e( 'Project URL', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'The URL the project text links to (on single portfolio page).', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<input id="agama_pt_project_url" name="_agama_pt_project_url" type="text" placeholder="http://" value="<?php echo $this->get_meta('_agama_pt_project_url', '#'); ?>">
						</div>
					</div>

					<div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_pt_project_url_txt"><?php _e( 'Project URL Text', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'The custom project text that will link.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<input id="agama_pt_project_url_txt" name="_agama_pt_project_url_txt" type="text" placeholder="My Project" value="<?php echo $this->get_meta('_agama_pt_project_url_txt', 'My Project'); ?>">
						</div>
					</div>

					<div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_pt_video"><?php _e( 'Video Embed Code', 'agama-pro' ); ?></label><br>
							<p class="description"><?php _e( 'Insert Youtube or Vimeo embed code.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<textarea id="agama_pt_video" name="_agama_pt_video" rows="10"><?php echo $this->get_meta( '_agama_pt_video', '' ); ?></textarea>
						</div>
					</div>
                    
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_pt_rollover_icons"><?php esc_html_e( 'Image Rollover Icons', 'agama-pro' ); ?></label>
                            <p class="description"><?php esc_html_e( 'Choose which icons will be displayed on portfolio image hover.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <select id="agama_pt_rollover_icons" name="_agama_pt_rollover_icons">
                                <option value><?php esc_html_e( 'Default', 'agama-pro' ); ?></option>
                                <option value="linkzoom" <?php selected( 'linkzoom', $this->get_meta('_agama_pt_rollover_icons', '' ), true ); ?>><?php esc_html_e( 'Link + Zoom', 'agama-pro' ); ?></option>
                                <option value="link" <?php selected( 'link', $this->get_meta('_agama_pt_rollover_icons', '' ), true ); ?>><?php esc_html_e( 'Link', 'agama-pro' ); ?></option>
                                <option value="zoom" <?php selected( 'zoom', $this->get_meta('_agama_pt_rollover_icons', '' ), true ); ?>><?php esc_html_e( 'Zoom', 'agama-pro' ); ?></option>
                                <option value="none" <?php selected( 'none', $this->get_meta('_agama_pt_rollover_icons', '' ), true ); ?>><?php esc_html_e( 'No Icons', 'agama-pro' ); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_pt_custom_url"><?php esc_html_e( 'Custom Link URL', 'agama-pro' ); ?></label>
                            <p class="description"><?php esc_html_e( 'If you set custom link url the icon url which is displayed on image rollover will be changed to this one.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <input id="agama_pt_custom_url" name="_agama_pt_custom_url" value="<?php echo $this->get_meta( '_agama_pt_custom_url' ); ?>" placeholder="http://">
                        </div>
                    </div>
                    
                    </p>
                </section><!-- Portfolio Section End -->
                <?php endif; ?>
                
                <!-- Header Section -->
                <section id="agama-header-section">
                    <p>
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_header_style"><?php _e( 'Header Style', 'agama-pro' ); ?></label>
                            <p class="description"><?php _e( 'Select header style for this page / post.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <select id="agama_header_style" name="_agama_header_style">
                                <option value=""><?php _e( 'Default', 'agama-pro' ); ?></option>
                                <option value="none" <?php selected( 'none', $this->get_meta( '_agama_header_style' ), true ); ?>><?php _e( 'None', 'agama-pro' ); ?></option>
                                <option value="v1" <?php selected( 'v1', $this->get_meta( '_agama_header_style' ), true ); ?>><?php _e( 'Header V1', 'agama-pro' ); ?></option>
                                <option value="v2" <?php selected( 'v2', $this->get_meta( '_agama_header_style' ), true ); ?>><?php _e( 'Header V2', 'agama-pro' ); ?></option>
                                <option value="v3" <?php selected( 'v3', $this->get_meta( '_agama_header_style' ), true ); ?>><?php _e( 'Header V3', 'agama-pro' ); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_custom_logo"><?php _e( 'Custom Logo', 'agama-pro' ); ?></label>
                            <p class="description"><?php _e( 'Upload custom logo if you want different logo than on home page.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <div class="agama_custom_logo_container">
                                <?php if( $have_custom_logo_img ): ?>
                                    <img src="<?php echo esc_url( $custom_logo_img_src[0] ); ?>" alt="" style="max-height:50px;">
                                <?php endif; ?>
                            </div>
                            <a class="agama-upload-custom-logo <?php if ( $have_custom_logo_img  ) { echo 'hidden'; } ?> button" href="<?php echo $upload_link; ?>">
                                <?php _e( 'Upload Logo', 'agama-pro' ); ?>
                            </a>
                            <a class="agama-delete-custom-logo <?php if ( ! $have_custom_logo_img  ) { echo 'hidden'; } ?> button" href="#">
                                <?php _e( 'Remove Logo', 'agama-pro' ); ?>
                            </a>
                            <input class="agama-custom-logo" name="_agama_custom_logo" type="hidden" value="<?php echo esc_attr( $custom_logo_img_id ); ?>" />
                        </div>
                    </div>
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_header_image"><?php _e( 'Header Image', 'agama-pro' ); ?></label>
                            <p class="description"><?php _e( 'Upload custom header image.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <div class="agama_header_image_container">
                                <?php if( $have_header_img ): ?>
                                    <img src="<?php echo esc_url( $header_img_src[0] ); ?>" alt="" style="max-height:50px;">
                                <?php endif; ?>
                            </div>
                            <a class="agama-upload-header-image <?php if( $have_header_img ) { echo 'hidden'; } ?> button" href="<?php echo $upload_link; ?>">
                                <?php _e( 'Upload Header Image', 'agama-pro' ); ?>
                            </a>
                            <a class="agama-delete-header-image <?php if ( ! $have_header_img  ) { echo 'hidden'; } ?> button" href="#">
                                <?php _e( 'Remove Header Image', 'agama-pro' ); ?>
                            </a>
                            <input class="agama-header-image" name="_agama_header_image" type="hidden" value="<?php echo esc_attr( $header_img_id ); ?>" />
                        </div>
                    </div>
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_header_image_particles"><?php _e( 'Header Image Particles', 'agama-pro' ); ?></label>
                            <p class="description"><?php _e( 'Enable particles feature on header image.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <select id="agama_header_image_particles" name="_agama_header_image_particles">
								<option value="on" <?php selected( 'on', $this->get_meta('_agama_header_image_particles', 'on' ), true ); ?>><?php _e( 'Enable', 'agama-pro' ); ?></option>
								<option value="off" <?php selected( 'off', $this->get_meta('_agama_header_image_particles', 'on' ), true ); ?>><?php _e( 'Disable', 'agama-pro' ); ?></option>
							</select>
                        </div>
                    </div>
                    </p>
                </section><!-- Header Section End -->
                
                <!-- Post - Page Section -->
                <section id="agama-post-section">
                    <p>
					<div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_content_padding"><?php _e( 'Page Content Padding', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'In pixels. Leave empty for default value of 50px, 50px. Example: 20px', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<div class="vision-dimension">
								<span class="vision-input-icon">
									<i class="dashicons dashicons-arrow-up-alt"></i>
								</span>
								<input id="agama_content_padding" type="text" name="_vision_row_top_padding" value="<?php echo esc_attr( $this->get_meta('_vision_row_top_padding', '') ); ?>">
							</div>
							<div class="vision-dimension">
								<span class="vision-input-icon">
									<i class="dashicons dashicons-arrow-down-alt"></i>
								</span>
								<input type="text" name="_vision_row_bottom_padding" value="<?php echo esc_attr( $this->get_meta('_vision_row_bottom_padding', '') ); ?>">
							</div>
						</div>
					</div>
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_content_background"><?php esc_html_e( 'Page Content Background', 'agama-pro' ); ?></label>
                            <p class="description"><?php esc_html_e( 'Add page content custom image background.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <div class="agama_page_bg_img_container">
                                <?php if( $have_page_bg_img ): ?>
                                    <img src="<?php echo esc_url( $page_bg_img_src[0] ); ?>" alt="" style="max-height:50px;">
                                <?php endif; ?>
                            </div>
                            <a class="agama-upload-page-bg-img <?php if ( $have_page_bg_img ) { echo 'hidden'; } ?> button" href="<?php echo $upload_link; ?>">
                                <?php esc_html_e( 'Upload Page Background', 'agama-pro' ); ?>
                            </a>
                            <a class="agama-delete-page-bg-img <?php if ( ! $have_page_bg_img ) { echo 'hidden'; } ?> button" href="#">
                                <?php esc_html_e( 'Remove Page Background', 'agama-pro' ); ?>
                            </a>
                            <input class="agama-page-bg-img" name="_agama_page_bg_img" type="hidden" value="<?php echo esc_attr( $page_bg_img_id ); ?>" />
                        </div>
                    </div>
					<div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_enable_sidebar"><?php _e( 'Enable Sidebar', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'You can disable sidebar for this post / page.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<select id="agama_enable_sidebar" name="_agama_enable_sidebar">
								<option value="on" <?php selected( 'on', $this->get_meta('_agama_enable_sidebar', 'on' ), true ); ?>><?php _e( 'Enable', 'agama-pro' ); ?></option>
								<option value="off" <?php selected( 'off', $this->get_meta('_agama_enable_sidebar', 'on' ), true ); ?>><?php _e( 'Disable', 'agama-pro' ); ?></option>
							</select>
						</div>
					</div>
					<div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_enable_social_share"><?php _e( 'Enable Social Share', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'You can disable social share icons for this post / page.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<select id="agama_enable_social_share" name="_agama_enable_social_share">
								<option value="on" <?php selected( 'on', $this->get_meta('_agama_enable_social_share', 'on'), true ); ?>><?php _e( 'Enable', 'agama-pro' ); ?></option>
								<option value="off" <?php selected( 'off', $this->get_meta('_agama_enable_social_share', 'on'), true ); ?>><?php _e( 'Disable', 'agama-pro' ); ?></option>
							</select>
						</div>
					</div>   
                    <?php if( $current_screen->post_type == 'post' ): ?>
                    <div class="agama-row">
                        <div class="agama-row-left">
                            <label for="agama_post_embed_video"><?php _e( 'Embed Video Code', 'agama-pro' ); ?></label>
                            <p class="description"><?php _e( 'Insert Youtube or Vimeo embed code.', 'agama-pro' ); ?></p>
                        </div>
                        <div class="agama-row-right">
                            <textarea id="agama_post_embed_video" name="_agama_post_video" rows="10"><?php echo $post_video['embed']; ?></textarea>
                        </div>
                    </div>
                    <?php endif; ?>
                    </p>
                </section><!-- Post - Page Section End -->
                
                <!-- Slider Section -->
                <section id="agama-slider-section">
                    <p>
                    <div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_enable_slider" class="agama-control-label"><?php _e( 'Enable Slider', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'You can enable slider for this post / page.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
                            <select id="agama_enable_slider" name="_agama_enable_slider">
                                <option value="on" <?php selected( 'on', $this->get_meta('_agama_enable_slider', 'off'), true ); ?>><?php _e( 'Enable', 'agama-pro' ); ?></option>
                                <option value="off" <?php selected( 'off', $this->get_meta('_agama_enable_slider', 'off'), true ); ?>><?php _e( 'Disable', 'agama-pro' ); ?></option>
                            </select>
						</div>
					</div>
					<div id="agama_slider_type" class="agama-row">
						<div class="agama-row-left">
							<label for="agama-slider-type-select"><?php _e( 'Slider Type', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'Select what type of slider you want to use for post / page.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<select id="agama-slider-type-select" name="_agama_slider_type">
							<?php foreach( $sliders as $key => $value ): ?>
								<option value="<?php echo $key; ?>" <?php selected( $key, $this->get_meta('_agama_slider_type'), true ); ?>><?php echo $value; ?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div id="agama_layer_slider" class="agama-row">
						<div class="agama-row-left">
							<label for="agama_layer_slider"><?php _e( 'Layer Slider', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'Select Layer slider you want display on post / page.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<select id="agama_layer_slider" name="_layer_slider">
								<option value="0"><?php _e( 'Select Slider', 'agama-pro' ); ?></option>
								<?php $this->slider_dropdown('layer'); ?>
							</select>
						</div>
					</div>
					<div id="agama_revolution_slider" class="agama-row">
						<div class="agama-row-left">
							<label for="agama_revolution_slider"><?php _e( 'Revolution Slider', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'Select Revolution slider you want display on post / page.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<select id="agama_revolution_slider" name="_revolution_slider">
								<option value="0"><?php _e( 'Select Slider', 'agama-pro' ); ?></option>
								<?php $this->slider_dropdown('revolution'); ?>
							</select>
						</div>
					</div>
                    </p>
                </section><!-- Slider Section End -->
                
                <!-- Breadcrumb Section -->
                <section id="agama-breadcrumb-section">
                    <p>
                    <div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_enable_breadcrumb"><?php _e( 'Breadcrumb', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'Enable or disalbe the breadcrumb for this post | page.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<select id="agama_enable_breadcrumb" name="_agama_breadcrumb">
								<option value="on" <?php selected( 'on', $this->get_meta('_agama_breadcrumb', 'on'), true ); ?>><?php _e( 'Enabled', 'agama-pro' ); ?></option>
								<option value="off" <?php selected( 'off', $this->get_meta('_agama_breadcrumb', 'on'), true ); ?>><?php _e( 'Disabled', 'agama-pro' ); ?></option>
							</select>
						</div>
					</div>
					<div class="agama-row">
						<div class="agama-row-left">
							<label for="agama_breadcrumb_title"><?php _e( 'Breadcrumb Page Title', 'agama-pro' ); ?></label>
							<p class="description"><?php _e( 'Set custom breadcrum page title. This will override default page title.', 'agama-pro' ); ?></p>
						</div>
						<div class="agama-row-right">
							<input id="agama_breadcrumb_title" type="text" name="_agama_breadcrumb_title" value="<?php echo $this->get_meta('_agama_breadcrumb_title', ''); ?>">
						</div>
					</div>
                    </p>
                </section><!-- Breadcrumb Section End -->
                
            </div>
        </div><!-- Agama Meta Box Wrapper End -->
	<?php
	}

	/**
     * Slider Dropdown
     *
	 * The available sliders in dropdown select list.
	 *
	 * @since 1.0.1
     * @access private
     * @return mixed
	 */
	private function slider_dropdown( $slider ) {
		global $wpdb;
		if( $slider == 'layer' && class_exists( 'LS_Sliders' ) ) {
			$table_name = $wpdb->prefix . "layerslider";
			// Get sliders
			$sliders = $wpdb->get_results(
				"SELECT $table_name.id, $table_name.name FROM $table_name
				WHERE flag_hidden = '0' AND flag_deleted = '0'
				ORDER BY date_c ASC"
			);
			// Output dropdown
			if( $sliders ):
			foreach( $sliders as $slider ){

				echo '<option value="'.$slider->id.'" '.selected( $this->get_meta('_layer_slider'), $slider->id, false ).'>'.$slider->name.'</option>';
			}
			endif;
		}
		else
		if( $slider == 'revolution' && class_exists( 'RevSliderAdmin' ) ) {
			$table = $wpdb->prefix.'revslider_sliders';
			// Get sliders
			$revquery = "SELECT $table.id, $table.title FROM $table ORDER BY $table.id DESC";
			$revsliders = $wpdb->get_results($revquery, ARRAY_A);
			// Output dropdown
			if( $revsliders ):
			foreach( $revsliders as $slider ) {
				echo '<option value="'.$slider['id'].'" '.selected( $this->get_meta('_revolution_slider'), $slider['id'], false ).'>'.$slider['title'].'</option>';
			}
			endif;
		}
	}
}

/**
 * Callback
 *
 * The metabox class callback.
 *
 * @since 1.0.1
 * @since 1.4.9.2 Updated the code.
 * @return mixed
 */
function callback() {
    Metabox::get_instance();
}

// Fire callback on admin dashboard
if ( is_admin() ) {
    add_action( 'load-post.php', __NAMESPACE__ . '\callback' );
    add_action( 'load-post-new.php', __NAMESPACE__ . '\callback' );
}
