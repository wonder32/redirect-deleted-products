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
        $redirectFile = wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt';
        $redirectFileTmp = wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt.tmp';

        $replaced = false;

        $reading = fopen($redirectFile, 'r');
        $writing = fopen($redirectFileTmp, 'w');

        while (!feof($reading)) {
            $line = fgets($reading);
            $lineArray = unserialize($line);
            foreach ($this->information['update_array'] as $information) {
                if (intval($information['id']) === $lineArray['id']) {
                    $lineArray['redirect'] = $information['redirect'];
                    $lineArray['status'] = $information['status'];
                    $line = serialize($lineArray);
                    $replaced = true;
                }
            }
            fputs($writing, $line);
        }
        fclose($reading);
        fclose($writing);

        if ($replaced) {
            rename($redirectFileTmp, $redirectFile);
        } else {
            unlink($redirectFileTmp);
        }
        wp_send_json($this->information['update_array']);
    }
}