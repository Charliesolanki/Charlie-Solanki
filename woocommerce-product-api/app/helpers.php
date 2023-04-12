<?php
/**
 * Load helpers.
 * Define any generic functions in a helper file and then require that helper file here.
 *
 * @package MyApp
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Product_list_class {

	public function __construct()
	{
	
	}

	public function wpa3396_page_template( $page_template )
	{
		$dir = plugin_dir_path( __DIR__ );
	    if ( is_page( 'external-products' ) ) {
	        $page_template = $dir. 'src/Page-template/javascript-route.php';
	    }
	    return $page_template;
	}

	public function Get_product_list( $data ){
		$curl = curl_init();
		$params = $data->get_url_params();
		if(empty($params['page'])){
			$page = 1;
		}else{
			$page = $params['page'];
		}
		$key = base64_encode(CONSUMER_KEY.':'.CONSUMER_SECRET);
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://challenge.homolog.tech/wp-json/wc/v3/products?per_page='.PER_PAGE.'&orderby='.ORDERBY.'&order='.ORDER.'&_fields='.SHOWFIELDS.'&page='.$page,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Basic '.$key,
		  ),
		));
		$response = curl_exec($curl);
		$i = 0;
		$response = curl_exec($curl);
		$json_array = json_decode($response);
		$i = 0;
		foreach($json_array as $json_array_val){
			$images = $json_array_val->images;
			$product_return_array[$i] =  array(
				'id'=>$json_array_val->id,
				'name'=>$json_array_val->name,
				'description'=>$json_array_val->description,
				'price'=>$json_array_val->price,
				'type'=>$json_array_val->type,
				'imageUrl'=> $images[0]->src,
				'productLink'=>$json_array_val->permalink
			);
			$i++;
		}
		// if ($response === false) {
		// 	echo "1";
		//     // Handle cURL error
		//     $error_message = curl_error($curl);
		//     echo "cURL error: " . $error_message;
		// } elseif (empty($response)) {
		// 	echo "2";
		//     // Handle empty response
		//     echo "Empty response";
		// } else {
		// 	echo "3";
		//     // Process the response
		//     echo "<pre>"; print_r($json_array);
		// }
		curl_close($curl);
		if(empty($json_array)){
			echo "NOT A VALID PAGE NUMBER";
		}else{
			echo json_encode($product_return_array,JSON_UNESCAPED_SLASHES);
		}
	}


	public function Get_product_list_all( $data ){
		$curl = curl_init();
		$params = $data->get_url_params();
		// if(empty($params['page'])){
		// 	$page = 1;
		// }else{
		// 	$page = $params['page'];
		// }
		$key = base64_encode(CONSUMER_KEY.':'.CONSUMER_SECRET);
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://challenge.homolog.tech/wp-json/wc/v3/products?orderby='.ORDERBY.'&order='.ORDER.'&_fields='.SHOWFIELDS,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Basic '.$key,
		  ),
		));
		$response = curl_exec($curl);
		$i = 0;
		$response = curl_exec($curl);
		$json_array = json_decode($response);
		$i = 0;
		$count = 0;
		foreach($json_array as $json_array_val){
			$count++;
			$images = $json_array_val->images;
			$product_return_array[$i] =  array(
				'id'=>$json_array_val->id,
				'title'=>$json_array_val->name,
				'description'=>$json_array_val->description,
				'price'=>$json_array_val->price,
				'type'=>$json_array_val->type,
				'imageUrl'=> $images[0]->src,
				'productLink'=>$json_array_val->permalink
			);
			$i++;
		}
		$product_return_array['count'] = $count;
		curl_close($curl);
		echo json_encode($product_return_array,JSON_UNESCAPED_SLASHES);
		die;
	}


	public function themeslug_enqueue_script() {
		$dir = plugin_dir_url( __DIR__ );
		wp_enqueue_script( 'test-js', $dir.'views/js/custom.js', true );
    	wp_localize_script( 'test-js', 'theme_data', array(
        'home_url' => home_url(),
    	) );

		wp_enqueue_style( 'bootstrap-custom-css', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css', true );
		//wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	}

	// Register the shortcode
	public function my_shortcode_function( $atts ) {
	    return '<div class="container">
		<div class="product-listing row ">
		</div>
		<div class="pagination_inner Page navigation example"></div>
		</div><div id="loader" style="display:none;"></div>';
	}

	// Add the shortcode to the page with the specified slug
	public function add_shortcode_to_page() {
	    $page_slug = 'external-products'; // Change this to the slug of your desired page
	    $shortcode = '[my_shortcode]'; // Replace this with your desired shortcode

	    $page = get_page_by_path( $page_slug );
	    if ( $page ) {
	        $page_id = $page->ID;
	        $content = $page->post_content;
	        $new_content = $shortcode . $content;

	        wp_update_post( array(
	            'ID' => $page_id,
	            'post_content' => $new_content
	        ) );
	    }
	}

	public function Register_rout(){
		$namespace = 'woocommerce-product-api';
		$version = 'v1';
		$base = 'products';
		register_rest_route( $namespace.'/'.$version ,$base, array(
			'methods' => 'GET',
			'callback' => array( $this, 'Get_product_list'),
			));
		register_rest_route( $namespace.'/'.$version, $base.'/(?P<page>[\d]+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'Get_product_list'),
			));
		register_rest_route( $namespace.'/'.$version ,'products-list', array(
			'methods' => 'GET',
			'callback' => array( $this, 'Get_product_list_all'),
			));
		}
}

// Load helpers.
// phpcs:ignore
// require_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'myhelper.php';
