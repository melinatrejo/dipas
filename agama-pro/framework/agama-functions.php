<?php

use Agama\Helper;
use Agama\Breadcrumb;
use Agama\Portfolio;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! isset( $content_width ) ) 
	$content_width = 1200;

/**
 * Backwards Compatibility for Title Tag
 *
 * @since Agama 1.0
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
function agama_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'agama_slug_render_title' );
}

/**
 * Agama Display Logo
 *
 * @since 1.4.8
 * @return mixed
 */
if( ! function_exists( 'agama_logo' ) ) {
    function agama_logo() {
        if( function_exists( 'agama_get_logo' ) ) {
            echo agama_get_logo();   
        }
    }
}

/**
 * Agama Return Logo
 *
 * @since 1.4.8
 * @return mixed
 */
if( ! function_exists( 'agama_get_logo' ) ) {
    function agama_get_logo() {
        global $meta_custom_logo;
        
        $output  = '';
        $desktop = esc_url( get_theme_mod( 'agama_logo', '' ) );
        $mobile  = esc_url( get_theme_mod( 'agama_mobile_logo', '' ) );
        
        if( ! empty( $desktop ) ) {
            $logo['desktop'] = $desktop;
        }
        
        if( ! empty( $mobile ) ) {
            $logo['mobile'] = $mobile;
        }
        
        if( is_customize_preview() ) {
            $output .= '<div class="customize-agama-logo">';
        }
        
        /**
         * Logo set via metabox.
         *
         * @priority 1
         */
        if( ! empty( $meta_custom_logo ) ) {
            $output .= '<a href="'. esc_url( home_url('/') ) .'" ';
            $output .= 'title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" ';
            $output .= 'class="vision-logo-url">';
                $output .= '<img src="'. esc_url( $meta_custom_logo ) .'" class="logo">';
            $output .= '</a>';
        /**
         * Image logo uploaded via customizer.
         *
         * @priority 2
         */
        } else if( ! empty( $logo ) ) {
            $output .= '<a href="'. esc_url( home_url('/') ) .'" ';
            $output .= 'title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" ';
            $output .= 'class="vision-logo-url">';
                foreach( $logo as $device => $url ) {
                    $output .= '<img src="'. $url .'" class="logo logo-'. esc_attr( $device ) .'" ';
                    $output .= 'alt="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'">';
                }
            $output .= '</a>';
        /**
         * Textual logo (website name).
         *
         * @priority 3
         */
        } else {
            if( 'v1' == agama_header_style() ) {
                $output .= '<div>';
            }
            $output .= '<h1 class="site-title">';
                $output .= '<a href="'. esc_url( home_url( '/' ) ) .'" ';
                $output .= 'title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" ';
                $output .= 'class="vision-logo-url" rel="home">';    
                    $output .= get_bloginfo( 'name' );
                $output .= '</a>';
            $output .= '</h1>';
            // Tagline
            if( 'v1' == agama_header_style() ) {
                $output .= '<h2 class="site-description">'. get_bloginfo( 'description' ) .'</h2>';
                $output .= '</div>';
            }
        }
        
        if( is_customize_preview() ) {
            $output .= '</div>';
        }
        
        return $output;
    }
}

/**
 * Header Search Box
 *
 * @since 1.4.9.2
 */
function agama_header_search_box() {
    echo Helper::get_search_box();
}

/**
 * Add Search & Cart Icons to The Menu
 *
 * @since 1.3.7
 */
add_filter( 'wp_nav_menu_items', 'agama_nav_primary_menu_items', 10, 2 );
function agama_nav_primary_menu_items( $items, $args ) {
	// Add header search & cart icons on primary menu.
	if( $args->theme_location == 'agama_nav_primary' ) {
		// If WooCommerce cart icon enabled.
		if( class_exists( 'Woocommerce' ) && get_theme_mod( 'agama_header_cart_icon', true ) ) {
			$items .= sprintf(
				'<li class="agama-mini-cart vision-custom-menu-item vision-main-menu-cart">
					<a id="agama-open-cart" href="#" class="shopping_cart"></a>
                    %s
					<span class="cart_count"></span>
				</li>',
                Helper::get_wc_cart_contents()
			);
		}
		// If search icon is enabled.
		if( get_theme_mod( 'agama_header_search', true ) ) {
			$items .= sprintf(
				'<li class="vision-custom-menu-item vision-main-menu-search">
					<a class="%s">%s</a>
                    %s
				</li>',
				esc_attr( 'top-search-trigger' ),
				'<i class="fa fa-search"></i>',
                Helper::get_search_box()
			);
		}
	}
	return $items;
}

