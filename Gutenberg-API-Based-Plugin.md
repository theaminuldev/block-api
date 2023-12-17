API Based Plugin

Overview:

- Make a simple plugin that retrieves data from a remote API endpoint, and makes that data accessible/retrievable from an API endpoint on the WordPress site your plugin is installed on.
- The data will be displayed via a custom block and on an admin WordPress page as described. A simple WP CLI command is also required.

Specifications:

- Using the GET HTTP Method accessible endpoint https://miusage.com/v1/challenge/1/ (there are no parameters to/from required), create an AJAX endpoint in WordPress that calls the above listed API endpoint to get the data return.
- Your AJAX endpoint should be usable whether the user is logged in or not (authentication of the AJAX endpoint is not required). 
- The endpoint should always return the data when called, but regardless of when/how many times your AJAX endpoint is called, it should never request the data from our miusage.com endpoint more than 1 time per hour.
- Create a custom (Gutenberg) block, that when loaded uses Javascript to contact your AJAX endpoint and display the data returned formatted into a table-like display. 
- The block should have custom controls in the block settings to toggle the visibility of the table columns.
- Create a WP CLI command that can be used to force the refresh  (override the 1 time per hour limit described above) of this data the next time the AJAX endpoint is called
- Create a WordPress admin page which displays this data add a button to refresh the data.

Notes:

- Ensure to properly escape, sanitize, and validate data in each step as appropriate using built in PHP and WordPress functions.
- Ensure all user facing strings/text is translatable.
