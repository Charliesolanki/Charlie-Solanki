## Installation

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.

## Usage

1. This plugin is used to get the products from Third Party Website and display the JSON using Direct URL mention un below Description.
2. Other Feature developed under this plugin is that we have craeted a Front-end page to display the products from the third party websites.

## Description

This Plugin is developed by Manektech to create custom route for fetching the products from third party Website.
1. In order to get the JSON Format of the products you need to access below URL:
{site_url}/wp-json/woocommerce-product-api/v1/products/
2. Above URL will fetch first page from the product list and if you wish to access other page as well then you can add an extra paramter in above URL which is mention Below.
{site_url}/wp-json/woocommerce-product-api/v1/products/{page_number}
3. Once Plugin is activated then it will add a new page named as "External Products" and a shortcode will get included in that page to get the data from json and show in that page.
