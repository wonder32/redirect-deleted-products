<?php


namespace RedirectDeletedProducts;


class PossibleRedirect
{
    private $filter;

    private $lines;

    public function __construct()
    {
        $this->filter = new Filter();

        $this->filter->add_action('template_redirect', $this, 'maybeRedirect', '20');

        $this->filter->run();
    }

    public function maybeRedirect()
    {
        if( is_404() ){

            global $wp;

            $this->lines = file(wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt', FILE_SKIP_EMPTY_LINES);

            $current_slug = '/' . add_query_arg(array(), $wp->request) . '/';

            $exists = false;
            foreach ($this->lines as &$line) {
                if (trim($line) != '') {
                    $line = unserialize($line);
                    if ($line['url'] === $current_slug) {
                        $exists = true;
                        $product = $line;
                        break;
                    }

                }
            }

            if ($exists) {
                wp_redirect(home_url($product['redirect']), $product['status'], 'Redirect deleted product');
            }
        }
    }
}