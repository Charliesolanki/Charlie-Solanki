<?php
/**
 * Plugin Name: Woocommerce product api
 * Plugin URI: https://www.manektech.com/
 * Description: Please use {site_url}/wp-json/woocommerce-product-api/v1/products/{page_number} for the check products. 
 * Version: 0.17.0
 * Requires at least: 4.7
 * Requires PHP: 5.5.9
 * Author: Manektech
 * Author URI: https://www.manektech.com/
 * License: GPL-2.0-only
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: my_app
 * Domain Path: /languages
 *
 * YOU SHOULD NORMALLY NOT NEED TO ADD ANYTHING HERE - any custom functionality unrelated
 * to bootstrapping the theme should go into a service provider or a separate helper file
 * (refer to the directory structure in README.md).
 *
 * @package MyApp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Make sure we can load a compatible version of WP Emerge.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'version.php';

$name = trim( get_file_data( __FILE__, [ 'Plugin Name' ] )[0] );
$load = my_app_should_load_wpemerge( $name, '0.17.0', '2.0.0' );

if ( ! $load ) {
	// An incompatible WP Emerge version is already loaded - stop further execution.
	// my_app_should_load_wpemerge() will automatically add an admin notice.
	return;
}

define( 'MY_APP_PLUGIN_FILE', __FILE__ );

define( 'CONSUMER_KEY', 'ck_a2bc55a8f39548ef61d9f2dd9cb51b2a0ef8f3eb' );
define( 'CONSUMER_SECRET', 'cs_20db47ddaf8ed0f9482e867a9643827da6717323' );

define( 'PER_PAGE', 5 );
define( 'ORDERBY', 'price' );
define( 'ORDER', 'asc' );
define( 'SHOWFIELDS', 'id,name,description,price,type,images,permalink' );

	


// Load composer dependencies.
$autoload = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if ( file_exists( $autoload ) ) {
	require_once $autoload;
}

my_app_declare_loaded_wpemerge( $name, 'theme', __FILE__ );

// Load helpers.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'MyApp.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'helpers.php';

// Bootstrap plugin after all dependencies and helpers are loaded.
\MyApp::make()->bootstrap( require __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config.php' );

// Register hooks.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'hooks.php';



function Run_product_api () {
	return new All_action();
}
$GLOBALS['wp_api'] = Run_product_api();
