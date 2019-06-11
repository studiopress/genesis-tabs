<?php
/**
 * Plugin Name: Genesis Tabs
 * Plugin URI: http://wordpress.org/plugins/genesis-tabs/
 * Description: Genesis Tabs extends the Featured Post widget to create a simple tabbed area.
 * Author: StudioPress
 * Author URI: http://www.studiopress.com/
 *
 * Version: 0.9.4
 *
 * License: GNU General Public License v2.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 *
 * @package genesis-tabs
 */

register_activation_hook( __FILE__, 'genesis_tabs_activation_check' );
/**
 * This function runs on plugin activation. It checks to make sure the required
 * minimum Genesis version is installed. If not, it deactivates itself.
 *
 * @since 0.9.0
 */
function genesis_tabs_activation_check() {

		$latest  = '2.5.0';
		$genesis = wp_get_theme( 'genesis' );

	if ( 'genesis' !== basename( get_template_directory() ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
		/* Translators: The string is a url to the genesis framework. */
		wp_die( sprintf( esc_html( __( 'Sorry, you can\'t activate unless you have installed <a href="%s">Genesis</a>', 'apl' ), 'http://www.studiopress.com/themes/genesis' ) ) );
	}

	if ( version_compare( $genesis->get( 'Version' ), $latest, '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
		/* Translators: String 1 is a url to the genesis framework. String 2 is the lowest version number required. */
		wp_die( sprintf( esc_html( __( 'Sorry, you cannot activate without <a href="%1$s">Genesis %2$s</a> or greater', 'apl' ), 'http://www.studiopress.com/support/showthread.php?t=19576', esc_attr( $latest ) ) ) );
	}

}

define( 'GENESIS_TABS_DIR', plugin_dir_path( __FILE__ ) );
define( 'GENESIS_TABS_URL', plugins_url( '', __FILE__ ) );

require_once GENESIS_TABS_DIR . '/includes/class-genesis-tabs.php';
require_once GENESIS_TABS_DIR . '/includes/class-genesis-tabs-widget.php';

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @since 0.9.4
 */
function genesis_tabs() {

	static $object;

	if ( null === $object ) {
		$object = new Genesis_Tabs();
	}

	return $object;

}

/**
 * Initialize the object on `after_setup_theme`.
 */
add_action( 'after_setup_theme', array( Genesis_Tabs(), 'init' ) );
