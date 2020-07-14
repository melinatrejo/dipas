<?php
/**
 * Portfolio
 *
 * The Agama portfolio class.
 *
 * @since 1.4.5
 * @since 1.4.9.2 Updated the code.
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Portfolio {
    
    /**
     * Query
     *
     * The portfolio query.
     *
     * @since 1.4.5
     * @access public
     * @return array
     */
    public static function the_query() {
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        $slug  = esc_attr( get_theme_mod( 'agama_portfolio_page_slug', 'agama_portfolio' ) );
        $slug = str_replace( ' ', '_', $slug );

        $args  = array( 
            'post_type'       => $slug, 
            'posts_per_page'  => esc_attr( get_theme_mod( 'agama_portfolio_per_page', '12' ) ),
            'paged'           => $paged
        );
        
        return $args;
    }
    
    /**
     * Filter
     *
     * The portfolio navigation filter.
     *
     * @param string $category (required) The category which should display in the navigation filter.
     *
     * @since 1.4.5
     * @access public
     * @return mixed
     */
    public static function filter( $category ) {
        $enabled = esc_attr( get_theme_mod( 'agama_portfolio_nav_filter', true ) );
        if( $enabled && is_array( $category ) ) {
            
            $output  = '<!-- Portfolio Filter -->';
            $output .= '<ul id="portfolio-filter" class="portfolio-filter single clearfix" data-container="#portfolio">';
            $output .= '<li class="activeFilter"><a href="#" data-filter="*">'. esc_html__( 'Show All', 'agama-pro' ) .'</a></li>';
            foreach( $category as $filter ) {
                $output .= '<li><a href="#" data-filter=".'. strtolower( $filter ) .'">'. $filter .'</a></li>';
            }
            $output .= '</ul>';
            $output .= '<!-- Portfolio Filter End -->';
            $output .= self::shuffle();
            if( is_page_template( 'templates/portfolio-full-width.php' ) ) {
                $output .= '</div><!-- Container End -->';
            }
            $output .= '<div class="clear"></div>';
            
            echo $output;
        }
    }
    
    /**
     * Shuffle
     *
     * The portfolio shuffle.
     *
     * @since 1.4.5
     * @access public
     * @return mixed
     */
    public static function shuffle() {
        $enabled = esc_attr( get_theme_mod( 'agama_portfolio_nav_shuffle', true ) );
        if( $enabled ) {
            $output  = '<div class="portfolio-shuffle" data-container="#portfolio">';
            $output .= '<i class="fa fa-random"></i>';
            $output .= '</div><!-- .portfolio-shuffle -->';
            
            echo $output;
        } 
    }
    
    /**
     * Rollover Icons
     *
     * The Agama portfolio rollover icons.
     *
     * @param int   $post_id  (required) The post ID.
     * @param bool  $multiple (optional) Is there a portfolio is multiple images ?
     * @param array $images   (optional) The portfolio images.
     *
     * @since 1.4.5
     * @access public
     * @return mixed
     */
    public static function rollover_icons( $post_id, $multiple = false, $images = array() ) {
        $icons_meta = esc_attr( get_post_meta( $post_id, '_agama_pt_rollover_icons', true ) );
        $custom_url = esc_url( get_post_meta( $post_id, '_agama_pt_custom_url', true ) );
        $additional = array();
        $type       = 'image';
        
        if( $multiple ) {
            $type = 'gallery-item';
        }
        
        $zoom = '<a href="'. agama_return_image_src( 'full' ) .'" class="left-icon" data-lightbox="'. esc_attr( $type ) .'">';
        
        // If Multiple Portfolio Images
        if( $multiple ) {
            $zoom .= '<i class="fa fa-clone"></i></a>';
            unset( $images['featured'][key($images['featured'])] );
            foreach( $images['featured'] as $key => $image ) {
                $additional[$key] = '<a href="'. esc_url( $images['lightbox'][$key] ) .'" class="hidden" data-lightbox="gallery-item"></a>';
            }
        } else { // If Single Portfolio Image
            
            $zoom .= '<i class="fa fa-plus"></i></a>';
            
        }
        
        $additional = implode( '', $additional );
        
        if( ! empty( $custom_url ) ) {
            $link   = '<a href="'. $custom_url .'" class="right-icon" target="_blank"><i class="fa fa-external-link"></i></a>';
        } else {
            $link   = '<a href="'. get_the_permalink() .'" class="right-icon"><i class="fa fa-ellipsis-h"></i></a>';
        }
        
        switch( $icons_meta ) {
            case 'link':
                $output = $link;
            break;
            case 'zoom':
                $output = $zoom;
            break;
            case 'none':
                
            break;
            default: $output = $link . $zoom;
        }
        
        return isset( $output ) ? $output . $additional : '';
    }
    
    /**
     * Pagination
     *
     * The portfolio pagination.
     *
     * @since 1.4.5
     * @access public
     * @return mixed
     */
    public static function pagination() {
        global $loop;
        
        $enabled = esc_attr( get_theme_mod( 'agama_portfolio_pagination', true ) );
        
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
            
            if( $loop->max_num_pages > 1 ) {
                echo '<div id="vision-pagination" class="clearfix">';
                    echo paginate_links( array(
                        'base'                  => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'                => '?paged=%#%',
                        'current'               => max( 1, $paged ),
                        'total'                 => $loop->max_num_pages,
                        'before_page_number'    => '<span class="screen-reader-text">' . $translated . '</span>'
                    ) );
                echo '</div>';
            }
            
        }
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
