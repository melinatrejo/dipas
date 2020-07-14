<?php
/**
 * Google Map
 *
 * The Google map widget.
 *
 * @since 1.4.7
 * @since 1.5.0 Updated the code.
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register
 *
 * Register the widget.
 *
 * @since 1.4.7
 */
function register_agama_google_maps_widget() {
    
    register_widget( 'AgamaGoogleMaps' );
    
}
add_action( 'widgets_init', 'register_agama_google_maps_widget' );

class AgamaGoogleMaps extends WP_Widget {
    
    /**
     * Register Wdiget with WordPress
     */
    function __construct() {
        
        if( is_customize_preview() ) {
            $widgetName = esc_html__( 'Google Map', 'agama-pro' );
        } else {
            $widgetName = esc_html__( 'Agama: Google Map', 'agama-pro' );
        }
        
        parent::__construct( 'agama_widget_google_map', $widgetName, array(
            'classname' => 'agama-widget-google-map agama-widget',
            'description' => esc_html__( 'Agama Google Map Section widget.', 'agama-pro' ),
            'customize_selective_refresh' => false
        ) );
        
        add_action( 'wp_footer', [ $this, 'wp_footer' ] );
    }
    
    /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
        extract( $args );
        
        $map_type           = isset( $instance['map_type'] ) ? esc_attr( $instance['map_type'] ) : 'roadmap';
        $map_address        = isset( $instance['map_address'] ) ? esc_attr( $instance['map_address'] ) : 'New York';
        $map_zoom           = isset( $instance['map_zoom'] ) ? esc_attr( $instance['map_zoom'] ) : '14';
        $map_marker         = isset( $instance['map_marker'] ) ? esc_attr( $instance['map_marker'] ) : '';
        $add_marker         = isset( $instance['add_marker'] ) ? esc_attr( $instance['add_marker'] ) : false;
        $map_marker_html    = isset( $instance['map_marker_html'] ) ? $instance['map_marker_html'] : '';
        $map_marker_popup   = isset( $instance['map_marker_popup'] ) ? $instance['map_marker_popup'] : false;
        $pan_control        = isset( $instance['pan_control'] ) ? $instance['pan_control'] : true;
        $zoom_control       = isset( $instance['zoom_control'] ) ? $instance['zoom_control'] : true;
        $map_type_control   = isset( $instance['map_type_control'] ) ? $instance['map_type_control'] : true;
        $scale_control      = isset( $instance['scale_control'] ) ? $instance['scale_control'] : false;
        $street_view_control= isset( $instance['street_view_control'] ) ? $instance['street_view_control'] : false;
        $map_width          = isset( $instance['map_width'] ) ? esc_attr( $instance['map_width'] ) : '100%';
        $map_height         = isset( $instance['map_height'] ) ? esc_attr( $instance['map_height'] ) : '300px';
        
        echo $before_widget;
        
        if( is_customize_preview() ) {
            echo '<span class="widget-name">'. esc_html( $this->name ) .'</span>';
        }
        
        echo '<section 
                class="agama-google-map" 
                data-type="'. strtoupper( $map_type ) .'" 
                data-address="'. $map_address .'" 
                data-zoom="'. $map_zoom .'" 
                data-marker="'. $map_marker .'" 
                data-marker-popup-enabled="'. $add_marker .'" 
                data-marker-popup="'. $map_marker_popup .'" 
                data-marker-html="'. $map_marker_html .'" 
                data-pan-control="'. $pan_control .'" 
                data-zoom-control="'. $zoom_control .'" 
                data-map-type-control="'. $map_type_control .'"
                data-scale-control="'. $scale_control .'" 
                data-street-view-control="'. $street_view_control .'"
                style="width: '. $map_width .'; height: '. $map_height .';"></section>';
        