/**
 * Agama Layout Style
 *
 * @since 1.4.5
 */
if( ! function_exists( 'agama_layout_style' ) ) {
    function agama_layout_style() {
        $layout_meta    = esc_attr( Agama::get_meta( '_agama_layout_style' ) );
        $layout         = esc_attr( get_theme_mod( 'agama_layout_style', 'fullwidth' ) );
        
        if( ! empty( $layout_meta ) ) {
            $layout = $layout_meta;
        }
        
        return $layout;
    }
}

/**
 * Agama Header Style
 *
 * @since 1.4.3
 */
if( ! function_exists( 'agama_header_style' ) ) {
    function agama_header_style() {
        $header_meta    = esc_attr( Agama::get_meta( '_agama_header_style' ) );
        $header         = esc_attr( get_theme_mod( 'agama_header_style', 'v3' ) );
        
        // If Header Style Set Thru Metabox Give Priority
        if( ! empty( $header_meta ) ) {
            $header = $header_meta;
        }
        
        return $header;
    }
}

/**
 * Agama Breadcrumbs
 *
 * @since 1.3.7
 */
add_action( 'vision_breadcrumb', 'vision_breadcrumbs' );
if ( ! function_exists( 'vision_breadcrumbs' ) ) {
	/**
	 * Render the breadcrumbs with help of class-breadcrumbs.php.
	 *
	 * @return void
	 */
	function vision_breadcrumbs() {
		$breadcrumbs = Breadcrumb::get_instance();
		$breadcrumbs->get_breadcrumbs();
	}
}

/**
 * Primary Class
 *
 * @since 1.0.2
 * @return string
 */
if( ! function_exists( 'agama_primary_class' ) ) {
    function agama_primary_class() {
        echo 'col-md-12';
    }
}

/**
 * Check If Featured Image is Enabled for Single Posts
 *
 * @used in single.php
 * @since 1.4.5
 * @return bool
 */
if( ! function_exists( 'agama_has_single_post_thumbnail' ) ) {
    function agama_has_single_post_thumbnail() {
        $enabled = esc_attr( get_theme_mod( 'agama_blog_single_featured_thumbs', false ) );

        // If option is enabled.
        if( has_post_thumbnail() &&  $enabled ) {
            return true;
        }

        return false;
    }
}

/**
 * Get Featured Images
 *
 * @since 1.4.5
 * @return string
 */
