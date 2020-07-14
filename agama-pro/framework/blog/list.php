<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php agama_get_the_post_thumbnail(); ?>

<!-- Article Entry Wrapper -->
<div class="article-entry-wrapper">
	
	<?php 
	/**
	 * agama_blog_post_date_and_format hook
	 *
	 * @hooked agama_render_blog_post_date - 10 (output HML post date & format)
	 */
	do_action( 'agama_blog_post_date_and_format' ); ?>
	
	<!-- Entry Content -->
	<div class="entry-content">
	
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		
		<?php Agama::post_meta(); ?>
		
		<?php the_excerpt(); ?>
	
	</div><!-- Entry Content End -->
	
</div><!-- Article Entry Wrapper End -->
