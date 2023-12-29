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
    public const CACHE_CLEAR_TIME = HOUR_IN_SECONDS;

    /**
     * Initialize the class
     *
     * @since BlockAPI 1.0.0
     * @access public
     */
    public function __construct() {
        // Fetch API data and store it using the custom REST API endpoint
        add_action('init', array($this, 'fetch_and_store_api_data'), 10);

    }

    /**
     * Fetch API data from the specified URL and store it using a custom REST API endpoint.
     */
    public function fetch_and_store_api_data() {
        $cached_data = get_transient(self::CACHE_KEY);
        if ($cached_data !== false)  return;

        $api_url = 'https://miusage.com/v1/challenge/1/';
        $response = wp_remote_get($api_url);

        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $api_data = json_decode($body, true);
            set_transient(self::CACHE_KEY, $api_data, self::CACHE_CLEAR_TIME);
        } else {
            error_log(print_r($response->get_error_message(), true));
        }

    }
}
