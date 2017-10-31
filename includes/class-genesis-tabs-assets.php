<?php
/**
 * Register and enqueue assets (scripts and styles) for Genesis Tabs.
 *
 * @since 0.9.4
 */
class Genesis_Tabs_Assets {

	/**
	 * Initialize the class.
	 *
	 * @since 0.9.4
	 */
	public function init() {

		// Register scripts so they can be enqueued later
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

	}

	/**
	 * Register styles.
	 *
	 * @since 0.9.4
	 */
	public function register_styles() {

		wp_register_style( 'genesis-tabs', Genesis_Tabs()->plugin_dir_url . 'assets/genesis-tabs.css', Genesis_Tabs()->plugin_version );

	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 0.9.4
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'jquery-ui-tabs' );

	}

	/**
	 * Enqueue styles.
	 *
	 * @since 0.9.4
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'genesis-tabs' );

	}

}