function agama_get_the_post_thumbnail( $post_id = null, $size = 'full' ) {
    global $post;
    
    /**
     * If Post ID not assigned let's use default Post ID.
     */
    if( ! $post_id ) {
        $post_id = esc_attr( $post->ID );
    }
    
    $image              = array(); // PHP notice fix.
    $image['lightbox']  = array(); // PHP notice fix.
    $image['featured']  = array(); // PHP notice fix.
    
    /**
     * Let's check if embed video is set.
     */
    if( agama_get_the_post_video( $post_id ) ) {
        $image['featured']['embed'] = agama_get_the_post_video( $post_id );
    }
    
    /**
     * If Featured Images Crop
     * feature enabled let's use cropped featured images.
     */
    $crop = esc_attr( get_theme_mod( 'agama_blog_crop_featured_images', true ) );
    if( $crop && 'post' == get_post_type() ) {
        $blog_layout = esc_attr( get_theme_mod( 'agama_blog_layout', 'list' ) );
        switch( $blog_layout ) {
            case 'grid':
                $size = 'post-thumbnail';
            break;
            case 'small_thumbs';
                $size = 'blog-small';
            break;
            default: $size = 'blog-large';
        }
    }
    
    /**
     * Default WP Featured Image
     */
    if( has_post_thumbnail() ) {
        $tid    = get_post_thumbnail_id( $post_id );
        $limage = wp_get_attachment_image_src( $tid, 'full' ); // For LightBox
        $fimage = wp_get_attachment_image_src( $tid, $size );
        $image['lightbox'][1] = $limage[0]; // For Lightbox
        $image['featured'][1] = $fimage[0];
    }
    
    /**
     * Let's check if multiple featured images is set.
     */
    if( is_plugin_active( 'multiple-featured-images/multiple-featured-images.php' ) ) {
        if( kdmfi_get_featured_image_src( 'featured-image-2', $size ) ) {
            $image['lightbox'][2] = kdmfi_get_featured_image_src( 'featured-image-2', 'full' );
            $image['featured'][2] = kdmfi_get_featured_image_src( 'featured-image-2', $size );
        }
        if( kdmfi_get_featured_image_src( 'featured-image-3', $size ) ) {
            $image['lightbox'][3] = kdmfi_get_featured_image_src( 'featured-image-3', 'full' );
            $image['featured'][3] = kdmfi_get_featured_image_src( 'featured-image-3', $size );
        }
        if( kdmfi_get_featured_image_src( 'featured-image-4', $size ) ) {
            $image['lightbox'][4] = kdmfi_get_featured_image_src( 'featured-image-4', 'full' );
            $image['featured'][4] = kdmfi_get_featured_image_src( 'featured-image-4', $size );
        }
        if( kdmfi_get_featured_image_src( 'featured-image-5', $size ) ) {
            $image['lightbox'][5] = kdmfi_get_featured_image_src( 'featured-image-5', 'full' );
            $image['featured'][5] = kdmfi_get_featured_image_src( 'featured-image-5', $size );
        }
    }
    
    /**
     * Count how many features images are set.
     */
    $count = count( array_filter( $image['featured'] ) );
    
    /**
     * If there is no any featured images return early.
     */
    if( $count == 0 ) {
        return;
    }
    
    /**
     * Let's check if Permalinks 
     * feature is enabled for featured images.
     */
    $permalink = esc_attr( get_theme_mod( 'agama_blog_thumbnails_permalink', true ) );
    
    /**
     * Featured Image Class
     * @agama-filters
     * @line 13
     */
    $class = apply_filters( 'agama_featured_image_class', array( 'img-responsive' ) );
    
    /**
     * Let's check if LightBox feature is enabled,
     * if enabled let's apply proper attribute data to image.
     */
    $lightbox = esc_attr( get_theme_mod( 'agama_blog_lightbox', true ) );
    
    /**
     * If only one featured image set just output it.
     */
    if( $count == 1 ) {
        $output  = '<div class="entry-image">';
            foreach( $image['featured'] as $key => $url ) {
                
                /**
                 * If Ebeded Video
                 */
                if( $key == 'embed') {
                    $output .= $url;
                } else {
                    /**
                     * If Permalinks Enabled
                     */
                    if( $permalink ) {
                        if( $lightbox ) {
                            $the_permalink  = $image['lightbox'][$key];
                            $lightbox       = ' data-lightbox="image"';
                        } else {
                            $the_permalink  = get_the_permalink();
                            $lightbox       = '';
                        }
                        $output .= sprintf( 
                            '<a href="%s"%s><img src="%s" class="%s" alt="%s"></a>', 
                            $the_permalink,
                            $lightbox,
                            esc_url( $url ),
                            esc_attr( $class ),
                            get_the_title()
                        );
                    } else { // Permalinks Disabled
                        $output .= '<img 
                                    src="'. esc_url( $url ) .'" 
                                    class="'. esc_attr( $class ) .'" 
                                    alt="'. get_the_title() .'">';
                    }
                }
            }
        $output .= '</div>';
    } else {
        /**
         * If multiple featured images set,
         * let's put it into Flex slider.
         */
        $output  = '<div class="entry-image">';
            $output .= '<div class="fslider" data-arrows="false" data-lightbox="gallery">';
                $output .= '<div class="flexslider">';
                    $output .= '<div class="slider-wrap">';
                    foreach( $image['featured'] as $key => $url ) {
                        $output .= '<div class="slide">';
                            if( $key == 'embed' ) {
                                $output .= $url;
                            } else {
                               /**
                                 * If Permalinks Enabled
                                 */
                                if( $permalink ) {
                                    if( $lightbox ) {
                                        $the_permalink  = $image['lightbox'][$key];
                                        $lightbox       = ' data-lightbox="gallery-item"';
                                    } else {
                                        $the_permalink  = get_the_permalink();
                                        $lightbox       = '';
                                    }
                                    $output .= sprintf( 
                                        '<a href="%s"%s><img src="%s" class="%s" alt="%s"></a>', 
                                        $the_permalink,
                                        $lightbox,
                                        esc_url( $url ),
                                        esc_attr( $class ),
                                        get_the_title()
                                    );
                                } else { // Permalinks Disabled
                                    $output .= '<img 
                                                src="'. esc_url( $url ) .'" 
                                                alt="'. get_the_title() .'" 
                                                class="'. esc_attr( $class ) .'">';
                                }
                            }
                        $output .= '</div>';
                    }
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';
    }
    
    echo $output;
}

