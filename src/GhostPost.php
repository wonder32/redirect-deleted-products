<?php


namespace RedirectDeletedProducts;


class GhostPost
{

    public function __construct()
    {
        $this->filter = new Filter();

        $this->filter->add_action('delete_post', $this, 'saveGhost', '20');

        $this->filter->run();
    }

    public function saveGhost($id)
    {
        if (get_post_type($id) === 'product') {

        }
    }

}