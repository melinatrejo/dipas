<?php
/**
 * The template for displaying category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
	
	<!-- Primary -->
	<section id="primary" class="site-content <?php Agama::bs_class(); ?>">
		
		<!-- Content -->
		<div id="content" role="main"<?php Helper::get_blog_isotope_class(); ?>>
		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			endwhile; ?>
            
            <?php else : ?>
                
                <?php get_template_part( 'content', 'none' ); ?>
            
            <?php endif; ?>
		
        </div><!-- End Content -->
        
        <?php Helper::get_pagination(); ?>
        
        <?php Helper::get_infinite_scroll_load_more_btn(); ?>
		
	</section><!-- End Primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
