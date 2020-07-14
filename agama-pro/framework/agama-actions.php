<?php

use Agama\Header_Video;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Build Page Action Start
 *
 * @since 1.4.7
 */
if( ! function_exists( 'agama_customize_build_page_action_start' ) ) {
    function agama_customize_build_page_action_start() {
        global $post;
        
        $widget = 'page-widget-'. esc_attr( $post->ID );
        
        if( is_customize_preview() && is_page() && ! is_active_sidebar( $widget ) ) {
            
            $html  = '<div class="agama-build-page-wrapper clearfix">';
                $html .= '<div class="agama-build-page-action" data-id="sidebar-widgets-page-widget-'. esc_attr( $post->ID ) .'">';
                    $html .= esc_html__( 'You can replace this page with Agama Widgets.', 'agama' );
                    $html .= '<a class="add-new-widget">'. esc_html__( 'Add Widgets', 'agama' ) .'</a>';
                $html .= '</div>';
        
            echo $html;
            
        }
    }
}
add_action( 'agama_customize_build_page_action_start', 'agama_customize_build_page_action_start' );

/**
 * Build Page Action End
 *
 * @since 1.4.7
 */
if( ! function_exists( 'agama_customize_build_page_action_end' ) ) {
    function agama_customize_build_page_action_end() {
        global $post;
        
        $widget = 'page-widget-'. esc_attr( $post->ID );
        
        if( is_customize_preview() && is_page() && ! is_active_sidebar( $widget ) ) {
            
            echo '</div><!-- Agama Build Page Wrapper End -->';
            
        }
    }
}
add_action( 'agama_customize_build_page_action_end', 'agama_customize_build_page_action_end' );

/**
 * Get Page Permalink via Ajax
 *
 * @since 1.4.7
 */
if( ! function_exists( 'agama_ajax_get_permalink' ) ) {
    function agama_ajax_get_permalink() {
        $permalink = get_permalink( intval( $_REQUEST['id'] ) );
        echo esc_url( $permalink );
        die();
    }
}
add_action( 'wp_ajax_agama_ajax_get_permalink', 'agama_ajax_get_permalink' );
add_action( 'wp_ajax_nopriv_agama_ajax_get_permalink', 'agama_ajax_get_permalink' );

/**
 * Agama Header Video
 *
 * @since 1.4.6
 */
if( ! function_exists( 'agama_header_video' ) ) {
    
    function agama_header_video() {
        
        Header_Video::get_instance();
        
    }
    
}
add_action( 'agama_header_video', 'agama_header_video' );

/**
 * Set Post Views
 *
 * @since 1.4.7
 */
if( ! function_exists( 'agama_set_post_views' ) ) {
    function agama_set_post_views( $post_id ) {
        $count_key  = 'agama_post_views_count';
        $count      = get_post_meta( $post_id, $count_key, true );
        if( $count == '' ) {
            $count = 0;
            delete_post_meta( $post_id, $count_key );
            add_post_meta( $post_id, $count_key, '0' );
        } else {
            $count++;
            update_post_meta( $post_id, $count_key, $count );
        }
    }
    // Remove issues with prefetching adding extra views
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
}
add_action( 'agama_set_post_views', 'agama_set_post_views' );

/**
 * Get Post Views
 *
 * @since 1.4.7
 */
if( ! function_exists( 'agama_get_post_views' ) ) {
    function agama_get_post_views( $post_id ) {
        $icon       = '<i class="fa fa-eye"></i> ';
        $count_key  = 'agama_post_views_count';
        $count      = get_post_meta( $post_id, $count_key, true );
        
        if( $count == '' ) {
            delete_post_meta( $post_id, $count_key );
            add_post_meta( $post_id, $count_key, '0' );
            echo $icon . '0';
        }

        echo $icon . $count;
    }
}
add_action( 'agama_get_post_views', 'agama_get_post_views' );

/**
 * Render HTML for blog post date / post format
 *
 * @since 1.0.1
 */
