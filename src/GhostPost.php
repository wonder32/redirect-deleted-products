<?php


namespace RedirectDeletedProducts;


class GhostPost
{

    private $filter;

    public function __construct()
    {
        $this->filter = new Filter();

        $this->filter->add_action('delete_post', $this, 'saveGhost', '20');

        $this->filter->run();
    }

    public function saveGhost($id)
    {
        if (get_post_type($id) === 'product') {
            $url = str_replace('__trashed', '', get_the_permalink($id));
            $url = str_replace(get_site_url(), '', $url);

            $product = wc_get_product($id);
            $terms = $product->get_category_ids();

            $category_urls = array();
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    $category_urls[] = str_replace(get_site_url(), '', get_term_link($term->term_id, 'product_cat'));
                }
            }

            $info = array(
                'url' => $url,
                'category' => implode('@', $category_urls),
                'shop' => str_replace(get_site_url(), '', get_permalink(wc_get_page_id('shop')))
            );

            $redirectFile = fopen(wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt', "a+");
            fwrite($redirectFile, implode('|', $info) . "\n");
            fclose($redirectFile);
        }
    }

}