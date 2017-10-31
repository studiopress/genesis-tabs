<?php
/**
 * The main class.
 *
 * @since 0.9.0
 */
final class Genesis_Tabs {

	/**
	 * Plugin version
	 */
	public $plugin_version = '0.9.4';


	/**
	 * Minimum WordPress version.
	 */
	public $min_wp_version = '4.8';

	/**
	 * Minimum Genesis version.
	 */
	public $min_genesis_version = '2.5';

	/**
	 * The plugin textdomain, for translations.
	 */
	public $plugin_textdomain = 'genesis-tabs';

	/**
	 * The url to the plugin directory.
	 */
	public $plugin_dir_url;

	/**
	 * The path to the plugin directory.
	 */
	public $plugin_dir_path;

	/**
	 * Assets object.
	 */
	public $assets;

	/**
	 * Widget object.
	 */
	public $widget;


	/**
	 * Constructor.
	 *
	 * @since 0.9.4
	 */
	public function __construct() {

		$this->plugin_dir_url  = plugin_dir_url( __FILE__ );
		$this->plugin_dir_path = plugin_dir_path( __FILE__ );

	}

	/**
	 * Initialize.
	 *
	 * @since 0.9.4
	 */
	public function init() {

		add_action( 'admin_notices', array( $this, 'requirements_notice' ) );
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'genesis_setup', array( $this, 'instantiate' ) );

	}

	/**
	 * Show admin notice if minimum requirements aren't met.
	 *
	 * @since 0.9.0
	 */
	public function requirements_notice() {

		if ( ! defined( 'PARENT_THEME_VERSION' ) || ! version_compare( PARENT_THEME_VERSION, $this->min_genesis_version, '>=' ) ) {

			$plugin = get_plugin_data( __FILE__ );

			$action = defined( 'PARENT_THEME_VERSION' ) ? __( 'upgrade to', 'genesis-tabs' ) : __( 'install and activate', 'genesis-tabs' );

			$message = sprintf( __( '%s requires WordPress %s and <a href="%s" target="_blank">Genesis %s</a>, or greater. Please %s the latest version of Genesis to use this plugin.', 'genesis-tabs' ), $plugin['name'], $this->min_wp_version, 'http://my.studiopress.com/?download_id=91046d629e74d525b3f2978e404e7ffa', $this->min_genesis_version, $action );
			echo '<div class="notice notice-warning"><p>' . $message . '</p></div>';

		}

	}

	/**
	 * Load the plugin textdomain, for translation.
	 *
	 * @since 0.9.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( $this->plugin_textdomain, false, dirname( plugin_basename( __FILE__ ) ) . 'languages/' );
	}

	/**
	 * Include the class file, instantiate the classes, create objects.
	 *
	 * @since 0.9.0
	 */
	public function instantiate() {

		require_once( $this->plugin_dir_path . 'includes/class-genesis-tabs-assets.php' );
		$this->assets = new Genesis_Tabs_Assets;

		require_once( $this->plugin_dir_path . 'includes/class-genesis-tabs-widget.php' );
		$this->widget = new Genesis_Tabs_Widget;

	}

}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @since 0.9.0
 */
function Genesis_Tabs() {

	static $object;

	if ( null == $object ) {
		$object = new Genesis_Tabs;
	}

	return $object;

}

/**
 * Initialize the object on	`plugins_loaded`.
 */
add_action( 'plugins_loaded', array( Genesis_Tabs(), 'init' ) );
