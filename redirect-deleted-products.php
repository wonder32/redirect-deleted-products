<?php
/*
Plugin Name: Redirect deleted products
Plugin URI:  https://www.puddinq.com/plugins/redirect-deleted-products/
Description: Blank plugin to create different sorts of new ones
Version:     0.5.1
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


/**
 * Base plugin
 * - check for updates
 * - load text domain
 * - create redirect file
 */
new Plugin();

if (is_admin()) {
// step 1 save information on delete
    new GhostPost();
// step 2 management page
    new AdminPage();
} else {
// step 3 redirect if needed
    new PossibleRedirect();
}
