<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://purvik.me
 * @since             1.0.0
 * @package           Woo_Product_Disable
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Product disable
 * Plugin URI:        http://purvik.me/plugins/woocommerce-cproduct-disable
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Purvik
 * Author URI:        http://purvik.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-product-disable
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-product-disable-activator.php
 */
function activate_woo_product_disable() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-product-disable-activator.php';
	Woo_Product_Disable_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-product-disable-deactivator.php
 */
function deactivate_woo_product_disable() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-product-disable-deactivator.php';
	Woo_Product_Disable_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_product_disable' );
register_deactivation_hook( __FILE__, 'deactivate_woo_product_disable' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-product-disable.php';
require plugin_dir_path( __FILE__ ) . 'includes/global-function.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_product_disable() {

	$plugin = new Woo_Product_Disable();
	$plugin->run();

}
run_woo_product_disable();
