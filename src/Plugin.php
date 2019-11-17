<?php

namespace RedirectDeletedProducts;

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

    public function loadTextDomain()
    {
        load_plugin_textdomain(
            'redirect-deleted-products',
            false,
            dirname(
                plugin_basename(
                    REDIRECT_DELETED_PRODUCTS
                )
            ) . '/languages'
        );
    }

    public function checkForUpdates()
    {
        // only load file if it has not been loaded
        if (is_admin()) {
            $map_geo_update_checker = \Puc_v4_Factory::buildUpdateChecker(
                'https://plugins.puddinq.com/updates/?action=get_metadata&slug=simple-301-redirects-bulk-check',
                REDIRECT_DELETED_PRODUCTS
            );
        }
    }
}