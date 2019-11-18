<?php
/*
Plugin Name: Redirect deleted products
Plugin URI:  https://www.puddinq.com/plugins/redirect-deleted-products/
Description: Blank plugin to create different sorts of new ones
Version:     0.5
Author:      Stefan Schotvanger
Author URI:  http://www.puddinq.nl/wip/stefan-schotvanger/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: redirect-deleted-products
Domain path: /languages/
*/

namespace RedirectDeletedProducts;

define('REDIRECT_DELETED_PRODUCTS', __DIR__);
define('REDIRECT_DELETED_PRODUCTS_FILE', __FILE__);

/**
 * autoloader
 */

require_once __DIR__ . '/vendor/autoload.php';



$plugin = new Plugin();

if (is_admin()) {
    $admin_page = new AdminPage();
}
