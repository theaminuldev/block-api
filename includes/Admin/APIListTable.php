<?php
namespace BlockAPI\Admin;

/**
 * APIListTable Class.
 * 
 * This class provides functionality for something in your BlockAPI plugin.
 * @since BlockAPI 1.0.0
 */

class APIListTable extends \WP_List_Table {

    private $api_data = array();

    /**
     * Sets the API data.
     *
     * @param datatype $api_data The API data to be set.
     */
    public function set_api_data($api_data) {
        $this->api_data = $api_data;
    }

    /**
     * Prepares the items for display.
     *
     * This function retrieves the columns, hidden columns, and sortable columns,
     * and sets them as the column headers. It also sets the pagination arguments
     * based on the total number of items and the number of items per page. Finally,
     * it slices the array of items based on the current page and the number of items
     * per page.
     *
     * @return void
     */
    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count($this->api_data['data']['rows']);

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ));

        $this->items = array_slice($this->api_data['data']['rows'], (($current_page - 1) * $per_page), $per_page);
    }

    /**
     * Retrieves the columns for the table.
     *
     * @return array The table columns.
     */
    public function get_columns() {
        $columns = array(
            'cb'     => '<input type="checkbox" />',
            'id'     => 'ID',
            'fname'  => 'First Name',
            'lname'  => 'Last Name',
            'email'  => 'Email',
            'date'   => 'Date',
        );

        return $columns;
    }

    /**
     * Retrieves the sortable columns for the current object.
     *
     * @return array An associative array of sortable columns and their sorting options.
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'id'    => array('id', false),
            'fname' => array('fname', false),
            'lname' => array('lname', false),
            'email' => array('email', false),
            'date'  => array('date', false),
        );

        return $sortable_columns;
    }

    /**
     * Retrieves the value of a specific column in the dataset.
     *
     * @param mixed[] $item The dataset containing the item.
     * @param string $column_name The name of the column to retrieve the value from.
     * @return mixed The value of the specified column, or an empty string if the column does not exist.
     */
    public function column_default($item, $column_name) {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }

    /**
     * A description of the column_cb function.
     *
     * @param mixed $item The item to generate the column checkbox for.
     * @return string The generated HTML for the column checkbox.
     */
    public function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />',
            $item['id']
        );
    }

	/**
	 * Generates the function comment for the given function.
	 *
	 * @param string $which The type of extra table navigation (top or bottom).
	 * @throws Exception If the value of $which is not 'top' or 'bottom'.
	 * @return void
	 */
    public function extra_tablenav($which) {
        if ($which == 'top') { ?>
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
					<select name="action" id="bulk-action-selector-top">
						<option value="-1">Bulk actions</option>
						<option value="bulk-delete">Delete</option>
					</select>
				<input type="submit" id="doaction" class="button action" value="Apply">
			</div>

			<div class="alignleft actions">
            	<span> Search:</span> <input type="text" name="s" />
            		<?php submit_button( 'Search', 'button', false, false, array( 'id' => 'search-submit' ) ); ?>
           </div> <?php
        }
		if ($which == 'bottom') { ?>
			<div class="alignleft actions bulkactions">
				<form action="<?php echo admin_url( "admin.php?page=blockapi-settings")?>" method="post">
					<input type="hidden" name="reset_api_data" value="1" />
					<?php submit_button('Reset API Data', 'primary', 'reset_api_data', false) ?>
				</form>
			</div>
			<?php
		}
    }

    /**
     * Generates the function comment for the column_id function.
     *
     * @param mixed $item the item to be processed
     * @throws None
     * @return string the generated column id
     */
    public function column_id($item) {
        $actions = array(
            'edit'   => sprintf('<a href="?page=%s&action=%s&api_id=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&api_id=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
        );

        return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions));
    }

    /**
     * Generates a formatted date string from the 'date' field of an array.
     *
     * @param array $item The array containing the 'date' field.
     * @return string The formatted date string in 'Y-m-d H:i:s' format.
     */
    public function column_date($item) {
        return date('Y-m-d H:i:s', strtotime($item['date']));
    }
}
?>
