<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 20/04/2019
 * Time: 23:33
 */

namespace RedirectDeletedProducts;

use RedirectDeletedProducts\Helpers\TableInformation;
use RedirectDeletedProducts\Helpers\UpdateInformation;

class AdminPage
{

    private $filter;

    public function __construct()
    {
        $this->filter = new Filter();

        $this->filter->add_action('admin_menu', $this, 'createAdminPage', '20');
        $this->filter->add_action('admin_enqueue_scripts', $this, 'enqueueStyleScript', '20');
        $this->filter->add_action('wp_ajax_remember_setting', $this, 'updateInformation', '20');
        $this->filter->add_action('wp_ajax_nopriv_remember_setting', $this, 'updateInformation', '20');
        $this->filter->run();
    }

    // register menu
    public function createAdminPage()
    {
        add_management_page(
            __('Redirect deleted products - WooCommerce.', 'redirect-deleted-products'),
            __('Redirect deleted products', 'redirect-deleted-products'),
            'manage_options',
            'redirect-deleted-products',
            array($this, 'pageOutput') //function
        );
    }

    // enqueue style and scripts
    public function enqueueStyleScript()
    {
        $screen = get_current_screen();
        if ($screen->id === 'tools_page_redirect-deleted-products') {
            $value = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax_nonce')
            );
            $root = plugin_dir_url(REDIRECT_DELETED_PRODUCTS_FILE) . 'assets/';
            wp_enqueue_script(
                'redirect-deleted-products-script',
                $root . 'script.js',
                array('jquery'),
                '1.0'
            );
            wp_enqueue_style(
                'redirect-deleted-products-style',
                $root . 'style.css',
                '',
                '1.0'
            );
            wp_localize_script('redirect-deleted-products-script', 'redirect', $value);
        }
    }


    // page output
    public function pageOutput()
    {
        $rows = new TableInformation();

        echo '<div class="wrap redirect-deleted-products">';
        echo '<h2>' . __('Redirect deleted products', 'redirect-deleted-products') . '</h2>';


        $tableHead = <<<TABLEHEAD
        <table class="widefat" id="redirect-deleted-products-table">
        <thead>
        <tr>
        <th>%s</th>
        <th>%s</th>
        <th>%s</th>
        <th>%s</th>
        <th>%s</th>
        <th>%s</th>
        </tr>
        </thead>
        <tbody>
TABLEHEAD;

        printf(
            $tableHead,
            __('ID', 'redirect-deleted-products'),
            __('Old url', 'redirect-deleted-products'),
            __('Optional redirects', 'redirect-deleted-products'),
            __('Redirect to', 'redirect-deleted-products'),
            __('301 / 302 / no redirect', 'redirect-deleted-products'),
            __('Action', 'redirect-deleted-products')
        );

        $rows->printRows();

        $tableFooter = <<<TABLEFOOT

        </thody>
        </table>

TABLEFOOT;


        echo $tableFooter;


        echo '</div>';
    }

    // handle update
    public function updateInformation()
    {
        $update = new UpdateInformation();
        $update->update();
    }
}
