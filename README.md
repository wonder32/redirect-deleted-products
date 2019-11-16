# [puddinqs](http://www.puddinq.com)

WordPress - WooCommerce - create redirect if product is deleted 


|      |  | |
| :---      | :--- | :--- |
| ![puddinq](https://www.puddinq.com/wp-content/uploads/2016/10/logo.png) | * Project: [https://github.com/wonder32/redirect-deleted-products](https://github.com/wonder32/redirect-deleted-products)  <br />* Website: [puddinq.com](https://www.puddinq.com/) <br/>* Twitter: [@schotvs](http://twitter.com/schotvs) <br>* Author : [Stefan Schotvanger](https://www.puddinq.mobi/wip/stefan-schotvanger/) // [@schotvs](http://www.puddinq.mobi/wip/profiel/) | ![WooCommerce](https://www.puddinq.com/wp-content/uploads/2019/11/woocommerce-150x150.png) |

## Install
```git
$ git clone git@github.com:wonder32/redirect-deleted-products.git

```

## Features

1. The url for a deleted product is saved automatically
2. In the admin view you can choose:
    * Do nothing
    * Redirect to category ( 301 or 302 )
    * Redirect to other product ( 301 or 302 )
    * Redirect to main shop page ( 301 or 302 )
3. When the url is called:
    * WordPress checks if the product exists (you might have recreated it)
    * If not, WordPress will try the 404, but before it serves it, it will check the list
    * Your deleted product will be served search engine friendly 
 
## changelog
* 0.2 16-11-2019 composer package
* 0.1 15-11-2019 init
