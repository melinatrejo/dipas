<?php 
/**
 * Helper
 *
 * The Agama helper class.
 *
 * @since 1.3.7
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama;

use Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Helper {

    /**
     * PolyLang
     *
     * Echo PolyLang strings registered for translation.
     *
     * @param string $string (required) The string for echo.
     *
     * @since 1.3.6.10
     */
    public static function pll_e( $string ) {
        if( function_exists( 'pll__' ) ) {
            echo pll__( $string );
        } else {
            echo $string;
        }
    }

    /**
     * Header Class
     *
     * @since 1.3.0
     */
    public static function the_header_class() {
        $desktop = esc_url( get_theme_mod( 'agama_logo', '' ) );
        $mobile  = esc_url( get_theme_mod( 'agama_mobile_logo', '' ) );
        $align   = esc_attr( get_theme_mod( 'agama_logo_align', 'left' ) );
        $device  = array();

        if( ! empty( $desktop ) ) {
            $device[] = 'has_desktop';
        }

        if( ! empty( $mobile ) ) {
            $device[] = 'has_mobile';
        }
        
        if( 'center' == $align ) {
            $align = 'logo-center ';
        } else {
            $align = '';
        }

        switch( agama_header_style() ) {
            case 'v1':
                 $class = 'header_v1 ' . $align . implode( ' ', $device );
            break;
            case 'v2':
                 $class = 'header_v2 ' . $align . implode( ' ', $device );
            break;
            case 'v3':
                 $class = 'header_v3 ' . $align . implode( ' ', $device );
            break;
            case 'v4':
                 $class = 'header_v4 ' . $align . implode( ' ', $device );
            break;
            default: $class = 'header_v3 ' . $align . implode( ' ', $device );
        }
        echo esc_attr( $class );
    }

    /**
     * Get Pages ID
     *
     * @since 1.3.0
     */
    // remove shop page from list !!!!!!
    public static function get_pages_id( $pages ) {
        if( ! empty( $pages ) && is_array( $pages ) ) {
            foreach( $pages as $page ) {
                $page_id[] = $page;
            }
            return $page_id;
        }
        return false;
    }

    /**
     * Register Featured Image
     *
     * @since 1.4.5
     */
    public static function register_featured_image( $label ) {
        $id = strtolower( $label );
        $id = str_replace( ' ', '-', $id );

        $label_set      = esc_html__( 'Set', 'agama-pro' ) .' '. esc_html( $label );
        $label_remove   = esc_html__( 'Remove', 'agama-pro' ) .' '. esc_html( $label );

        $pt_post_type = esc_attr( get_theme_mod( 'agama_portfolio_page_slug', 'agama_portfolio' ) );
        $pt_post_type = strtolower( $pt_post_type );
        $pt_post_type = str_replace( ' ', '_', $pt_post_type );
        $pt_post_type = array( $pt_post_type );

        $post_types = array(
            'post',
            'page'
        );

        $post_types = array_merge( $pt_post_type, $post_types );

        $args = array(
            'id'            => esc_attr( $id  ),
            'label_name'    => esc_html( $label ),
            'label_set'     => esc_html( $label_set ),
            'label_remove'  => esc_html( $label_remove ),
            'label_use'     => esc_html( $label_set ),
            'post_type'     => $post_types
        );

        return $args;
    }

    /**
     * Get Blog Grid Wrapper Isotope Data
     *
     * @since 1.3.9
     */
    public static function get_blog_isotope_class() {
        if( ! is_single() && get_theme_mod( 'agama_blog_layout', 'list' ) == 'grid' ) {
            echo 'class="js-isotope"';
        }
    }

     /**
     * Search Box
     *
     * @since 1.4.0
     */
    public static function get_search_box() {
        if( get_theme_mod( 'agama_header_search', true ) ) {
            $output = '<div class="vision-search-box">';
                $output .= '<form method="get" action="'. home_url( '/' ) .'">';
                    $output .= '<input class="vision-search-input" name="s" type="text" value="'. get_search_query() .'" placeholder="'. __( 'Search...', 'agama-pro') .'" />';
                    $output .= '<input type="submit" class="vision-search-submit" value>';
                    $output .= '<i class="fa fa-search"></i>';
                $output .= '</form>';
            $output .= '</div>';

            return $output;
        }
    }

    /**
     * Agama Pagination
     *
     * @since 1.1.2
     */
    public static function get_pagination() {
        global $wp_query;

        $enabled            = esc_attr( get_theme_mod( 'agama_blog_pagination', true ) );
        $infinite_scroll    = esc_attr( get_theme_mod( 'agama_blog_infinite_scroll', false ) );

        if( $enabled ) {

            $big        = 999999999;
            $translated = esc_html__( 'Page', 'agama-pro' );

            $prev_link = get_previous_posts_link( __( '&laquo; Older Entries', 'agama-pro' ) );
            $next_link = get_next_posts_link( __( 'Newer Entries &raquo;', 'agama-pro' ) );

            // Fix Paged on Static Homepage
            if( get_query_var('paged') ) {
                $paged = get_query_var('paged');
            }
            elseif( get_query_var('page') ) {
                $paged = get_query_var('page');
            } else { 
                $paged = 1; 
            }

            if( $wp_query->max_num_pages > 1 ) {

                if( $infinite_scroll ) {
                    $class = esc_attr( 'clearfix display-none' );
                } else {
                    $class = esc_attr( 'clearfix' );
                }

                echo '<div id="vision-pagination" class="'. $class .'">';

                echo paginate_links( array(
                    'base'                  => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'                => '?paged=%#%',
                    'current'               => max( 1, $paged ),
                    'total'                 => $wp_query->max_num_pages,
                    'before_page_number'    => '<span class="screen-reader-text">' . $translated . '</span>'
                ) );

                echo '</div>';
            }
        }
    }

    /**
     * Single Post Prev - Next Article Navigation
     */
    public static function get_single_post_nav() {
        $enabled = esc_attr( get_theme_mod( 'agama_blog_post_prev_next_nav', true ) );
        if( $enabled ) { ?>
            <!-- Article Navigation -->
            <nav class="nav-single">
                <h3 class="assistive-text"><?php _e( 'Post navigation', 'agama-pro' ); ?></h3>
                <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'agama-pro' ) . '</span> %title' ); ?></span>
                <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'agama-pro' ) . '</span>' ); ?></span>
            </nav><!-- Article Navigation End -->
        <?php }
    }

    /**
     * Blog Infinite Scroll Load More Button
     *
     * @since 1.4.1.1
     */
    public static function get_infinite_scroll_load_more_btn() {
        $enabled    = esc_attr( get_theme_mod( 'agama_blog_infinite_scroll', false ) );
        $trigger    = esc_attr( get_theme_mod( 'agama_blog_infinite_trigger', 'button' ) );
        $pagination = esc_attr( get_theme_mod( 'agama_blog_pagination', true ) );
        if( $enabled && $pagination ) {
            echo '<div class="infscr-load-status">';
                echo '<div class="loader-ellips infinite-scroll-request">';
                    echo '<span class="loader-ellips__dot"></span>';
                    echo '<span class="loader-ellips__dot"></span>';
                    echo '<span class="loader-ellips__dot"></span>';
                    echo '<span class="loader-ellips__dot"></span>';
                echo '</div>';
            echo '</div>';
        }
        if( $enabled && $trigger == 'button' && $pagination ) {
            echo '<a id="infinite-loadmore" class="button button-3d button-rounded">';
                echo '<i class="fa fa-spinner fa-spin"></i> ' . __( 'Load More', 'agama-pro' );
            echo '</a>';
        }
    }

    /**
     * Generate Stop Header Shrink CSS
     *
     * @since 1.4.3
     */
    public static function generate_stop_header_shrink_css() {
        $header_shrink = esc_attr( get_theme_mod( 'agama_header_shrink', true ) );
        if( ! $header_shrink ) {
            $css  = '.site-header .sticky-header.sticky-header-shrink h1,';
            $css .= '.site-header .sticky-header.sticky-header-shrink h1 a,';
            $css .= '.sticky-header-shrink .sticky-nav li a { line-height: 87px; }';

            return $css;
        }
    }

    /**
     * Generate Layout Width CSS
     *
     * @since 1.4.0
     */
    public static function generate_layout_width_css() {
        $css = '';

        $style     = esc_attr( get_theme_mod( 'agama_layout_style', 'fullwidth' ) );
        $max_width = esc_attr( get_theme_mod( 'agama_layout_max_width', '1200' ) );
        $max_width = str_replace( 'px', '', $max_width );
        $max_width = str_replace( '%', '', $max_width );

        $vision_row['max_width'] = $max_width - 100;

        switch( $style ) {
            case 'fullwidth':
                $css .= '#main-wrapper { max-width: 100%; }';
                $css .= '.site-header .sticky-header .sticky-header-inner, .vision-row, .footer-sub-wrapper {';
                    $css .= 'max-width: '. $max_width .'px;';
                $css .= '}';
                $css .= '#page-title .container {';
                    $css .= 'width: '. $max_width .'px;';
                $css .= '}';
            break;
            case 'boxed':
                $css .= '#main-wrapper, header .sticky-header, .site-header .sticky-header .sticky-header-inner, .footer-sub-wrapper {';
                    $css .= 'max-width: '. $max_width . 'px;';
                $css .= '}';
                $css .= '#page-title .container {';
                    $css .= 'width: '. $max_width .'px;';
                $css .= '}';
                $css .= '.vision-row {';
                    $css .= 'max-width: '. $vision_row['max_width'] .'px;';
                $css .= '}';
            break;
        }

        return ! empty( $css ) ? $css : '';
    }

    /**
     * Generate Logo Align CSS
     *
     * @since 1.4.0
     */
    public static function generate_logo_align_css() {
        $css    = '';
        $align  = esc_attr( get_theme_mod( 'agama_logo_align', 'left' ) );

        if( $align == 'center' ) {
            if( 'v1' == agama_header_style() ) {
                $css .= '#masthead .site-title, #masthead .site-description, #masthead .logo {';
                    $css .= 'display: block;';
                    $css .= 'text-align: center;';
                    $css .= 'margin: 0 auto;';
                $css .= '}';
            }
            if( 'v2' == agama_header_style() ) {
                $css .= '@media screen and (min-width:992px) {';
                    $css .= '#masthead .pull-left, #masthead .site-title {';
                        $css .= 'float: none;';
                        $css .= 'text-align: center;';
                    $css .= '}';
                
                    $css .= '#masthead .pull-right {';
                        $css .= 'float: none;';
                        $css .= 'width: 100%;';
                    $css .= '}';
                    $css .= '#masthead .sticky-header ul {';
                        $css .= 'float: none;';
                    $css .= '}';
                $css .= '}';
            }
            if( 'v3' == agama_header_style() ) {
                $css .= '@media screen and (min-width:992px) {';
                    $css .= '#masthead .sticky-header .pull-left, #masthead .site-title {';
                        $css .= 'float: none;';
                        $css .= 'text-align: center;';
                    $css .= '}';
                    $css .= '#masthead .sticky-header .pull-right {';
                        $css .= 'float: none;';
                        $css .= 'width: 100%;';
                    $css .= '}';
                    $css .= '#masthead .sticky-header ul {';
                        $css .= 'float: none;';
                    $css .= '}';
                $css .= '}';
            }

            return ! empty( $css ) ? $css : '';
        }
    }

    /**
     * Generate Vision Row CSS
     *
     * @since 1.4.0
     */
    public static function generate_vision_row_css() {
        $css = '';

        $vision_row['padding-top'] 		= esc_attr( Agama::get_meta( '_vision_row_top_padding', '' ) );
        $vision_row['padding-bottom'] 	= esc_attr( Agama::get_meta( '_vision_row_bottom_padding', '' ) );

        if( $vision_row['padding-top'] ) {
            $vision_row['padding-top'] = 'padding-top: '. str_replace( 'px', '', $vision_row['padding-top'] ) .'px !important;';
        }
        if( $vision_row['padding-bottom'] ) {
            $vision_row['padding-bottom'] = 'padding-bottom: '. str_replace( 'px', '', $vision_row['padding-bottom'] ) .'px !important;';
        }
        if( $vision_row['padding-top'] || $vision_row['padding-bottom'] ) {
            $css = '.vision-row {';
                $css .= $vision_row['padding-top'];
                $css .= $vision_row['padding-bottom'];
            $css .= '}';
        }

        return ! empty( $css ) ? $css : '';
    }

    /**
     * Generate 404 Page CSS
     *
     * @since 1.4.0
     */
    public static function generate_404_page_css() {
        $css = '';

        switch( is_404() ) {
            case true:
                $css .= '.vision-page-title-secondary {';
                    $css .= 'display: none;';
                $css .= '}';
                $css .= 'body.vision-404 h1.entry-title {';
                    $css .= 'font-size: 30px;';
                $css .= '}';
                $css .= 'body.vision-404 .entry-content p.desc-404 {';
                    $css .= 'font-size: 18px;';
                $css .= '}';
                $css .= 'body.vision-404 .entry-content p.num-404 {';
                    $css .= 'font-size: 240px;';
                    $css .= 'line-height: 1;';
                $css .= '}';
            break;
        }
        return ! empty( $css ) ? $css : '';
    }

    /**
     * Get WooCommerce Cart Contents
     *
     * @since 1.4.0
     */
    public static function get_wc_cart_contents() {
        if( class_exists( 'woocommerce' ) ) {
            global $woocommerce;

            $items      = $woocommerce->cart->get_cart();
            $currency   = get_woocommerce_currency_symbol();

            $output = '<div class="agama-cart-content">';
                $output .= '<div class="agama-cart-items">';
                    if( ! empty( $items ) ) {
                        foreach( $items as $item => $values ) {

                            $price      = get_post_meta( $values['product_id'] , '_price', true ); // Product Price
                            $thumb      = wc_get_product( $values['product_id'] ); // Product Image
                            $_product   = wc_get_product( $values['data']->get_id() );
                            $remove     = apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-cart_item_key="%s">×</a>',
                                esc_url( wc_get_cart_remove_url( $item ) ),
                                esc_html__( 'Remove this item', 'agama-pro' ),
                                esc_attr( $_product->get_ID() ),
                                esc_attr( $_product->get_sku() ),
                                esc_attr( $item )
                            ), $item );

                            $output .= '<div class="agama-cart-item clearfix">';
                                $output .= '<div class="agama-cart-item-image">';
                                    $output .= '<a href="'. esc_url( $_product->get_permalink() ) .'">';
                                        $output .= $thumb->get_image();
                                    $output .= '</a>';
                                $output .= '</div>';
                                $output .= '<div class="agama-cart-item-desc">';
                                    $output .= '<a href="'. esc_url( $_product->get_permalink() ) .'">';
                                        $output .= esc_html( $_product->get_title() );
                                    $output .= '</a>';
                                    $output .= '<span class="agama-cart-item-price">';
                                        $output .= esc_attr( $values['quantity'] ) .' x '. esc_attr( $currency ) . esc_html( $price );
                                    $output .= '</span>';
                                    $output .= '<span class="agama-cart-item-quantity">';
                                        $output .= $remove;
                                    $output .= '</span>';
                                $output .= '</div>';
                            $output .= '</div>';

                        }
                    } else {
                        $output .= '<div class="agama-cart-item-desc">';
                            $output .= esc_html__( 'Cart is empty', 'agama-pro' );
                        $output .= '</div>';
                    }
                $output .= '</div>';
                $output .= '<div class="agama-cart-action clearfix">';
                    $output .= '<span class="fleft agama-checkout-price">';
                        $output .= esc_html( strip_tags( WC()->cart->get_cart_total() ) );
                    $output .= '</span>';
                    $output .= '<a href="'. esc_url( wc_get_cart_url() ) .'" class="button button-3d button-small nomargin fright">';
                        $output .= esc_html__( 'View Cart', 'agama-pro' );
                    $output .= '</a>';
                $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
    }

    /**
     * Check if we're in an events archive.
     *
     * @since 1.3.7
     * @return bool
     */
    public static function is_events_archive() {
        if ( function_exists( 'tribe_is_event' ) ) {
            return ( tribe_is_event() && is_archive() );
        }
        return false;
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
