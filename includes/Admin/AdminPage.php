<?php
namespace BlockAPI\Admin;
use BlockAPI\BlockData\APIEndpoint;
use BlockAPI\BlockData\BlockData;
/**
 * AdminPage Class.
 *
 * This class manages the display of the admin page.
 * @since BlockAPI 1.0.0
 */
class AdminPage extends BlockData {

    /**
     * Initialize the class
     *
     * @since BlockAPI 1.0.0
     * @access public
     */
    public function __construct() {
        // Hook into admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    /**
     * Add the admin menu page.
     */
    public function add_admin_menu() {
        add_menu_page(
            'BlockAPI Settings',
            'BlockAPI',
            'manage_options',
            'blockapi-settings',
            array($this, 'display_admin_page'),
            'dashicons-admin-generic',
            20
        );
    }

    /**
     * Display the admin page.
     */
    public function display_admin_page() {
    
        // Handle the reset button click
       $this->handle_reset_button();

        // Display the admin table with reset button
        $this->display_admin_table_with_reset_button();
    }

/**
     * Display the stored data in a WordPress-style table along with a reset button.
     */
    public function display_admin_table_with_reset_button() {
        $stored_data = APIEndpoint::get_stored_data(); ?>

        <div class="wrap">
            <h1>API Data Table</h1>
            <?php if ($stored_data) {
                // Create an instance of the custom list table
                $apiListTable = new APIListTable();
                $apiListTable->set_api_data($stored_data);
                $apiListTable->prepare_items();
                $apiListTable->display();
            } else {
                echo '<p>No data available.</p>';
            }?>

        </div> <?php
    }

    /**
     * Handle the reset button click.
     */
    public function handle_reset_button() {
        error_log(print_r(isset($_POST['reset_api_data']) && $_POST['reset_api_data'] == 1));
        if (isset($_POST['reset_api_data']) && $_POST['reset_api_data'] == 1) {
            // Delete the transient data
            delete_transient(BlockData::CACHE_KEY);
            // Reset button clicked, refetch API data
            $this->fetch_and_store_api_data();
        }
    }
}

?>