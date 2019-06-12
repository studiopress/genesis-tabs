<?php
/**
 * Genesis Tabs file.
 *
 * @package genesis-tabs
 */

/**
 * Simple class to handle all the non-widget aspects of the plugin
 *
 * @package Genesis Tabs
 * @since 0.9.0
 **/
class Genesis_Tabs {

	/** Faux Constructor */
	public function init() {

		add_action( 'widgets_init', array( $this, 'register_widget' ) );

		add_action( 'wp_print_styles', array( $this, 'register_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

		add_action( 'wp_footer', array( $this, 'footer_js' ), 20 );

	}

	/**
	 * Register Widget
	 */
	public function register_widget() {
		register_widget( 'Genesis_Tabs_Widget' );
	}

	/**
	 * Register Scripts
	 */
	public function register_scripts() {
		wp_enqueue_script( 'jquery-ui-tabs' );
	}

	/**
	 * Register Styles
	 */
	public function register_styles() {
		wp_enqueue_style( 'genesis-tabs-stylesheet', GENESIS_TABS_URL . '/assets/css/style.css', false, GENESIS_TABS_PLUGIN_VERSION );
	}

	/**
	 * Footer
	 */
	public function footer_js() {
		echo '<script type="text/javascript">jQuery(document).ready(function($) { $(".ui-tabs").tabs(); });</script>' . "\n";
	}

}
