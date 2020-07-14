<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

Kirki::add_panel( 'title_tagline_panel', array(
    'title'		=> esc_attr__( 'Site Identity', 'agama-pro' ),
    'priority'	=> 2
) );
Kirki::add_panel( 'agama_general_panel', array(
    'title'		=> esc_attr__( 'General', 'agama-pro' ),
    'priority'	=> 10
) );
Kirki::add_panel( 'agama_header_panel', array(
    'title'		=> esc_attr__( 'Header', 'agama-pro' ),
    'priority'	=> 20
) );
Kirki::add_panel( 'agama_navigations_panel', array( 
    'title'		=> esc_attr__( 'Navigations', 'agama-pro' ),
    'priority'	=> 30,
) );
Kirki::add_panel( 'agama_layout_panel', array(
    'title'		=> esc_attr__( 'Layout', 'agama-pro' ),
    'priority'	=> 40
) );
Kirki::add_panel( 'agama_slider_panel', array(
    'title'		=> esc_attr__( 'Slider', 'agama-pro' ),
    'priority'	=> 50,
) );
Kirki::add_panel( 'nav_menus', array(
    'title'		=> esc_attr__( 'Menus', 'agama-pro' ),
    'priority'	=> 60
) );
Kirki::add_panel( 'agama_breadcrumb_panel', array(
    'title'		=> esc_attr__( 'Breadcrumb', 'agama-pro' ),
    'priority'	=> 70
) );
Kirki::add_panel( 'agama_frontpage_boxes_panel', array(
    'title'		=> esc_attr__( 'Front Page Boxes', 'agama-pro' ),
    'priority'	=> 80
) );
Kirki::add_panel( 'agama_blog_panel', array(
    'title'		=> esc_attr__( 'Blog', 'agama-pro' ),
    'priority'	=> 90
) );
Kirki::add_panel( 'woocommerce', array(
    'title'     => esc_attr__( 'WooCommerce', 'agama-pro' ),
    'priority'  => 130
) );
Kirki::add_panel( 'widgets', array(
    'title'		=> esc_attr__( 'Widgets', 'agama-pro' ),
    'priority'	=> 150
) );
Kirki::add_panel( 'agama_footer_panel', array(
    'title'		=> esc_attr__( 'Footer', 'agama-pro' ),
    'priority'	=> 170
) );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