if( ! function_exists( 'agama_render_blog_post_date' ) ) {
	function agama_render_blog_post_date() {
		global $post;
		
		// Get post format
		$format = get_post_format( $post->ID );
		
		switch( $format ):
			case 'aside':
				$fa_class = 'fa fa-2x fa-outdent';
			break;
			case 'image':
				$fa_class = 'fa fa-2x fa-picture-o';
			break;
			case 'link':
				$fa_class = 'fa fa-2x fa-link';
			break;
			case 'quote':
				$fa_class = 'fa fa-2x fa-quote-left';
			break;
			case 'status':
				$fa_class = 'fa fa-2x fa-comment';
			break;
			default: $fa_class = 'fa fa-2x fa-file-text';
		endswitch;
		
		// If not single post or not search page with page post type.
		if( ! is_single() && get_theme_mod( 'agama_blog_date', true ) && 'page' !== get_post_type() ) {
			echo '<div class="entry-date">';
			echo '<div class="date-box updated">';
				printf( '<span class="date">%s</span>', get_the_time('d') ); // Get day
				printf( '<span class="month-year">%s</span>', get_the_time('m, Y') ); // Get month, year
			echo '</div>';
			echo '<div class="format-box">';
				printf( '<i class="%s"></i>', $fa_class );
			echo '</div>';
			echo '</div><!-- .entry-date -->';
		}
	}
}
add_action( 'agama_blog_post_date_and_format', 'agama_render_blog_post_date', 10 );

/**
 * Render HTML blog post meta details
 *
 * @since 1.0.1
 */
if( ! function_exists( 'agama_render_blog_post_meta' ) ) {
	function agama_render_blog_post_meta() {
        $enabled = esc_attr( get_theme_mod( 'agama_post_meta', true ) );
        
        $meta_fields = get_theme_mod( 'agama_post_meta_fields', array(
            'author', 'date', 'category', 'comments', 'views'
        ) );
        
        // Return early if no meta.
        if( ! $enabled || empty( $meta_fields ) || 'page' == get_post_type() ) {
            return;
        }
        
        echo '<ul class="single-line-meta">';
            foreach( $meta_fields as $meta ) {
                
                // Post Author
                if( 'author' == $meta ) {
                    echo '<li><a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'" rel="author">'. sprintf( 
                            '%s <span class="vcard"><span class="fn">%s</span></span>', 
                            '<i class="fa fa-user"></i>',
                            ucfirst( get_the_author() ) ) .'</a></li>';
                }

                // Post Date
                if( 'date' == $meta ) {
                    echo '<li><i class="fa fa-calendar"></i> <span>'. get_the_date() .'</span></li>';
                }

                // Post Category
                if( 'category' == $meta ) {
                    echo '<li><i class="fa fa-folder-open"></i> '. sprintf( '%s', get_the_category_list( ', ' ) ) .'</li>';
                }

                // Post Comments Count
                if( 'comments' == $meta ) {
                    if( comments_open() ) {
                        echo '<li><i class="fa fa-comments"></i> '. sprintf( '<a href="%s">%s</a>', 
                            get_comments_link(), 
                            get_comments_number()
                        ) .'</li>';
                    }
                }
                
                // Post Views
                if( 'views' == $meta ) {
                    if( has_action( 'agama_get_post_views' ) ) {
                        echo '<li>'; do_action( 'agama_get_post_views', get_the_ID() ); echo '</li>';
                    }
                }
                
            }
        echo '</ul>';
	}
}
add_action( 'agama_blog_post_meta', 'agama_render_blog_post_meta', 10 );

/**
 * Agama Credits
 *
 * @since 1.0.1
 */
if( ! function_exists( 'agama_render_credits' ) ) {
	function agama_render_credits() {
		echo html_entity_decode( 
            get_theme_mod( 
                'agama_footer_copyright', 
                sprintf( 
                    __( '2015 - 2020 &copy; Powered by %s.', 'agama-pro' ), 
                    '<a href="http://www.theme-vision.com" target="_blank">Theme-Vision</a>' ) 
            ) 
        );
	}
}
add_action( 'agama_credits', 'agama_render_credits' );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
