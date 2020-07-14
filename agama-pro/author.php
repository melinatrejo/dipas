<?php
/**
 * The template for displaying author pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#author-display
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.0
 */

use Agama\Helper;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php get_header(); ?>
    
    <!-- Section Start -->
	<section id="primary" class="site-content <?php Agama::bs_class(); ?>">
        
        <header class="archive-header">
            <h1 class="archive-title"><?php printf( __( 'Author Archives: %s', 'agama-pro' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
        </header>
        
        <?php
        // If a user has filled out their description, show a bio on their entries.
        if ( get_the_author_meta( 'description' ) ) : ?>
        <div class="author-info">
            <div class="author-avatar">
                <?php
                /**
                 * Filter the author bio avatar size.
                 *
                 * @since Agama 1.0
                 *
                 * @param int $size The height and width of the avatar in pixels.
                 */
                $author_bio_avatar_size = apply_filters( 'agama_author_bio_avatar_size', 68 );
                echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
                ?>
            </div>
            <div class="author-description">
                <h2><?php printf( __( 'About %s', 'agama-pro' ), get_the_author() ); ?></h2>
                <p><?php the_author_meta( 'description' ); ?></p>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Content Start -->
		<div id="content" role="main"<?php Helper::get_blog_isotope_class(); ?>>
		<?php if ( have_posts() ) : ?>

			<?php
            /* Queue the first post, that way we know
             * what author we're dealing with (if that is the case).
             *
             * We reset this later so we can run the loop
             * properly with a call to rewind_posts().
             */
            the_post(); ?>

			<?php
            /* Since we called the_post() above, we need to
             * rewind the loop back to the beginning that way
             * we can run the loop properly, in full.
             */
            rewind_posts(); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				
                <?php get_template_part( 'content', get_post_format() ); ?>
            
			<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- Content End -->
        
        <?php Helper::get_pagination(); ?>
            
        <?php Helper::get_infinite_scroll_load_more_btn(); ?>
        
	</section><!-- Section End -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
