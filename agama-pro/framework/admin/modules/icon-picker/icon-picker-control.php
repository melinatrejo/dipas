<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Agama\Core;

/**
 * Register FontAwesome Icons Control
 *
 * @since 1.3.1
 */
add_action( 'customize_register', function( $wp_customize ) {
    /**
	 * The custom control class
	 */
	class Kirki_Controls_Agama_Icon_Picker_Control extends WP_Customize_Control {
        public $type    = 'agama-icon-picker';
        public function enqueue() {
            $uri = get_template_directory_uri() . '/framework/admin/modules/icon-picker/';
            
            // Deregister FontAwesome if enqueued by third party plugins.
            wp_deregister_style( 'font-awesome' );
            
            // Register FontAwesome bundled with theme.
            wp_enqueue_style( 'font-awesome', AGAMA_CSS . 'font-awesome.min.css', [], Core::version() );
            
            wp_enqueue_style( 'agama-icon-picker', $uri . 'assets/css/icon-picker.css', [], Core::version() );
            
            wp_enqueue_script( 'agama-icon-picker-control', $uri . 'assets/js/icon-picker-control.js', array(), Core::version() );
            wp_enqueue_script( 'agama-icon-picker', $uri . 'assets/js/icon-picker.js', array(), Core::version() );
        }
        public function render_content() { ?>
            <label for="label-<?php echo $this->id; ?>">
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php endif; ?>
            <div id="<?php echo $this->id; ?>">
                <input class="regular-text" type="hidden" name="agama-icon-value" value="<?php echo esc_attr( $this->value() ); ?>"/>
            
                <button id="label-<?php echo $this->id; ?>" 
                        data-target="#<?php echo $this->id; ?>"
                        type="button"
                        class="button agama-icon-picker fa <?php echo $this->value(); ?>"></button>
            </div>
            </label>
            <?php
        }
    }
    // Register our custom control with Kirki
	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['agama-icon-picker'] = 'Kirki_Controls_Agama_Icon_Picker_Control';
		return $controls;
	});
});