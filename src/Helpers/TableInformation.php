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

        $elements = explode('|', $line);

        $out = '<tr>';

        $out .= "<td>{$elements[0]}</td>";
        $out .= "<td>{$elements[1]}</td>";

        $links = explode('@', $elements[2]);

//        str_replace(get_site_url(), '', get_term_link($term, 'product_cat'));
        $out .= '<select id = "myList">';

        foreach ($links as $link) {
            $category = str_replace(get_site_url(), '', get_term_link($link, 'product_cat'));
            echo '<option value = "' . $category . '">Category: ' . $category . '</option>';
        }

        $out .= '<option value = "4">Shop - ' . $elements[3] . '</option>';
        $out .= '</select>';

        $out .= "<td>{$elements[4]}</td>";
        $out .= "<td>{$elements[5]}</td>";

        $out .= '</tr>';

        return $out;

    }

}