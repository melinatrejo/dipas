<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $meta_custom_logo;

$search_icon = esc_attr( get_theme_mod( 'agama_header_search', true ) );
$cart_icon = esc_attr( get_theme_mod( 'agama_header_cart_icon', true ) ); ?>

<div id="top-bar">
	<div id="top-bar-wrap" class="clearfix">
		
		<?php if( get_theme_mod( 'agama_top_navigation', true ) ): ?>
		<div class="pull-left nobottommargin">
			<div class="top-links agama-top-nav">
				<?php echo Agama::menu( 'agama_nav_top' ); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if( get_theme_mod( 'agama_top_nav_social', true ) ): ?>
		<div class="pull-right nobottommargin">
			<div id="top-social">
				<?php Agama::sociali( false, 'animated' ); ?>
			</div>
		</div>
		<?php endif; ?>
		
	</div>
</div>

<div class="sticky-header clearfix">
	<div class="sticky-header-inner clearfix">
		
		<div id="agama-logo" class="pull-left">
            <?php agama_logo(); ?>
		</div>
		
		<nav role="navigation" class="pull-right agama-primary-nav">
			<?php echo Agama::menu( 'agama_nav_primary', 'sticky-nav' ); ?>
		</nav><!-- .agama-primary-nav -->
        
        <div class="mobile-menu-icons">
            <?php if( $search_icon ) : ?>
            <div class="mobile-menu-search">
                <a class="top-search-trigger">
                    <i class="fa fa-search"></i>
                </a>
                <?php agama_header_search_box(); ?>
            </div>
            <?php endif; ?>
            <?php if( class_exists( 'Woocommerce' ) && $cart_icon ): ?>
            <div class="mobile-menu-cart">
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="shopping_cart"></a>
				<div class="cart_count"></div>
            </div>
            <?php endif; ?>
            <div><?php Agama::mobile_menu_toggle_icon(); ?></div>
        </div>
		
	</div>
</div>

<?php Agama::mobileNav(); ?>