        echo $after_widget; ?>
    <?php
    }
    
    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        $defaults = array(
            'map_type' => 'roadmap',
            'map_address' => 'New York',
            'map_zoom' => '14',
            'add_marker' => '',
            'map_marker' => '',
            'map_marker_html' => '',
            'map_marker_popup' => false,
            'pan_control' => true,
            'zoom_control' => true,
            'map_type_control' => true,
            'scale_control' => false,
            'street_view_control' => false,
            'map_width' => '100%',
            'map_height' => '300px'
        );
        
        $instance = wp_parse_args( ( array ) $instance, $defaults ); ?>
        
        <div class="agama-google-map-settings">
            <p>
                <label for="<?php echo $this->get_field_id( 'map_type' ); ?>"><?php esc_html_e( 'Map Type', 'agama-pro' ); ?></label>
                <select id="<?php echo $this->get_field_id( 'map_type' ); ?>" name="<?php echo $this->get_field_name( 'map_type' ); ?>" class="widefat">
                    <option value="roadmap" <?php selected( 'roadmap', $instance['map_type'] ); ?>><?php esc_html_e( 'Roadmap', 'agama-pro' ); ?></option>
                    <option value="satellite" <?php selected( 'satellite', $instance['map_type'] ); ?>><?php esc_html_e( 'Satellite', 'agama-pro' ); ?></option>
                    <option value="hybrid" <?php selected( 'hybrid', $instance['map_type'] ); ?>><?php esc_html_e( 'Hybrid', 'agama-pro' ); ?></option>
                    <option value="terrain" <?php selected( 'terrain', $instance['map_type'] ); ?>><?php esc_html_e( 'Terrain', 'agama-pro' ); ?></option>
                </select>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'map_address' ); ?>"><?php esc_html_e( 'Map Address', 'agama-pro' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'map_address' ); ?>" name="<?php echo $this->get_field_name( 'map_address' ); ?>" value="<?php echo esc_attr( $instance['map_address'] ); ?>" type="text"> 
            </p>
            
            <div class="marker-group">
                <p>
                    <input class="widefat add_marker" id="<?php echo $this->get_field_id( 'add_marker' ); ?>" name="<?php echo $this->get_field_name( 'add_marker' ); ?>" value="1" type="checkbox" <?php checked( true, $instance['add_marker'] ); ?> > 
                    <label for="<?php echo $this->get_field_id( 'add_marker' ); ?>"><?php esc_html_e( 'Add marker ?', 'agama-pro' ); ?></label>
                </p>

                 <p class="google-marker">
                    <label for="<?php echo $this->get_field_id( 'map_marker' ); ?>"><?php esc_html_e( 'Map Marker Address', 'agama-pro' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'map_marker' ); ?>" name="<?php echo $this->get_field_name( 'map_marker' ); ?>" value="<?php echo esc_attr( $instance['map_marker'] ); ?>" type="text"> 
                </p>

                <p class="google-marker">
                    <label for="<?php echo $this->get_field_id( 'map_marker_popup' ); ?>"><?php esc_html_e( 'Map Marker Popup Display', 'agama-pro' ); ?></label>
                    <select id="<?php echo $this->get_field_id( 'map_marker_popup' ); ?>" name="<?php echo $this->get_field_name( 'map_marker_popup' ); ?>" class="widefat">
                        <option value="1" <?php selected( true, $instance['map_marker_popup'] ); ?>><?php esc_html_e( 'Always Visible', 'agama-pro' ); ?></option>
                        <option value="0" <?php selected( false, $instance['map_marker_popup'] ); ?>><?php esc_html_e( 'Visible on Marker Click', 'agama-pro' ); ?></option>
                    </select>
                </p>

                <p class="google-marker">
                    <label for="<?php echo $this->get_field_id( 'map_marker_html' ); ?>"><?php esc_html_e( 'Map Marker Popup Content', 'agama-pro' ); ?></label>
                    <textarea class="widefat" id="<?php echo $this->get_field_id( 'map_marker_html' ); ?>" name="<?php echo $this->get_field_name( 'map_marker_html' ); ?>" type="text"><?php echo esc_attr( $instance['map_marker_html'] ); ?></textarea>
                </p>
            </div>

            <p>
                <label for="<?php echo $this->get_field_id( 'map_zoom' ); ?>"><?php esc_html_e( 'Map Zoom', 'agama-pro' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'map_zoom' ); ?>" name="<?php echo $this->get_field_name( 'map_zoom' ); ?>" value="<?php echo esc_attr( $instance['map_zoom'] ); ?>" type="text"> 
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'map_width' ); ?>"><?php esc_html_e( 'Map Width', 'agama-pro' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'map_width' ); ?>" name="<?php echo $this->get_field_name( 'map_width' ); ?>" value="<?php echo esc_attr( $instance['map_width'] ); ?>" type="text"> 
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'map_height' ); ?>"><?php esc_html_e( 'Map Height', 'agama-pro' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'map_height' ); ?>" name="<?php echo $this->get_field_name( 'map_height' ); ?>" value="<?php echo esc_attr( $instance['map_height'] ); ?>" type="text"> 
            </p>
            
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id( 'pan_control' ); ?>" name="<?php echo $this->get_field_name( 'pan_control' ); ?>" value="1" type="checkbox" <?php checked( true, $instance['pan_control'] ); ?> > 
                <label for="<?php echo $this->get_field_id( 'pan_control' ); ?>"><?php esc_html_e( 'Pan control', 'agama-pro' ); ?></label>
            </p>
            
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id( 'zoom_control' ); ?>" name="<?php echo $this->get_field_name( 'zoom_control' ); ?>" value="1" type="checkbox" <?php checked( true, $instance['zoom_control'] ); ?> > 
                <label for="<?php echo $this->get_field_id( 'zoom_control' ); ?>"><?php esc_html_e( 'Zoom control', 'agama-pro' ); ?></label>
            </p>
            
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id( 'map_type_control' ); ?>" name="<?php echo $this->get_field_name( 'map_type_control' ); ?>" value="1" type="checkbox" <?php checked( true, $instance['map_type_control'] ); ?> > 
                <label for="<?php echo $this->get_field_id( 'map_type_control' ); ?>"><?php esc_html_e( 'Map type control', 'agama-pro' ); ?></label>
            </p>
            
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id( 'scale_control' ); ?>" name="<?php echo $this->get_field_name( 'scale_control' ); ?>" value="1" type="checkbox" <?php checked( true, $instance['scale_control'] ); ?> > 
                <label for="<?php echo $this->get_field_id( 'scale_control' ); ?>"><?php esc_html_e( 'Scale control', 'agama-pro' ); ?></label>
            </p>
            
            <p>
                <input class="widefat" id="<?php echo $this->get_field_id( 'street_view_control' ); ?>" name="<?php echo $this->get_field_name( 'street_view_control' ); ?>" value="1" type="checkbox" <?php checked( true, $instance['street_view_control'] ); ?> > 
                <label for="<?php echo $this->get_field_id( 'street_view_control' ); ?>"><?php esc_html_e( 'Street view control', 'agama-pro' ); ?></label>
            </p>
    </div>

    <?php 
    }
    
    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        
        $instance['map_type']           = esc_attr( $new_instance['map_type'] );
        $instance['map_address']        = esc_attr( $new_instance['map_address'] );
        $instance['map_zoom']           = esc_attr( $new_instance['map_zoom'] );
        $instance['add_marker']         = esc_attr( $new_instance['add_marker'] );
        $instance['map_marker']         = esc_attr( $new_instance['map_marker'] );
        $instance['map_marker_html']    = esc_attr( $new_instance['map_marker_html'] );
        $instance['map_marker_popup']   = esc_attr( $new_instance['map_marker_popup'] );
        $instance['pan_control']        = esc_attr( $new_instance['pan_control'] );
        $instance['zoom_control']       = esc_attr( $new_instance['zoom_control'] );
        $instance['map_type_control']   = esc_attr( $new_instance['map_type_control'] );
        $instance['scale_control']      = esc_attr( $new_instance['scale_control'] );
        $instance['street_view_control']= esc_attr( $new_instance['street_view_control'] );
        $instance['map_width']          = esc_attr( $new_instance['map_width'] );
        $instance['map_height']         = esc_attr( $new_instance['map_height'] );

		return $instance;
	}
    
    /**
     * Enqueue Footer Scripts
     *
     * Enqueue widget footer frontend scripts.
     */
    function wp_footer() {
        $options = get_option( 'widget_agama_widget_google_map' );
        $api = 'AIzaSyAo_bkHdCDF4mnpMrGGbXWrqkxtSEU2-5I'; ?>
        
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=<?php echo esc_attr( $api ); ?>"></script>
        <script type="text/javascript" src="<?php echo AGAMA_URI; ?>assets/js/jquery.gmap.js"></script>
        
        <script type="text/javascript">
        jQuery( document ).ready(function($){
            $('.agama-google-map').each(function(){
                var address = $(this).data('address');
                var type = $(this).data('type');
                var zoom = $(this).data('zoom');
                var marker = $(this).data('marker');
                var popup_enabled = $(this).data('marker-popup-enabled');
                var marker_popup = $(this).data('marker-popup');
                var marker_html = $(this).data('marker-html');
                var pan_control = $(this).data('pan-control');
                var zoom_control = $(this).data('zoom-control');
                var map_type_control = $(this).data('map-type-control');
                var scale_control = $(this).data('scale-control');
                var street_view_control = $(this).data('street-view-control');
                
                if( ! popup_enabled ) {
                    var markers_data = [];
                } else {
                    var markers_data = [{
                        address: marker,
                        popup: marker_popup,
                        html: marker_html
                    }];
                }
                
                $(this).gMap({
                    address: address,
                    maptype: type,
                    zoom: zoom,
                    doubleclickzoom: false,
                    markers: markers_data,
                    controls: {
                        panControl: pan_control,
                        zoomControl: zoom_control,
                        mapTypeControl: map_type_control,
                        scaleControl: scale_control,
                        streetViewControl: street_view_control,
                        overviewMapControl: false
                    }
                }); 
            });
        });
        </script>
    <?php
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
