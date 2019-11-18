<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 20/04/2019
 * Time: 23:33
 */

namespace RedirectDeletedProducts;

class AdminPage
{

    private $filter;

    public function __construct()
    {
        $this->filter = new Filter();

        $this->filter->add_action('admin_menu', $this, 'createAdminPage', '20');

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


    // page output
    public function pageOutput()
    {
        echo '<div class="wrap redirect-deleted-products">';
        echo '<h2>' . __('Redirect deleted products', 'redirect-deleted-products') . '</h2>';


        $tableHead = <<<TABLEHEAD
        <table class="widefat" id="redirect-deleted-products-table">
        <thead>
        <tr>
        <th>%s</th>
        <th>%s</th>
        <th>%s</th>
        </tr>
        </thead>
        <tbody>
TABLEHEAD;

        printf(
            $tableHead,
            __('Old url', 'redirect-deleted-products'),
            __('Redirect to', 'redirect-deleted-products'),
            __('301 / 302 / non', 'redirect-deleted-products')
        );

        $tableFooter = <<<TABLEFOOT

        </thody>
        </table>

TABLEFOOT;


        echo $tableFooter;


        echo '</div>';

    }
}

