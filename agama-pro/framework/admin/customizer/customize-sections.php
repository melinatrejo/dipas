<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

Kirki::add_section( 'agama_page_builder_section', array(
    'title'     => esc_attr__( 'Page Builder', 'agama-pro' ),
    'priority'  => 1
) );
Kirki::add_section( 'title_tagline', array( 
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'title_tagline_panel'
) );
Kirki::add_section( 'title_tagline_styling', array( 
    'title'		=> esc_attr__( 'Styling', 'agama-pro' ),
    'panel'		=> 'title_tagline_panel'
) );
Kirki::add_section( 'title_tagline_typo', array(
    'title'		=> esc_attr__( 'Typography', 'agama-pro' ),
    'panel'		=> 'title_tagline_panel'
) );
Kirki::add_section( 'background_image', array(
    'title'     => esc_attr__( 'Body', 'agama-pro' ),
    'panel'	    => 'agama_general_panel'
) );
Kirki::add_section( 'agama_skins_section', array(
    'title'		=> esc_attr__( 'Skins', 'agama-pro' ),
    'panel'		=> 'agama_general_panel'
) );
Kirki::add_section( 'agama_extra_section', array(
    'title'		=> esc_attr__( 'Extra', 'agama-pro' ),
    'panel'		=> 'agama_general_panel'
) );
Kirki::add_section( 'agama_headings_section', array(
    'title'		=> esc_attr__( 'Headings', 'agama-pro' ),
    'panel'		=> 'agama_general_panel'
) );
Kirki::add_section( 'agama_pages_section', array(
    'title'		=> esc_attr__( 'Pages', 'agama-pro' ),
    'panel'		=> 'agama_general_panel'
) );
Kirki::add_section( 'agama_comments_section', array(
    'title'		=> esc_attr__( 'Comments', 'agama-pro' ),
    'panel'		=> 'agama_general_panel'
) );
Kirki::add_section( 'agama_preloader_section', array(
    'title'		=> esc_attr__( 'Pre-Loader', 'agama-pro' ),
    'panel'		=> 'agama_general_panel'
) );
Kirki::add_section( 'static_front_page', array(
    'title'		=> esc_attr__( 'Static Front Page', 'agama-pro' ),
    'panel'		=> 'agama_general_panel'
) );
Kirki::add_section( 'custom_css', array(
    'title'		=> esc_attr__( 'Additional CSS', 'agama-pro' ),
    'panel'		=> 'agama_general_panel'
) );
Kirki::add_section( 'agama_header_section', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'agama_header_panel'
) );
Kirki::add_section( 'agama_header_logo_section', array(
    'title'		=> esc_attr__( 'Logo', 'agama-pro' ),
    'panel'		=> 'agama_header_panel'
) );
Kirki::add_section( 'agama_header_styling_section', array(
    'title'		=> esc_attr__( 'Styling', 'agama-pro' ),
    'panel'		=> 'agama_header_panel'
) );
Kirki::add_section( 'agama_header_image_section', array(
    'title'		=> esc_attr__( 'Header Image', 'agama-pro' ),
    'panel'		=> 'agama_header_panel'
) );
Kirki::add_section( 'agama_header_video_section', array(
    'title'		=> esc_attr__( 'Header Video', 'agama-pro' ),
    'panel'		=> 'agama_header_panel'
) );
Kirki::add_section( 'agama_navigation_top_section', array(
    'title'		=> esc_attr__( 'Navigation Top', 'agama-pro' ),
    'panel'		=> 'agama_navigations_panel',
) );
Kirki::add_section( 'agama_navigation_primary_section', array(
    'title'		=> esc_attr__( 'Navigation Primary', 'agama-pro' ),
    'panel'		=> 'agama_navigations_panel',
) );
Kirki::add_section( 'agama_navigation_mobile_section', array(
    'title'		=> esc_attr__( 'Navigation Mobile', 'agama-pro' ),
    'panel'		=> 'agama_navigations_panel',
) );
Kirki::add_section( 'agama_layout_section', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'agama_layout_panel'
) );
Kirki::add_section( 'agama_sidebar_section', array(
    'title'		=> esc_attr__( 'Sidebar', 'agama-pro' ),
    'panel'		=> 'agama_layout_panel'
) );
Kirki::add_section( 'agama_slider_general_section', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slider_particles_section', array(
    'title'		=> esc_attr__( 'Particles', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_1_styling_section', array(
    'title'		=> esc_attr__( 'Styling', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_1_section', array(
    'title'		=> esc_attr__( 'Slide #1', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_2_section', array(
    'title'		=> esc_attr__( 'Slide #2', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_3_section', array(
    'title'		=> esc_attr__( 'Slide #3', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_4_section', array(
    'title'		=> esc_attr__( 'Slide #4', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_5_section', array(
    'title'		=> esc_attr__( 'Slide #5', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_6_section', array(
    'title'		=> esc_attr__( 'Slide #6', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_7_section', array(
    'title'		=> esc_attr__( 'Slide #7', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_8_section', array(
    'title'		=> esc_attr__( 'Slide #8', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_9_section', array(
    'title'		=> esc_attr__( 'Slide #9', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_slide_10_section', array(
    'title'		=> esc_attr__( 'Slide #10', 'agama-pro' ),
    'panel'		=> 'agama_slider_panel',
) );
Kirki::add_section( 'agama_breadcrumb_general_section', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'agama_breadcrumb_panel'
) );
Kirki::add_section( 'agama_breadcrumb_styling_section', array(
    'title'		=> esc_attr__( 'Styling', 'agama-pro' ),
    'panel'		=> 'agama_breadcrumb_panel'
) );
Kirki::add_section( 'agama_breadcrumb_typography_section', array(
    'title'		=> esc_attr__( 'Typography', 'agama-pro' ),
    'panel'		=> 'agama_breadcrumb_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_general_section', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_section_1', array(
    'title'		=> esc_attr__( 'Front Page Box #1', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_section_2', array(
    'title'		=> esc_attr__( 'Front Page Box #2', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_section_3', array(
    'title'		=> esc_attr__( 'Front Page Box #3', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_section_4', array(
    'title'		=> esc_attr__( 'Front Page Box #4', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_section_5', array(
    'title'		=> esc_attr__( 'Front Page Box #5', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_section_6', array(
    'title'		=> esc_attr__( 'Front Page Box #6', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_section_7', array(
    'title'		=> esc_attr__( 'Front Page Box #7', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_frontpage_boxes_section_8', array(
    'title'		=> esc_attr__( 'Front Page Box #8', 'agama-pro' ),
    'panel'		=> 'agama_frontpage_boxes_panel'
) );
Kirki::add_section( 'agama_blog_section', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'agama_blog_panel'
) );
Kirki::add_section( 'agama_blog_single_post_section', array(
    'title'		=> esc_attr__( 'Single Post', 'agama-pro' ),
    'panel'		=> 'agama_blog_panel'
) );
Kirki::add_section( 'agama_blog_meta_section', array(
    'title'		=> esc_attr__( 'Post Meta', 'agama-pro' ),
    'panel'		=> 'agama_blog_panel'
) );
Kirki::add_section( 'agama_portfolio_section', array(
    'title'		=> esc_attr__( 'Portfolio', 'agama-pro' ),
    'priority'	=> 100
) );
Kirki::add_section( 'agama_social_icons_section', array(
    'title'		=> esc_attr__( 'Social Icons', 'agama-pro' ),
    'priority'	=> 110,
) );
Kirki::add_section( 'agama_share_icons_section', array(
    'title'		=> esc_attr__( 'Social Share', 'agama-pro' ),
    'priority'	=> 120,
) );
Kirki::add_section( 'agama_woocommerce_general_section', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'woocommerce',
    'priority'  => 1
) );
Kirki::add_section( 'agama_woocommerce_styling_section', array(
    'title'		=> esc_attr__( 'Styling', 'agama-pro' ),
    'panel'		=> 'woocommerce',
    'priority'  => 1
) );
Kirki::add_section( 'agama_woocommerce_single_products_section', array(
    'title'     => esc_attr__( 'Single Products', 'agama-pro' ),
    'panel'     => 'woocommerce'
) );
Kirki::add_section( 'agama_contact_section', array(
    'title'		=> esc_attr__( 'Contact', 'agama-pro' ),
    'priority'	=> 160
) );
Kirki::add_section( 'agama_footer_general_section', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'panel'		=> 'agama_footer_panel'
) );
Kirki::add_section( 'agama_footer_styling_section', array(
    'title'		=> esc_attr__( 'Styling', 'agama-pro' ),
    'panel'		=> 'agama_footer_panel'
) );
Kirki::add_section( 'agama_footer_widgets_section', array(
    'title'		=> esc_attr__( 'Widgets', 'agama-pro' ),
    'panel'		=> 'agama_footer_panel'
) );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
