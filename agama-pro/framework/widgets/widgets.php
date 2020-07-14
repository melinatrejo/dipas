<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_template_part( 'framework/widgets/widget-about' );
get_template_part( 'framework/widgets/flickr_widget' );
get_template_part( 'framework/widgets/facebook_like_widget' );
get_template_part( 'framework/widgets/tabs_widget' );
get_template_part( 'framework/widgets/widget-google-maps' );

/**
 * Register Widgets & Sidebars
 * 
 * @since Agama v1.0
 */
if( ! class_exists( 'Agama_Widgets' ) ) {
	class Agama_Widgets
	{
		public function __construct() {
			add_action( 'widgets_init', array( $this, 'init' ) );
		}
		
		function init() {
			register_sidebar( array(
				'name'			=> esc_attr__( 'Main Sidebar', 'agama-pro' ),
				'id'			=> 'sidebar-1',
				'description'	=> esc_attr__( 'Appears on posts and pages.', 'agama-pro' ),
				'before_widget'	=> '<aside id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</aside>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '</h3>',
			) );
			
			if( class_exists( 'Woocommerce' ) ) {
				register_sidebar( array(
					'name'			=> __( 'Shop Sidebar', 'agama-pro' ),
					'id'			=> 'agama-shop-sidebar',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' 	=> '</aside>',
					'before_title' 	=> '<h3 class="widget-title">',
					'after_title' 	=> '</h3>',
				) );
			}

			register_sidebar( array(
				'name' 			=> esc_attr__( 'Footer Widget 1', 'agama-pro' ),
				'id' 			=> 'footer-widget-1',
				'description' 	=> esc_attr__( 'Appears on footer area.', 'agama-pro' ),
				'before_widget'	=> '<aside id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</aside>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
			) );
			
			register_sidebar( array(
				'name' 			=> esc_attr__( 'Footer Widget 2', 'agama-pro' ),
				'id' 			=> 'footer-widget-2',
				'description'	=> esc_attr__( 'Appears on footer area.', 'agama-pro' ),
				'before_widget'	=> '<aside id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</aside>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '</h3>',
			) );
			
			register_sidebar( array(
				'name'			=> esc_attr__( 'Footer Widget 3', 'agama-pro' ),
				'id' 			=> 'footer-widget-3',
				'description' 	=> esc_attr__( 'Appears on footer area.', 'agama-pro' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</aside>',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
			) );
			
			register_sidebar( array(
				'name' 			=> esc_attr__( 'Footer Widget 4', 'agama-pro' ),
				'id' 			=> 'footer-widget-4',
				'description' 	=> esc_attr__( 'Appears on footer area.', 'agama-pro' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</aside>',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
			) );
            
            register_sidebar( array(
				'name' 			=> esc_attr__( 'Footer Widget 5', 'agama-pro' ),
				'id' 			=> 'footer-widget-5',
				'description' 	=> esc_attr__( 'Appears on footer area.', 'agama-pro' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</aside>',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
			) );
            
            register_sidebar( array(
				'name' 			=> esc_attr__( 'Footer Widget 6', 'agama-pro' ),
				'id' 			=> 'footer-widget-6',
				'description' 	=> esc_attr__( 'Appears on footer area.', 'agama-pro' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</aside>',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
			) );
            
            /**
             * Register Page Widgets
             *
             * @since 1.4.7
             */
            if( ! is_admin() || is_customize_preview() ) {
                $pages = get_pages();
                if( is_array( $pages ) ) {
                    foreach( $pages as $page ) {
                        register_sidebar( array(
                            'name'          => $page->post_title,
                            'id'            => 'page-widget-' . esc_attr( $page->ID ),
                            'description'   => esc_attr__( 'Appears on', 'agama-pro' ) .' '. esc_html( $page->post_title ),
                            'before_widget' => '<div id="%1$s" class="page-widget %2$s">',
                            'after_widget'  => '</div>',
                            'before_title'  => '<h2 class="widget-title">',
                            'after_title'   => '</h2>',
                        ) );
                    }
                }
            }
		}
	}
	new Agama_Widgets;
}


