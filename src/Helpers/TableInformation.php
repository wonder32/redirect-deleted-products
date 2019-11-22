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
            echo '<tr><td colspan="3">' . __("Sorry, now information found", "redirect-deleted-products") . '</td></tr>';
        }
    }

    public function returnRow($line) {
        $elements = unserialize($line);

        $out = '<tr>';

        foreach ($elements as $element => $value) {
            switch ($element) {
                case 'categories':
                    $out .= '<td><select>';
                    foreach ($value as $link) {
                        $category = str_replace(get_site_url(), '', get_term_link($link, 'product_cat'));
                        $out .= '<option value = "' . $category . '">Category: ' . $category . '</option>';
                    }
                    break;
                case 'shop':
                    $out .= '<option value = "4">Shop: ' . $value . '</option>';
                    $out .= '<option value = "custom">Category: ' . __('Set a custom redirect', 'redirect-deleted-products') . '</option>';
                    $out .= '</select></td>';
                    break;
                case 'redirect':
                    $out .= '<td><input id="redirect-' . $elements['id'] . '" value=""/></td>';
                    break;
                case 'status':
                    $out .= '<td><select>';
                    $out .= '<option value = "301">301</option>';
                    $out .= '<option value = "302">302</option>';
                    $out .= '<option value = "302">none</option>';
                    $out .= '</select></td>';
                    break;
                default:
                    $out .= "<td>{$value}</td>";
            }
        }

//        $out .= "<td>{$elements[0]}</td>";
//        $out .= "<td>{$elements[1]}</td>";
//
//        $links = explode('@', $elements[2]);
//
//        str_replace(get_site_url(), '', get_term_link($term, 'product_cat'));

//

//
//
//
//
//        $out .= "<td>{$elements[4]}</td>";
//        $out .= "<td>{$elements[5]}</td>";

        $out .= '</tr>';

        return $out;

    }

}