<?php


namespace RedirectDeletedProducts\Helpers;

class UpdateInformation
{

    private $information;

    public function __construct()
    {
        check_ajax_referer('ajax_nonce', 'nonce');
        $this->information = filter_input_array(INPUT_POST, 'var', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY);
    }

    public function update()
    {
        wp_send_json($this->information);
    }
}