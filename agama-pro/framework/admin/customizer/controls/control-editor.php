<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
    return;
}

/**
 * Class to create a custom tags control
 */
class Agama_Editor_Control extends WP_Customize_Control
{
    public $type = 'editor';
  /**
   * Render the content on the theme customizer page
   */
    public function render_content() { ?>
        <label>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>" id="<?php echo $this->id; ?>" class="editorfield">
            <a onclick="javascript:WPEditorWidget.showEditor('<?php echo $this->id; ?>');" class="button edit-content-button"><?php esc_html_e( 'Edit content', 'agama-pro' ); ?></a>
        </label>
        <?php
    }
}

/**
 * Add Editor to the Customizer
 *
 * @since 1.3.8
 */
function agama_customizer_editor() { ?>
    <div id="wp-editor-widget-container" style="display: none;">
        <a class="close" href="javascript:WPEditorWidget.hideEditor();" title="<?php esc_attr_e( 'Close', 'agama-pro' ); ?>"><span class="icon"></span></a>
        <div class="editor">
            <?php $settings = array( 'textarea_rows' => 55, 'editor_height' => 260 );  wp_editor( '', 'wpeditorwidget', $settings ); ?>
            <p><a href="javascript:WPEditorWidget.updateWidgetAndCloseEditor(true);" class="button button-primary"><?php esc_html_e( 'Save and close', 'agama-pro' ); ?></a></p>
        </div>
    </div>
    <div id="wp-editor-widget-backdrop" style="display: none;"></div>

    <?php
}
	
add_action( 'widgets_admin_page', 'agama_customizer_editor', 100 );
add_action( 'customize_controls_print_footer_scripts', 'agama_customizer_editor', 1 );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
