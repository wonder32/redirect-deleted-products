<?php


namespace RedirectDeletedProducts;


use RedirectDeletedProducts\Helpers\ProductInformation;

class GhostPost
{

    private $filter;

    public function __construct()
    {
        $this->filter = new Filter();

        $this->filter->add_action('delete_post', $this, 'saveGhost', '20');
        $this->filter->add_action('wp_trash_post', $this, 'saveGhost', '20');

        $this->filter->run();
    }

    public function saveGhost($id)
    {
        if (get_post_type($id) === 'product') {

            $redirectFile = file(wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt', FILE_SKIP_EMPTY_LINES);

            $add = true;
            foreach ($redirectFile as &$line) {
                $line = explode('|', $line);
                if ($line[0] === $id) {
                    $add = false;
                    break;
                }
            }

            if ($add) {
                $productInformation = new ProductInformation($id);

                $redirectFile = fopen(wp_upload_dir()['basedir'] . '/redirect-deleted-products.txt', "a+");
                fwrite($redirectFile, implode('|', $productInformation->getinformation()) . "\n");
                fclose($redirectFile);
            }
        }
    }

}