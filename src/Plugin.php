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
        $this->verifyRedirectFile();
    }

    /**
     * Check for updates
     */

    public function checkForUpdates()
    {
        // only load file if it has not been loaded
        Puc_v4_Factory::buildUpdateChecker(
            'https://plugins.puddinq.com/updates/?action=get_metadata&slug=redirect-deleted-products',
            REDIRECT_DELETED_PRODUCTS_FILE
        );
    }

    /**
     * Load text domain
     */

    public function loadTextDomain()
    {
        load_plugin_textdomain(
            'redirect-deleted-products',
            false,
            dirname(
                plugin_basename(
                    REDIRECT_DELETED_PRODUCTS_FILE
                )
            ) . '/languages'
        );
    }

    public function verifyRedirectFile()
    {
        if (!file_exists(wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt')) {
            $redirectFile = fopen(wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt', "w");
            fclose($redirectFile);
        }
    }
}
