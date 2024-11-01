<?php

/**
 * Plugin Name:       Widget Styler
 * Plugin URI:        http://theme.blue/plugins/widget-styler
 * Description:       Easily style your widgets
 * Version:           1.0.0
 * Author:            theme.blue
 * Author URI:        http://theme.blue
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       widget-styler
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Class for handling the fields
 *
 * @since  1.0.0
 */
class Widget_Styler {

	public function __construct() {
    	add_action( 'in_widget_form', array( $this, 'widget_form' ), 1, 3 );
    	add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 10, 2 );
    	add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ), 10, 2 );
    	add_filter( 'widget_update_callback', array( $this, 'widget_update'), 10, 2 );
    	add_filter( 'dynamic_sidebar_params', array( $this, 'widget_output'), 99, 2 );
    	add_action( 'plugins_loaded', array( $this, 'i18n' ), 10, 2 );

	}
	
	/**
	* Create the new fields
	*/
	public function widget_form( $widget, $args, $instance ) {
		$background_color   = isset( $instance['background_color'] ) ? esc_attr( $instance['background_color'] ) : '';
		$text_color         = isset( $instance['text_color'] ) ? esc_attr( $instance['text_color'] ) : '';
		$widget_title_color = isset( $instance['widget_title_color'] ) ? esc_attr( $instance['widget_title_color'] ) : '';
		$links_color 		= isset( $instance['links_color'] ) ? esc_attr( $instance['links_color'] ) : '';		
		$links_hover 		= isset( $instance['links_hover'] ) ? esc_attr( $instance['links_hover'] ) : '';		
		$padding            = isset( $instance['padding'] ) ? intval( $instance['padding'] ) : '';
	?>

	<div class="options-block">
		<h4><?php _e( 'Styling options', 'widget-styler' ); ?><span>+</span></h4>
		<div class="options-block-inner">
			<hr>
			<p><label for="<?php echo $widget->get_field_id('background_color'); ?>"><?php _e('Background color', 'widget-styler'); ?><br></label>
			<input type="text" name="<?php echo $widget->get_field_name('background_color'); ?>" id="<?php echo $widget->get_field_id('background_color'); ?>" class="color-field" value="<?php echo $background_color; ?>" /></p>
        
			<p><label for="<?php echo $widget->get_field_id('text_color'); ?>"><?php _e('Text color', 'widget-styler'); ?><br></label>
			<input type="text" name="<?php echo $widget->get_field_name('text_color'); ?>" id="<?php echo $widget->get_field_id('text_color'); ?>" class="color-field" value="<?php echo $text_color; ?>" /></p>  
        
			<p><label for="<?php echo $widget->get_field_id('widget_title_color'); ?>"><?php _e('Widget title color', 'widget-styler'); ?><br></label>
			<input type="text" name="<?php echo $widget->get_field_name('widget_title_color'); ?>" id="<?php echo $widget->get_field_id('widget_title_color'); ?>" class="color-field" value="<?php echo $widget_title_color; ?>" /></p>       
            
			<p><label for="<?php echo $widget->get_field_id('links_color'); ?>"><?php _e('Links color', 'widget-styler'); ?><br></label>
			<input type="text" name="<?php echo $widget->get_field_name('links_color'); ?>" id="<?php echo $widget->get_field_id('links_color'); ?>" class="color-field" value="<?php echo $links_color; ?>" /></p>        

			<p><label for="<?php echo $widget->get_field_id('links_hover'); ?>"><?php _e('Links color (hover)', 'widget-styler'); ?><br></label>
			<input type="text" name="<?php echo $widget->get_field_name('links_hover'); ?>" id="<?php echo $widget->get_field_id('links_hover'); ?>" class="color-field" value="<?php echo $links_hover; ?>" /></p>        

			<p><label for="<?php echo $widget->get_field_id('padding'); ?>"><?php _e('Padding [px]', 'widget-styler'); ?><br></label>
			<input id="<?php echo $widget->get_field_id( 'padding' ); ?>" name="<?php echo $widget->get_field_name( 'padding' ); ?>" type="text" value="<?php echo $padding; ?>" size="3" /></p>        
       
		</div>   
	</div>
	<?php
	}

	/**
	* Update function
	*/
	public function widget_update ( $instance, $new_instance ) {
		$instance['background_color']   = sanitize_text_field( $new_instance['background_color'] );
		$instance['text_color']         = sanitize_text_field( $new_instance['text_color'] );
		$instance['widget_title_color'] = sanitize_text_field( $new_instance['widget_title_color'] );    
		$instance['links_color'] 		= sanitize_text_field( $new_instance['links_color'] );
		$instance['links_hover'] 		= sanitize_text_field( $new_instance['links_hover'] );
		$instance['padding']            = absint($new_instance['padding']);

		return $instance;
	}

	/**
	* Output
	*/
	public function widget_output( $params ) {
	    if ( is_admin() ) {
			return $params;
	    }

	    global $wp_registered_widgets;
	    $id = $params[0]['widget_id'];

	    if ( isset($wp_registered_widgets[$id]['callback'][0]) && is_object($wp_registered_widgets[$id]['callback'][0]) ) {
			$settings           = $wp_registered_widgets[$id]['callback'][0]->get_settings();
			$instance           = $settings[substr( $id, strrpos( $id, '-' ) + 1 )];
			$bg_color 		  	= isset($instance['background_color']) ? 'background-color: ' . esc_attr($instance['background_color']) . ';' : '';
			$text_color 	    = isset($instance['text_color']) ? 'color: ' . esc_attr($instance['text_color']) . ';' : '';
			$widget_title_color = isset($instance['widget_title_color']) ? 'color: ' . esc_attr($instance['widget_title_color']) . ';' : '';
			$links_color 		= isset($instance['links_color']) ? 'data-links-color="' . esc_attr($instance['links_color']) . '" ' : '';    
			$links_hover 		= isset($instance['links_hover']) ? 'data-links-hover="' . esc_attr($instance['links_hover']) . '" ' : '';    
			$padding            = isset( $instance['padding'] ) ? 'padding: ' . intval($instance['padding']) . 'px;' : '';

			$params[0]['before_widget'] = str_replace('class=', 'style="' . $text_color . $bg_color . $padding . '" class=', $params[0]['before_widget']);
			$params[0]['before_widget'] = str_replace('class=', $links_hover . $links_color . ' class=', $params[0]['before_widget']);
			$params[0]['before_title'] 	= str_replace('class=', 'style="' . $widget_title_color . '" class=', $params[0]['before_title']);
	     
	    }
	    return $params;
	}

	/**
	* Locale
	*/
	function i18n() {
		load_plugin_textdomain( 'widget-styler', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}	

	/**
	* Admin styles and scripts
	*/  
	public function admin_scripts( $hook ) {
		if ( ( 'customize.php' != $hook ) && ( 'widgets.php' != $hook ) ) {
			return;
		}     
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'widget-styler-scripts', plugin_dir_url( __FILE__ ) . '/assets/admin.js', array( 'wp-color-picker' ), false, true );
		wp_enqueue_style( 'widget-styler-styles', plugin_dir_url( __FILE__ ) . '/assets/admin.css' );
  	}

	/**
	* Frontend scripts
	*/  
	public function front_scripts() {
		wp_enqueue_script( 'widget-styler-front-scripts', plugin_dir_url( __FILE__ ) . '/assets/front.js', array( 'jquery' ), false, true );
  	}  	

}

new Widget_Styler();