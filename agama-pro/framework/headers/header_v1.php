<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $meta_custom_logo;

$search_icon = esc_attr( get_theme_mod( 'agama_header_search', true ) );
$cart_icon = esc_attr( get_theme_mod( 'agama_header_cart_icon', true ) ); ?>

<!-- Top Wrapper -->
<div class="top-nav-wrapper">
	
	<div class="top-nav-sub-wrapper">
		
		<?php if( get_theme_mod( 'agama_top_navigation', true ) ): ?>
		<nav id="top-navigation" class="top-navigation agama-top-nav pull-left" role="navigation">
			
			<?php echo Agama::menu( 'agama_nav_top', 'top-nav-menu' ); ?>
			
		</nav>
		<?php endif; ?>
		
		<?php if( get_theme_mod( 'agama_top_nav_social', true ) ): ?>
			<div id="top-social" class="pull-right">
				<?php Agama::sociali( false, 'animated' ); ?>
			</div>
		<?php endif; ?>
		
	</div>
	
</div><!-- Top Wrapper End -->

<hgroup id="agama-logo">
    
    <?php agama_logo(); ?>
	
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
    </div><!-- .mobile-menu-icons -->
	
</hgroup>

<nav class="main-navigation agama-primary-nav clearfix" role="navigation">
	<div class="main-navigation-sub-wrapper">
		<?php echo Agama::menu( 'agama_nav_primary', 'nav-menu' ); ?>
	</div>
</nav><!-- .agama-primary-nav -->

<?php Agama::mobileNav(); ?>
