<?php
/**
 * Plugin Name:       Data-table
 * Description:       The &quot;Data for API&quot; concept encapsulates the structured information exchanged between systems through Application Programming Interfaces (APIs). It serves as the lifeblood of seamless communication between software components, enabling the transfer of data in a standardized and efficient manne
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Aminul Islam
 * Text Domain:       block-api
 *
 * @package           block-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function block_api_block_api_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'block_api_block_api_block_init' );
