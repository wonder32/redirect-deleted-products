<?php


namespace RedirectDeletedProducts\Helpers;


class TableInformation
{

    private $lines;

    public function __construct()
    {
        $this->lines = file(wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt', FILE_SKIP_EMPTY_LINES);
    }

    public function printRows()
    {
        $lines = false;
        foreach ($this->lines as $line) {
            if (trim($line) != '') {
                echo $this->returnRow($line);
                $lines = true;
            }
        }
        if (!$lines) {
            echo '<tr><td colspan="3">' . __("Sorry, now information found",
                    "redirect-deleted-products") . '</td></tr>';
        }
    }

    public function returnRow($line) {

    }

}