/**
 * Geat Featured Video
 *
 * @used in agama_get_the_post_thumbnail()
 * @since 1.4.5
 */
function agama_get_the_post_video( $post_id ) {
    $pt_post_type = esc_attr( get_theme_mod( 'agama_portfolio_page_slug', 'agama_portfolio' ) );
    $pt_post_type = strtolower( $pt_post_type );
    $pt_post_type = str_replace( ' ', '_', $pt_post_type );
    
    if( get_post_type() == $pt_post_type ) {
        $embed = get_post_meta( $post_id, '_agama_pt_video', true );
    } else {
        $embed = get_post_meta( $post_id, '_agama_post_video', true );
    }
    
    if( ! empty( $embed ) ) {
        return $embed;
    }
}

/**
 * Portfolio Featured Thumbnails
 *
 * @since 1.4.5
 */
function agama_portfolio_get_the_post_thumbnail( $post_id = null, $size = 'full' ) {
    global $post;
    
    /**
     * If Post ID not assigned let's use default Post ID.
     */
    if( ! $post_id ) {
        $post_id = esc_attr( $post->ID );
    }
    
    $image              = array(); // PHP notice fix.
    $image['lightbox']  = array(); // PHP notice fix.
    $image['featured']  = array(); // PHP notice fix.
    
    /**
     * Let's check if embed video is set.
     */
    if( agama_get_the_post_video( $post_id ) ) {
        $image['featured']['embed'] = agama_get_the_post_video( $post_id );
    }
    
    /**
     * Default WP Featured Image
     */
    if( has_post_thumbnail() ) {
        $tid    = get_post_thumbnail_id( $post_id );
        $limage = wp_get_attachment_image_src( $tid, 'full' ); // For LightBox
        $fimage = wp_get_attachment_image_src( $tid, $size );
        $image['lightbox'][1] = $limage[0]; // For Lightbox
        $image['featured'][1] = $fimage[0];
    }
    
    /**
     * Let's check if multiple featured images is set.
     */
    if( is_plugin_active( 'multiple-featured-images/multiple-featured-images.php' ) ) {
        if( kdmfi_get_featured_image_src( 'featured-image-2', $size ) ) {
            $image['lightbox'][2] = kdmfi_get_featured_image_src( 'featured-image-2', 'full', $post_id );
            $image['featured'][2] = kdmfi_get_featured_image_src( 'featured-image-2', $size, $post_id );
        }
        if( kdmfi_get_featured_image_src( 'featured-image-3', $size ) ) {
            $image['lightbox'][3] = kdmfi_get_featured_image_src( 'featured-image-3', 'full', $post_id );
            $image['featured'][3] = kdmfi_get_featured_image_src( 'featured-image-3', $size, $post_id );
        }
        if( kdmfi_get_featured_image_src( 'featured-image-4', $size ) ) {
            $image['lightbox'][4] = kdmfi_get_featured_image_src( 'featured-image-4', 'full', $post_id );
            $image['featured'][4] = kdmfi_get_featured_image_src( 'featured-image-4', $size, $post_id );
        }
        if( kdmfi_get_featured_image_src( 'featured-image-5', $size ) ) {
            $image['lightbox'][5] = kdmfi_get_featured_image_src( 'featured-image-5', 'full', $post_id );
            $image['featured'][5] = kdmfi_get_featured_image_src( 'featured-image-5', $size, $post_id );
        }
    }
    
    /**
     * Count how many features images are set.
     */
    $count = count( array_filter( $image['featured'] ) );
    
    /**
     * If there is no any featured images return early.
     */
    if( $count == 0 ) {
        return;
    }
    
    $output = '';
    
    if( $count == 1 ) { // One Portfolio Image
        foreach( $image['featured'] as $key => $url ) {
            if( $key == 'embed' ) {
                $output .= $url;
            } else {
                $output .= '<div class="portfolio-image">';
                    $output .= '<a href="'. $image['lightbox'][$key] .'" data-lightbox="image">';
                        $output .= '<img src="'. esc_url( $url ) .'" alt="'. get_the_title() .'">';
                    $output .= '</a>';
                    $output .= '<div class="portfolio-overlay">';
                        $output .= Portfolio::rollover_icons( $post_id );
                    $output .= '</div>';
                $output .= '</div>';
            }
        }
    } else { // Multiple Portfolio Images
        $output .= '<div class="portfolio-image">';
            $output .= '<div class="fslider" data-arrows="false" data-lightbox="gallery">';
                $output .= '<div class="flexslider">';
                    $output .= '<div class="slider-wrap">';
                    foreach( $image['featured'] as $key => $url ) {
                        $output .= '<div class="slide">';
                        if( $key == 'embed' ) {
                            $output .= $url;
                        } else {
                            $output .= '<a href="'. $image['lightbox'][$key] .'">';
                                $output .= '<img src="'. esc_url( $url ) .'" alt="'. get_the_title() .'">';
                            $output .= '</a>';
                        }
                        $output .= '</div>';
                    }
                    $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="portfolio-overlay" data-lightbox="gallery">';
                    $output .= Portfolio::rollover_icons( $post_id, true, $image );
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';
    }
    
    echo $output;
}

