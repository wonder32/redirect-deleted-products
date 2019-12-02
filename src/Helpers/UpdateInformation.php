<?php


namespace RedirectDeletedProducts\Helpers;

class UpdateInformation
{

    private $information;

    public function __construct()
    {
        check_ajax_referer('ajax_nonce', 'nonce');
        $this->information = $this->filter($_POST);
    }

    public function filter(array &$array)
    {
        array_walk_recursive($array, function (&$value) {
            $value = filter_var(trim($value), FILTER_SANITIZE_STRING);
        });

        return $array;
    }

    public function update()
    {



        wp_send_json($this->information);
    }
}