<?php
/**
 * The template used for displaying Portfolio
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama v1.0.1
 */	

    // Do not allow direct access to the file.
    if( ! defined( 'ABSPATH' ) ) {
        exit;
    }

	// Get portfolio item category names
	$terms = wp_get_post_terms( get_the_id(), 'portfolio_categories', array( 'order' => 'ASC' ) );
	foreach( $terms as $term ) {
		$class_category[] = strtolower( $term->name );
		$portf_category[] = ucfirst( $term->name );
	}

    $class_category = isset( $class_category ) ? implode( ' ', $class_category ) : '';
	
	$pt_skills_args	= array(
		'fa_class'		=> 'fa-check',
		'before_title'	=> '<strong>',
		'after_title'	=> '</strong>',
		'title' 		=> __( 'Created Using:', 'agama-pro' ),
		'before_href'	=> '<i class="fa fa-check"></i>',
		'separator' 	=> ', '
	); ?>
    
	<?php if( is_page_template( 'templates/portfolio-one-column.php' ) ): // PORTFOLIO ONE COLUMN ?>
	<article id="post-<?php the_ID(); ?>" class="portfolio-item <?php echo $class_category; ?> clearfix">
       
        <?php agama_portfolio_get_the_post_thumbnail( get_the_ID(), 'portfolio-one' ); ?>
        
		<div class="portfolio-desc">
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<span><?php echo get_the_category_list(', '); ?></span>
			
			<p><?php the_excerpt(); ?></p>
			
			<ul class="iconlist">
				<li><?php Agama::portfolio_skills( $pt_skills_args ); ?></li>
			</ul>
			
			<?php if( Agama::get_meta('_agama_pt_project_url', '', get_the_ID()) ): ?>
			<a target="_blank" href="<?php echo esc_url( Agama::get_meta('_agama_pt_project_url', '', get_the_ID()) ); ?>" class="button button-3d noleftmargin">
				<?php _e( 'View Project', 'agama-pro' ); ?>
			</a>
			<?php endif; ?>
			
		</div>
	</article>
	
	<?php elseif( is_page_template( 'templates/portfolio-two-columns.php' ) ):  // PORTFOLIO TWO COLUMNS ?>
	<article id="post-<?php the_ID(); ?>" class="portfolio-item <?php echo $class_category; ?>">
        
        <?php agama_portfolio_get_the_post_thumbnail( get_the_ID(), 'portfolio-one' ); ?>
        
		<div class="portfolio-desc">
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			
			<?php if( ! empty( $portf_category ) ): ?>
				<span><?php echo implode( ', ', $portf_category ); ?></span>
			<?php endif; ?>
		</div>
        
	</article>
	
	<?php elseif( is_page_template( 'templates/portfolio-three-columns.php' ) ): // PORTFOLIO THREE COLUMNS ?>
	<article id="post-<?php the_ID(); ?>" class="portfolio-item <?php echo $class_category; ?>">
		
       <?php agama_portfolio_get_the_post_thumbnail( get_the_ID(), 'portfolio-one' ); ?>
        
		<div class="portfolio-desc">
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			
			<?php if( ! empty( $portf_category ) ): ?>
				<span><?php echo implode( ', ', $portf_category ); ?></span>
			<?php endif; ?>
		</div>
	</article>
	
	<?php elseif( is_page_template( 'templates/portfolio-four-columns.php' ) ): // PORTFOLIO FOUR COLUMNS ?>
		<article id="post-<?php the_ID(); ?>" class="portfolio-item <?php echo $class_category; ?>">
			
            <?php agama_portfolio_get_the_post_thumbnail( get_the_ID(), 'portfolio-one' ); ?>
            
			<div class="portfolio-desc">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				
				<?php if( ! empty( $portf_category ) ): ?>
					<span><?php echo implode( ', ', $portf_category ); ?></span>
				<?php endif; ?>
			</div>
		</article>

    <?php elseif( is_page_template( 'templates/portfolio-full-width.php' ) ): // PORTFOLIO FULL WIDTH  ?>
        <article id="post-<?php the_ID(); ?>" class="portfolio-item <?php echo $class_category; ?>">
            
            <?php agama_portfolio_get_the_post_thumbnail( get_the_ID(), 'portfolio-one' ); ?>
            
            <div class="portfolio-desc">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                
                <?php if( ! empty( $portf_category ) ): ?>
				    <span><?php echo implode( ', ', $portf_category ); ?></span>
                <?php endif; ?>
            </div>
            
        </article>
	<?php endif; ?>