/**
 * Agama Thumb Title
 * Get post-page article title and separates it on two halfs
 *
 * @since Agama v1.0.1
 * @return string
 */
function agama_thumb_title() {
	$title = get_the_title();
	$findme   = ' ';
	$pos = strpos($title, $findme);
	if( $pos === false ) {
			$output = '<h2>'.$title.'</h2>';
		} else {
			// isolate part 1 and part 2.
			$title_part_one = strstr($title, ' ', true); // As of PHP 5.3.0
			$title_part_two = strstr($title, ' ');
			$output = '<h2>'.$title_part_one.'<span>'.$title_part_two.'</span></h2>';
		}
	echo $output;
}

/**
 * Get Attachment Image Src
 *
 * @since Agama v1.0.1
 * @return string
 */
function agama_return_image_src( $size ) {
	$att_id	 = get_post_thumbnail_id();
	$att_src = wp_get_attachment_image_src( $att_id, $size );
    
	return esc_url($att_src[0]);
}

/**
 * Replaces Excerpt "more" Text by Link
 *
 * @since 1.1.2
 */
add_filter('excerpt_more', 'agama_excerpt_more' );
function agama_excerpt_more( $more ) {
	global $post;
    $wrapper_start = '';
    $wrapper_end   = '';
    if( is_customize_preview() ) {
        $wrapper_start = '<span class="more-link-cpreview">';
        $wrapper_end   = '</span>';
    }
	if( get_theme_mod( 'agama_blog_readmore_url', true ) && get_post_type() !== 'agama_portfolio' && ! is_single() ) {
		return '<br><br>'. $wrapper_start .'<a class="more-link" href="'. get_permalink( $post->ID ) .'">'. __( 'Read More', 'agama-pro' ) .'</a>'. $wrapper_end;
	}
	return;
}

/**
 * Check if current page is template page
 *
 * @since Agama v1.0.1
 * @return string
 */
function agama_is_page_template( $page ) {
	if( is_page_template( 'templates/'.$page ) ) {
		return true;
	}
	return false;
}

/**
 * Get Portfolio Category Names
 *
 * @since Agama v1.0.1
 * @return string
 */
function agama_get_portfolio_categories( $tag ) {
	global $post;
	$categories = wp_get_object_terms( $post->ID,  'portfolio-categories' );
	if ( ! empty( $categories ) ) {
		if ( ! is_wp_error( $categories ) ) {
			echo $tag;
			foreach( $categories as $term ) {
				echo '<a href="' . get_term_link( $term->slug, 'portfolio-categories' ) . '">' . esc_html( $term->name ) . '</a>, '; 
			}
			echo str_replace( '<', '</', $tag );
		}
	}
}

/**
 * Filter the page menu arguments.
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Agama 1.0
 */
function agama_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'agama_page_menu_args' );

