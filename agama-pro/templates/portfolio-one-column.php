<?php
/**
 * Template Name: Portfolio 1 Column
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since Agama 1.0.1
 * @since 1.4.9.2 Updated the code.
 */

use Agama\Portfolio;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>
	
    <?php get_header(); ?>

	<?php
	$args = Portfolio::the_query();
	$loop = new WP_Query( $args ); 
	
	// Get portfolio item category names
    $category  = [];
	$tax_terms = get_terms( 'portfolio_categories' );
	foreach( $tax_terms as $tax_term ) {
		$category[] = $tax_term->name;
	} ?>
	
	<div id="primary">
		<div class="container" role="main">
		<?php if( $loop->have_posts() ): ?>
		
            <?php Portfolio::filter( $category ); ?>
			
			<!-- Portfolio Items -->
			<div id="portfolio" class="portfolio grid-container portfolio-1 clearfix">
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					
					<?php get_template_part( 'content', 'portfolio' ); ?>
					
				<?php endwhile; ?>
			</div><!-- Portfolio Items End -->
		
		<?php endif; wp_reset_postdata(); ?>
		</div>
		
		<?php Portfolio::pagination(); ?>

	</div>

<?php get_footer(); ?>