<?php
namespace BlockAPI\BlockList;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * ListOfBlocks Class.
 *
 * This class provides functionality for something in your BlockAPI plugin.
 * @since BlockAPI 1.0.0
 */
class ListOfBlocks {

    /**
     * Initialize the class
     *
     * @since BlockAPI 1.0.0
     * @access public
     */
    public function __construct() {
        add_action( 'init', [$this, 'block_api_block_api_block_init']);

    }

    /**
     * Registers the block using the metadata loaded from the `block.json` file.
     * Behind the scenes, it registers also all assets so they can be enqueued
     * through the block editor in the corresponding context.
     * @since BlockAPI 1.0.0
     * @access public
     * @see https://developer.wordpress.org/reference/functions/register_block_type/
     */
    public function block_api_block_api_block_init() {
        // register_block_type( __DIR__ . '/build' );


            $directory = __DIR__ . '/build/blocks/'; 
            $files = glob($directory . '*');

            error_log(print_r($files, true));

            foreach ($files as $file) {
               error_log(print_r($file, true));
            }


    }
    

}
?>