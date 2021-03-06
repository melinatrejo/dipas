<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$options = array(
    'titles'        => esc_attr( get_theme_mod( 'agama_page_title', true ) ),
    'share_area'    => esc_attr( get_theme_mod( 'agama_share_box_visibility', 'posts' ) )
); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<?php if( has_post_thumbnail() ): ?> 
		<header class="entry-header">
            <?php the_post_thumbnail(); ?>
		</header>
		<?php endif; ?>
        
        <?php if( $options['titles'] ): ?>
            <h1 class="entry-title">
                <?php the_title(); ?>
            </h1>
        <?php endif; ?>

		<div class="entry-content">
			
			<?php the_content(); ?>
			
			<?php if( $options['share_area'] == 'pages' || $options['share_area'] == 'all' ): ?>
				<?php echo Agama::share(); ?>
			<?php endif; ?>
			
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'agama-pro' ), 'after' => '</div>' ) ); ?>
		
		</div>
		
		<?php if( current_user_can('edit_posts') ): ?>
		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'agama-pro' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>
		<?php endif; ?>
		
	</article>
