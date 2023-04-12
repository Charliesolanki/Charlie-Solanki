<?php

namespace MyApp\WordPress;

use WPEmerge\ServiceProviders\ServiceProviderInterface;

/**
 * Register plugin options.
 */
class PluginServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		// Nothing to register.
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		register_activation_hook( MY_APP_PLUGIN_FILE, [$this, 'activate'] );
		register_deactivation_hook( MY_APP_PLUGIN_FILE, [$this, 'deactivate'] );

		add_action( 'plugins_loaded', [$this, 'loadTextdomain'] );
	}

	/**
	 * Plugin activation.
	 *
	 * @return void
	 */
	public function activate() {
		// Nothing to do right now.
		global $wpdb;
  
		if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'external-products'", 'ARRAY_A' ) ) {
		 
		$current_user = wp_get_current_user();

		// create post object
		$page = array(
		  'post_title'  => __( 'External Products' ),
		  'post_status' => 'publish',
		  'post_author' => $current_user->ID,
		  'post_type'   => 'page',
		);

		// insert the post into the database
		wp_insert_post( $page );
		}
	}

	/**
	 * Plugin deactivation.
	 *
	 * @return void
	 */
	public function deactivate() {
		$page_slug = 'external-products'; // Change this to the slug of your desired page

	    $page = get_page_by_path( $page_slug );
	    if ( $page ) {
	        wp_delete_post( $page->ID, true );
	    }
	}

	/**
	 * Load textdomain.
	 *
	 * @return void
	 */
	public function loadTextdomain() {
		load_plugin_textdomain( 'my_app', false, basename( dirname( MY_APP_PLUGIN_FILE ) ) . DIRECTORY_SEPARATOR . 'languages' );
	}
}
