<?php
/**
 * Plugin Name: BlockAPI
 * Plugin URI: https://theaminul.com/blockapi/
 * Author: theaminul
 * Author URI: theaminul.com
 * Version: 1.0.0
 * Stable tag: 1.0.0
 * Requires at least: 5.9
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * License: GNU General Public License v3 or later.
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: blockapi
 * Description: BlockAPI - A WordPress plugin using block API and namespace for enhanced block functionality.
 * Tags: block-api, namespace, block, Gutenberg, WordPress
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('BLOCKAPI_VERSION', '1.0.0');
define('BLOCKAPI__FILE__', __FILE__);
define('BLOCKAPI_PLUGIN_BASE', plugin_basename(BLOCKAPI__FILE__));
define('BLOCKAPI_PATH', plugin_dir_path(BLOCKAPI__FILE__));
define('BLOCKAPI_URL', plugins_url('/', BLOCKAPI__FILE__));
define('BLOCKAPI_ASSETS_PATH', BLOCKAPI_PATH . 'assets/');
define('BLOCKAPI_ASSETS_URL', BLOCKAPI_URL . 'assets/');
define('BLOCKAPI_SRC_PATH', BLOCKAPI_PATH . 'src/');
define('BLOCKAPI_BUILD_PATH', BLOCKAPI_PATH  . 'build/');

add_action('plugins_loaded', 'blockapi_load_plugin_textdomain');

if (!version_compare(PHP_VERSION, '7.0', '>=')) {
    add_action('admin_notices', 'blockapi_fail_php_version');
} elseif (!version_compare(get_bloginfo('version'), '5.9', '>=')) {
    add_action('admin_notices', 'blockapi_fail_wp_version');
} else {
    require BLOCKAPI_PATH . 'includes/Plugin.php';
}

/**
 * Load BlockAPI textdomain.
 *
 * Load gettext translate for BlockAPI text domain.
 *
 * @since BlockAPI 1.0.0
 *
 * @return void
 */
function blockapi_load_plugin_textdomain(){
    load_plugin_textdomain('blockapi');
}

/**
 * BlockAPI admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since BlockAPI 1.0.0
 *
 * @return void
 */
function blockapi_fail_php_version(){
    $message = sprintf(
        /* translators: 1: `<h3>` opening tag, 2: `</h3>` closing tag, 3: PHP version. 4: Link opening tag, 5: Link closing tag. */
        esc_html__('BlockAPI isn’t running because PHP is outdated.%2$s Update to PHP version %3$s and get back to using BlockAPI! %4$sShow me how%5$s', 'blockapi'),
        '<h3>',
        '</h3>',
        '7.0',
        '<a href="#" target="_blank">',
        '</a>'
    );
    $html_message = sprintf('<div class="error">%s</div>', wpautop($message));
    echo wp_kses_post($html_message);
}

/**
 * BlockAPI admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @since BlockAPI 1.0.0
 *
 * @return void
 */
function blockapi_fail_wp_version(){
    $message = sprintf(
        /* translators: 1: `<h3>` opening tag, 2: `</h3>` closing tag, 3: WP version. 4: Link opening tag, 5: Link closing tag. */
        esc_html__('BlockAPI isn’t running because WordPress is outdated.%2$s Update to version %3$s and get back to using BlockAPI! %4$sShow me how%5$s', 'blockapi'),
        '<h3>',
        '</h3>',
        '5.9',
        '<a href="#" target="_blank">', 
        '</a>'
    );
    $html_message = sprintf('<div class="error">%s</div>', wpautop($message));
    echo wp_kses_post($html_message);
}



// Add this code in your theme's functions.php file or a custom plugin

// function register_custom_api_endpoint() {
//     register_rest_route('block-api/v1', '/store-data/', array(
//         'methods' => 'GET',
//         'callback' => 'store_data_callback',
//     ));
// }

// function store_data_callback($data) {
//     // You can implement your logic here to fetch and store data
//     $api_url = 'https://miusage.com/v1/challenge/1/';
//     $response = wp_remote_get($api_url);

//     if (!is_wp_error($response)) {
//         $body = wp_remote_retrieve_body($response);
//         $api_data = json_decode($body, true);

//         // Store the API data in the WordPress options table
//         update_option('block_api_data', $api_data);

//         // Optionally, you can return a response or do other processing
//         // return array('status' => 'success', 'data' => $api_data);
//     } else {
//         return array('status' => 'error', 'message' => 'Failed to fetch data from the API');
//     }
// }

// // Hook the registration function to the 'rest_api_init' action
// add_action('rest_api_init', 'register_custom_api_endpoint');
