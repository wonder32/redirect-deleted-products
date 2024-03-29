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
        $this->getDefaultRedirect();
        $this->information['status'] = '302';
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

        $category_ids = [];
        if (!empty($terms)) {
            foreach ($terms as $term) {
                $category_ids[] = $term;
            }
        }
        $this->information['categories'] = $category_ids;
    }

    public function getShop()
    {
        $this->information['shop'] = str_replace(get_site_url(), '', get_permalink(wc_get_page_id('shop')));
    }

    public function getInformation()
    {
        return $this->information;
    }

    public function getDefaultRedirect()
    {
        $term_ids = $this->information['categories'];
        if (empty($term_ids) === false) {
            $this->information['redirect'] = str_replace(
                get_site_url(),
                '',
                get_term_link($term_ids[0], 'product_cat')
            );
        } else {
            $this->information['redirect'] = $this->information['shop'];
        }
    }
}