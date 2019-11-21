<?php


namespace RedirectDeletedProducts\Helpers;


class ProductInformation
{
    private $product;

    private $information = array();

    public function __construct($id)
    {
        $this->getProduct($id);
        $this->information['id'] = $id;
        $this->getUrl();
        $this->getTerms();
        $this->getShop();
        $this->information['redirect'] = '';
        $this->information['status'] = '';
    }

    public function getUrl()
    {
        $url = str_replace('__trashed', '', get_the_permalink($this->information['id']));
        $this->information['url'] = str_replace(get_site_url(), '', $url);
    }
    public function getProduct($id)
    {
        $product = wc_get_product($id);
        $this->product = $product;
    }

    public function getTerms()
    {
        $terms = $this->product->get_category_ids();

        $category_urls = array();
        if (!empty($terms)) {
            foreach ($terms as $term) {
                $category_urls[] = str_replace(get_site_url(), '', get_term_link($term, 'product_cat'));
            }
        }
        $this->information['categories'] = implode('@', $category_urls);
    }

    public function getShop()
    {
        $this->information['shop'] = str_replace(get_site_url(), '', get_permalink(wc_get_page_id('shop')));
    }

    public function getInformation()
    {
        return $this->information;
    }
}