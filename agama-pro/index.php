<?php
/**
 * The main template file
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama
 */

use Agama\Helper;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php get_header(); ?>
    
	<div id="primary" class="site-content <?php Agama::bs_class(); ?>">
        <div id="content" role="main"<?php Helper::get_blog_isotope_class(); ?>>
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

		<?php else : ?>
			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) : // Show a different message to a logged-in user who can add posts. ?>
				
                <header class="entry-header">
					<h1 class="entry-title">
                        <?php esc_html_e( 'No posts to display', 'agama-pro' ); ?>
                    </h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'agama-pro' ), admin_url( 'post-new.php' ) ); ?></p>
				</div>

			<?php else : // Show the default message to everyone else. ?>
				
                <header class="entry-header">
					<h1 class="entry-title">
                        <?php esc_html_e( 'Nothing Found', 'agama-pro' ); ?>
                    </h1>
				</header>

				<div class="entry-content">
					<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'agama-pro' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			
            <?php endif; // end current_user_can() check ?>

			</article><!-- .no-results.not-found -->

		<?php endif; // end have_posts() ?>

		</div><!-- #content -->
		
        <?php Helper::get_pagination(); ?>
		
		<?php Helper::get_infinite_scroll_load_more_btn(); ?>
		
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
