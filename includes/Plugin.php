<?php
namespace BlockAPI;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * BlockAPI plugin.
 *
 * The main plugin handler class is responsible for initializing BlockAPI. The
 * class registers all the init_features required to run the plugin.
 *
 * @since BlockAPI 1.0.0
 */
class Plugin{

    /**
     * Instance
     *
     * @since BlockAPI 1.0.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since BlockAPI 1.0.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance(){
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Register autoload.
     *
     * BlockAPI autoload loads all the classes needed to run the plugin.
     *
     * @since 1.6.0
     * @access private
     */
    private function register_autoload(){
        require_once BLOCKAPI_PATH . 'vendor/autoload.php';
    }

    /**
     * Initialize the assets manager.
     *
     * This method initializes the assets manager for your BlockAPI plugin.
     *
     * @since BlockAPI 1.0.0
     * @access private
     */
    private function init_assets(){
        // new AssetsManager\AssetsManager();
    }

    /**
     * Initialize admin features.
     *
     * This method initializes the admin-related features for your BlockAPI plugin.
     *
     * @since BlockAPI 1.0.0
     * @access private
     */
    private function init_admin(){
        if (is_admin()) {
            // new Admin\Admin();
        }
    }

    /**
     * Init init_block_lists.
     *
     * Initialize BlockAPI init_block_lists. Register actions, run setting manager,
     * initialize all the init_block_lists that run BlockAPI, and if in the admin page,
     * initialize admin init_block_lists.
     *
     * @since BlockAPI 1.0.0
     * @access private
     */
    private function init_block_lists(){
        new BlockList\ListOfBlocks();
        new BlockData\BlockData();
        // $stored_data = (new \BlockAPI\BlockData\BlockData())->get_stored_data();

        // error_log(print_r($stored_data, true));

        // // Get a specific option value
        // $option_value = get_option('block_api_data');

        // // Check if the option exists before using it
        // if ($option_value !== false) {
        //     // Option exists, do something with $option_value
        //     error_log(print_r( 'Option value: ' . $option_value, true));
        // } else {
        //     // Option doesn't exist
        //    error_log(print_r( 'Option doesn\'t exist', true));
        // }

    }

    /**
     * Init.
     *
     * Initialize BlockAPI Plugin. Register BlockAPI support for all the
     * supported post types and initialize BlockAPI init.
     *
     * @since BlockAPI 1.0.0
     * @access private
     */
    private function init(){
        $this->register_autoload();
        $this->init_assets();
        $this->init_admin();
        $this->init_block_lists();
    }

    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since BlockAPI 1.0.0
     * @access public
     */
    public function __construct(){
        $this->init();

        // if (get_option('block_api_data') !== true) {
        //     // Trigger the data fetch
        //     // do_action('block_api_custom_fetch');
        //     apply_filters('block_api_custom_fetch', true);

        // }
        // apply_filters('block_api_custom_fetch', true);
        // do_action('block_api_custom_fetch');

    }
}
Plugin::instance();
