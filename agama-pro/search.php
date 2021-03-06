<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
    
    <!-- Section -->
	<section id="primary" class="site-content <?php Agama::bs_class(); ?>">
        
        <?php if( have_posts() ): ?>
        <header class="page-header">
            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'agama-pro' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        </header>
        <?php endif; ?>
        
		<div id="content" role="main"<?php Helper::get_blog_isotope_class(); ?>>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

		<?php else : ?>
            <!-- Nothing Found -->
			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'agama-pro' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'agama-pro' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</article><!-- Nothing Found End -->

		<?php endif; ?>

		</div>
        
        <?php Helper::get_pagination(); ?>
        
        <?php Helper::get_infinite_scroll_load_more_btn(); ?>
        
	</section><!-- Section End -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>