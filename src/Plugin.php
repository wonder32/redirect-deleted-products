<?php

namespace RedirectDeletedProducts;

use Puc_v4_Factory;

class Plugin
{
    private $filter;

    public function __construct()
    {
        $this->checkForUpdates();
        $this->filter = new Filter();
        $this->filter->add_action('plugins_loaded', $this, 'loadTextDomain');
        $this->filter->run();
    }

    /**
     * Check for updates
     */

    public function checkForUpdates()
    {
        // only load file if it has not been loaded
        Puc_v4_Factory::buildUpdateChecker(
            'https://plugins.puddinq.com/updates/?action=get_metadata&slug=simple-301-redirects-bulk-check',
            REDIRECT_DELETED_PRODUCTS_FILE
        );
    }

    /**
     * Load text domain
     */

    public function loadTextDomain()
    {
        $result = \load_plugin_textdomain(
            'redirect-deleted-products',
            false,
            dirname(
                plugin_basename(
                    REDIRECT_DELETED_PRODUCTS_FILE
                )
            ) . '/languages'
        );
    }
}
