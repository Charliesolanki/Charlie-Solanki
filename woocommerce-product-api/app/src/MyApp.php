<?php

use WPEmerge\Application\ApplicationTrait;

/**
 * @mixin \WPEmergeAppCore\Application\ApplicationMixin
 */
class MyApp {
	use ApplicationTrait;
	private $page_title = "external-product-listing";

	public function __construct() {

		add_filter('template_include', array($this,'page_tmp'));
		
		 function page_tmp ($page_template) {

			echo $page_template = dirname(__FILE__) . '\..\..\views\page-external-product-listing.php';


			if (is_page('external-product-listing')) {
			if (is_page($this->page_title)) {

			}
			return $page_template;
		} 

		add_action('init', array($this, 'create_external_product_page'));
	}




	function create_external_product_page() {

		$check_page_exist = get_page_by_title($this->page_title, 'OBJECT', 'page');

		// Check if the page already exists
		if (empty($check_page_exist)) {
			$page_id = wp_insert_post(
				array(
					'comment_status' => 'close',
					'ping_status'    => 'close',
					'post_author'    => 1,
					'post_title'     => ucwords($this->page_title),
					'post_name'      => strtolower(str_replace(' ', '-', trim($this->page_title))),
					'post_status'    => 'publish',
					'post_content'   => 'This page will display external products',
					'post_type'      => 'page',

				)
			);
		}
	}
}}