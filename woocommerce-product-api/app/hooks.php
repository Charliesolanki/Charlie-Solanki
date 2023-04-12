<?php
/**
 * Declare any actions and filters here.
 * In most cases you should use a service provider, but in cases where you
 * just need to add an action/filter and forget about it you can add it here.
 *
 * @package MyApp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class All_action {

	public function __construct()
	{
		
		$this->load_action_hooks();
		
	}

	public function load_action_hooks(){
		$Product_list_class = new Product_list_class();
		add_action("rest_api_init",array($Product_list_class,'Register_rout'));
		add_action("wp_enqueue_scripts",array($Product_list_class,'themeslug_enqueue_script'));
		// add_filter( 'theme_page_templates',array($Product_list_class,'add_page_template') );
		// add_filter( 'template_include', array($Product_list_class,'change_page_template') );
		add_shortcode( 'my_shortcode', array($Product_list_class,'my_shortcode_function') );
		add_action( 'wp', array($Product_list_class,'add_shortcode_to_page') );
	}
	

}

// phpcs:ignore
// add_action( 'some_action', 'some_function' );

