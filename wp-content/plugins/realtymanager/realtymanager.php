<?php
/**
 * Plugin Name: Realty Manager
 * Description: Manage realty items.
 * Version: 0.0.1
 * Author: Cray Flatline
 * Requires at least: 4.9
 * Tested up to: 5.4
 * Requires PHP: 7.1
 * Text Domain: rm
 * Domain Path: /languages/
 *
 * @package headhunter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants.
define( 'REALTYMANAGER_VERSION', '0.0.1' );
define( 'REALTYMANAGER_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'REALTYMANAGER_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
define( 'REALTYMANAGER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once REALTYMANAGER_PLUGIN_DIR . '/classes/realtymanager.class.php';
require_once REALTYMANAGER_PLUGIN_DIR . '/includes/template-helpers.php';

function RM() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
	return RealtyManager\RealtyManager::instance();
}

$GLOBALS['headhunter'] = RM();

// Activation - works with symlinks.
register_activation_hook( REALTYMANAGER_PLUGIN_BASENAME, array( RM(), 'pluginActivate' ) );

// Cleanup on deactivation.
register_deactivation_hook( __FILE__, array( RM(), 'pluginDeactivate' ) );
