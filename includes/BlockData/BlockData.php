<?php
namespace BlockAPI\BlockData;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * BlockData Class.
 *
 * This class provides functionality for something in your BlockAPI plugin.
 * @since BlockAPI 1.0.0
 */
class BlockData {

    // Cache key for storing API data
	public const CACHE_KEY = 'block_api_data';
	public const CACHE_CLEAR_KEY = 'block_api_clear_cache';
	public const CACHE_CLEAR_TIME = HOUR_IN_SECONDS;

    // Custom hook for fetching and storing API data
    public const CUSTOM_FETCH_HOOK = 'block_api_custom_fetch';


    // Flag to check if fetch_and_store_api_data has been called
    private  $fetch_data_called = false;

    /**
     * Initialize the class
     *
     * @since BlockAPI 1.0.0
     * @access public
     */
    public function __construct() {

		// Register the custom REST API endpoint for storing data
		add_action('rest_api_init', array($this, 'register_custom_api_endpoint'));

        // Fetch API data and store it using the custom REST API endpoint
        add_action('init', array($this, 'init_handler'), 999);

    }


    /**
     * Handler for init action
     */
    public function init_handler() {
        // Check if fetch_and_store_api_data has been called
        if (get_option(self::CACHE_KEY) !== true && !$this->fetch_data_called) {
            // Trigger the data fetch
            $this->fetch_and_store_api_data();
            $this->fetch_data_called = true;
            
        }
    }
    
    /**
     * Fetch API data from the specified URL and store it using a custom REST API endpoint.
     */
    public function fetch_and_store_api_data() {

        // Check if API data is in the cache
        $cached_data = get_transient(self::CACHE_KEY);

        // Check if Get stored data from the options table.
        $stored_data = get_option(self::CACHE_KEY, false);

        if ($cached_data !== false &&  $stored_data !== false) {
			// API data is already cached, no need to fetch again
            return;
        }

        // If not in cache, fetch data from the API
        $api_url = 'https://miusage.com/v1/challenge/1/';
        $response = wp_remote_get($api_url);

        if (!is_wp_error($response)) {

            $body = wp_remote_retrieve_body($response);
            $api_data = json_decode($body, true);

            // Cache the API data for one hour
            set_transient(self::CACHE_KEY, $api_data, self::CACHE_CLEAR_TIME);

            // Store the API data using the custom REST API endpoint
            $this->store_api_data_using_rest_api($api_data);
        }
    }

    /**
     * Store API data using a custom REST API endpoint.
     *
     * @param array $api_data API data to be stored.
     */
    private function store_api_data_using_rest_api($api_data) {

        // Prepare the request arguments
        $request_args = array(
            'method'    => 'POST',
            'headers'   => array(
                'Content-Type' => 'application/json',
                'X-WP-Nonce'    => wp_create_nonce('wp_rest'), 
            ),
            'body'      => json_encode(array('api_data' => $api_data)),
        );

        // Make the request to the custom REST API endpoint
        $store_data_url = rest_url('block-api/v1/store-data/');
      	 wp_remote_request($store_data_url, $request_args);

    }

    /**
     * Register a custom REST API endpoint for data storage.
     */
    public function register_custom_api_endpoint() {
        register_rest_route('block-api/v1', '/store-data/', array(
            'methods' => 'POST',
            'callback' => array($this, 'store_data_callback'),
        ));
    }

    /**
     * Callback function for the custom REST API endpoint to store data.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function store_data_callback($request) {
        // Validate nonce for security (ensure you enqueue the nonce in your script)
        $nonce = $request->get_header('X-WP-Nonce');

        if (!wp_verify_nonce($nonce, 'wp_rest')) {
            return new \WP_REST_Response(array('error' => 'Invalid nonce.'), 403);
        }

        // Get data from the request
        $data = $request->get_params();

        // Check if 'api_data' key exists in the request
        if (isset($data['api_data'])) {
            // Update the options table with the fetched data
            update_option(self::CACHE_KEY, $data['api_data']);

            return array('status' => 'success', 'data' => $data['api_data']);
            
        } else {
            // Return an error response if 'api_data' key is not present
            return new \WP_REST_Response(array('error' => 'Invalid data format.'), 400);
        }
    }


    /**
     * Get stored data from the options table.
     *
     * @return mixed Stored data or false if not found.
     */
    public function get_stored_data() {
        return get_option(self::CACHE_KEY, false);
    }
}
