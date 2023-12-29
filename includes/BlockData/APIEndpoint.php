<?php
namespace BlockAPI\BlockData;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * APIEndpoint Class.
 *
 * This class provides functionality for something in your BlockAPI plugin.
 * @since BlockAPI 1.0.0
 */

 class APIEndpoint {
	 // Cache key for storing API data
	 public const GET_TRANSIENT_KEY = 'block_api_data';
	 public const GET_OPTION_KEY = 'block_api_data';
	 /**
	  * Initialize the class
	  *
	  * @since BlockAPI 1.0.0
	  * @access public
	  */
	 public function __construct() {
		  // Register the custom REST API endpoint for storing data
		  add_action('rest_api_init', array($this, 'register_custom_api_endpoint'));
	 }

	 /**
     * Register a custom REST API endpoint for data storage.
     */
    public function register_custom_api_endpoint() {
        register_rest_route('block-api/v1', '/store-data/', array(
            'methods' => 'GET',
            'callback' => array($this, 'store_data_callback'),
        ));
    }


    /**
     * Callback function for the custom REST API endpoint to store data.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function store_data_callback() {
        $api_data = get_transient(self::GET_TRANSIENT_KEY);

        if (!empty($api_data)) {
            $api_data = get_transient(self::GET_TRANSIENT_KEY);

            // Optionally, you can return a response or do other processing
            return new \WP_REST_Response(array('status' => 'success', 'data' => $api_data), 200);
        } else {
            // Return an error response
            return new \WP_REST_Response(array('status' => 'error', 'message' => 'Failed to fetch data from the API'), 500);
        }
    }

    /**
     * Get stored data from the options table.
     *
     * @return mixed Stored data or false if not found.
     */
    public static function get_stored_data() {
        return get_transient(self::GET_TRANSIENT_KEY);
    }
 }