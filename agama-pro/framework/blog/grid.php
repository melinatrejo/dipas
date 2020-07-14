<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$agama_lightbox = get_theme_mod( 'agama_blog_lightbox', true );
 
if( $agama_lightbox == 'on' ) {
	$data_lightbox 	= 'data-lightbox="image"';
	$img_href 		= agama_return_image_src('full');
} else {
	$data_lightbox	= '';
	$img_href 		= get_permalink();
} 

$agama_share_area 	= get_theme_mod( 'agama_share_box_visibility', 'posts' );

if( get_theme_mod( 'agama_blog_crop_featured_images', true ) ) {
    $img_src = agama_return_image_src( 'post-thumbnail' ); 
} else {
    $img_src = agama_return_image_src( 'full' );
} ?>

<!-- Article Header -->
<header class="entry-header">
    
    <?php if( has_post_thumbnail() ): ?>
	<figure class="hover1">
		<?php agama_get_the_post_thumbnail(); ?>
	</figure>
    <?php endif; ?>
	
	<h1 class="entry-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h1>
	
	<?php Agama::post_meta(); ?>

</header><!-- Article Header End -->

<div class="entry-sep"></div>

<!-- Article Entry Wrapper -->
<div class="article-entry-wrapper">

	<div class="entry-content">
    <?php 
        
        the_excerpt();
		
        wp_link_pages( 
            array( 
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'agama-pro' ), 
                'after' => '</div>' 
            ) 
        ); ?>
	</div>
	
	<footer class="entry-meta">
		
		<?php edit_post_link( esc_html__( 'Edit', 'agama-pro' ), '<span class="edit-link">', '</span>' ); ?>
		
	</footer>

</div><!-- Article Entry Wrapper End -->
