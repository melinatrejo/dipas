<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<!-- Small Thumbs Layout -->
<div class="small-thumbs">

	 <div class="entry clearfix">
		
        <?php agama_get_the_post_thumbnail(); ?>
		
		<div class="entry-c">
			
			<div class="entry-title">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div>
			
            <?php do_action( 'agama_blog_post_meta' ); ?>
			
			<!-- Entry Content -->
			<div class="entry-content">
				
				<?php the_excerpt(); ?>

			</div><!-- Entry Content End -->
			
		</div>
	
	</div>

</div><!-- Small Thumbs Layout End-->