if ( ! function_exists( 'agama_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Agama 1.0
 */
function agama_content_nav( $html_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation clearfix" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'agama-pro' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'agama-pro' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'agama-pro' ) ); ?></div>
		</nav><!-- .navigation -->
	<?php endif;
}
endif;

/**
 * Comment form default fields
 *
 * @since 1.0.5
 */
add_filter( 'comment_form_default_fields', 'agama_comment_form_fields' );
function agama_comment_form_fields( $fields ) {
	
	// Get the current commenter if available
    $commenter = wp_get_current_commenter();
	
	// Core functionality
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html_req = ( $req ? " required='required'" : '' );
	
	$fields['author'] 	= '<div class="col-md-4"><label for="author">' . __( 'Name', 'agama-pro' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" class="sm-form-control"' . $aria_req . ' /></div>';
	$fields['email'] 	= '<div class="col-md-4"><label for="email">' . __( 'Email', 'agama-pro' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" class="sm-form-control"' . $aria_req . ' /></div>';
	$fields['url'] 		= '<div class="col-md-4"><label for="url">' . __( 'Website', 'agama-pro' ) . '</label><input id="url" name="url" type="text" value="' . esc_url( $commenter['comment_author_url'] ) . '" class="sm-form-control" /></div>';
	
	
	
	return $fields;
}

/**
 * Comment form defaults
 *
 * @since 1.0.5
 */
add_filter( 'comment_form_defaults', 'agama_comment_form_defaults' );
function agama_comment_form_defaults( $defaults ) {
	global $current_user;
	
	$comments['tags_suggestion'] 			= esc_attr( get_theme_mod( 'agama_comments_tags_suggestion', true ) );
	
	$defaults['title_reply']				= sprintf( '%s <span>%s</span>', __( 'Leave a', 'agama-pro' ), __( 'Comment', 'agama-pro' ) );
	$defaults['logged_in_as'] 				= '<div class="col-md-12 logged-in-as">' . sprintf(	'%s <a href="%s">%s</a>. <a href="%s" title="%s">%s</a>', __('Logged in as', 'agama-pro'), admin_url( 'profile.php' ), $current_user->display_name, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ), __('Log out of this account', 'agama-pro'), __('Log out?', 'agama-pro') ) . '</div>';
	$defaults['comment_field']  			= '<div class="col-md-12"><label for="comment">' . __( 'Comment', 'agama-pro' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="sm-form-control"></textarea></div>';
	
	// Comments HTML tags suggestion.
	if( $comments['tags_suggestion'] ) {
		$defaults['comment_notes_after'] 	= '<div class="col-md-12 abbr" style="margin-top: 15px; margin-bottom: 15px;">' . sprintf( '%s <abbr title="HyperText Markup Language">HTML</abbr> %s: %s', __( 'You may use these', 'agama-pro' ), __( 'tags and attributes', 'agama-pro' ), '<code>' . allowed_tags() . '</code>' ) . '</div>';
	}
	
	$defaults['class_submit'] 				= 'button button-3d button-large button-rounded';
	
	return $defaults;
}

if ( ! function_exists( 'agama_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own agama_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Agama 1.0
 */
function agama_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'agama-pro' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'agama-pro' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-wrap clearfix">
			
			<div class="comment-meta">
				<div class="comment-author vcard">
					<span class="comment-avatar clearfix">
						<?php echo get_avatar( $comment, 44 ); ?>
					</span>
				</div>
			</div><!-- .comment-meta -->

			<div class="comment-content comment">
				<div class="comment-author">
				<?php
				printf( '<a href="%1$s">%2$s %3$s</a>', get_permalink(), get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<cite>' . __( 'author', 'agama-pro' ) . '</cite>' : ''
				);
				printf( '<span><a href="%1$s"><time datetime="%2$s">%3$s</time></a></span>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'agama-pro' ), get_comment_date(), get_comment_time() )
				);
				?>
				</div>
				<?php comment_text(); ?>
				<?php //edit_comment_link( __( '<i class="fa fa-edit"></i> Edit', 'agama-pro' ), '<p class="edit-link">', '</p>' ); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .comment-content -->
			
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'agama-pro' ); ?></p>
			<?php endif; ?>
			
		</div><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'agama_entry_meta' ) ) :
/**
 * Set up post entry meta.
 *
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own agama_entry_meta() to override in a child theme.
 *
 * @since Agama 1.0
 */
function agama_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'agama-pro' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'agama-pro' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'agama-pro' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'agama-pro' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'agama-pro' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'agama-pro' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * .article-wrapper Grid, List - Style
 *
 * @since Agama v1.0.1
 */
function agama_article_wrapper_class() {
    $layout = esc_attr( get_theme_mod( 'agama_blog_layout', 'list' ) );
    switch( $layout ) {
        case 'list':
            $output = 'list-style';
        break;
        case 'grid':
            $output = 'grid-style';
        break;
        case 'small_thumbs':
            $output = 'small_thumbs-style';
        break;
    }
	echo $output;
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
