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
            echo '<tr><td colspan="3">';
            echo __("Sorry, now information found", "redirect-deleted-products");
            echo '</td></tr>';
        }
    }

    public function returnRow($line)
    {
        $elements = unserialize($line);

        $out = '<tr id="row-' . $elements['id'] . '">';

        foreach ($elements as $element => $value) {
            switch ($element) {
                case 'categories':
                    $out .= '<td><select id="select-' . $elements['id'] . '" class="predefined">';
                    $out .= '<option value = "select">' . __('Select a existing redirect url', 'redirect-deleted-products') . '</option>';
                    foreach ($value as $link) {
                        $category = str_replace(get_site_url(), '', get_term_link($link, 'product_cat'));
                        $out .= '<option value = "' . $category . '">Category: ' . $category . '</option>';
                    }
                    break;
                case 'shop':
                    $out .= '<option value = "' . $value . '">Shop: ' . $value . '</option>';
                    $out .= '</select></td>';
                    break;
                case 'redirect':
                    $out .= '<td><input id="redirect-' . $elements['id'] . '" class="input-redirect" value="' . $elements['redirect'] . '"/></td>';
                    break;
                case 'status':
                    $status = $elements['status'];
                    $options = ['none', '301', '302'];
                    $out .= '<td><select class="redirect" id="redirect-status-' . $elements['id'] . '">';

                    foreach ($options as $option) {
                        $default = $status === $option ? 'selected="selected"' : '';
                        $out .= '<option value="' . $option . '" ' . $default . '>' . $option . '</option>';
                    }
                    $out .= '</select></td>';
                    break;
                default:
                    $out .= "<td>{$value}</td>";
            }
        }

        $out .= '<td>';
        $out .= '<div class="status" id="status-' . $elements['id'] . '">status</div>';
        $out .= '<div class="action" id="action-' . $elements['id'] . '"></div>';
        $out .= '</td>';

        $out .= '</tr>';

        return $out;
    }
}
