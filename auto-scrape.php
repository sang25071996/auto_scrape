<?php
/**
 * Plugin Name: auto scrape
 * Plugin URI: efe.com.vn
 * Description: auto scrape efe
 * Version: 1
 * Author: sang
 * Author UR:efe.com.vn
 * License: GPLv2
 */
	add_action('admin_enqueue_scripts','add_style_scrape');
	function add_style_scrape(){
		wp_enqueue_style( 'wp-analytify-style', plugins_url( '/css/bootstrap.min.css',__FILE__));
		wp_enqueue_script( 'custom-script', plugins_url( '/js/jquery-3.2.1.min.js', __FILE__ ) );
		wp_enqueue_script( 'auto-scrape-js', plugins_url( '/js/bootstrap.min.js', __FILE__ ) );
		wp_enqueue_script( 'auto-scrape', plugins_url( '/js/scrape.js', __FILE__ ) );

	}
	add_action('admin_menu','create_menu');
	function create_menu(){
		add_menu_page( 'id_menu_auto_scrape','Auto scrape', 3 ,'auto scrape', 'callback_menu' );
	}
	function callback_menu()
	{
		include("auto-scrape-free.php");
	}
	add_action('wp_ajax_check_url','check_url');
	function check_url(){
		include('simple_html_dom.php');
		$url = $_POST['get_url'];
		if (filter_var($url, FILTER_VALIDATE_URL)) {
			$html = file_get_html($url); //->plaintext;
			//foreach($html->find('div#ctl00_IDContent_ctl00_divContent div#divNewsContent div.VCSortableInPreviewMode img') as $a){
			$html = preg_replace(
				      array(
				      "'<\s*script[^>]*[^/]>(.*?)<\s*/\s*script\s*>'is",
				      "'<\s*script\s*>(.*?)<\s*/\s*script\s*>'is",
				      "'<\s*noscript[^>]*[^/]>(.*?)<\s*/\s*noscript\s*>'is",
				      "'<\s*noscript\s*>(.*?)<\s*/\s*noscript\s*>'is"
				      ), 
				      array(
				            "",
				            "",
				            "",
				            ""
				            ), $html);
			  	echo $html;
			// foreach($html->find('img') as $a){
			// 	print_r($a);
			//}
		} else {
		    echo 'false';
		}
		die();
	}
/* freee */
add_action('wp_ajax_save_free','save_free');
function save_free(){
	include('simple_html_dom.php');
	$replace = str_get_html($_POST["post_content"]);
	foreach($replace->find("img") as $i=> $element){
		$file = str_replace(['"', '\\'],'', $element->src);
		$filename = basename($file);
		$upload_file = wp_upload_bits($filename, null, file_get_contents($file));
		if (!$upload_file['error']) {
			$wp_filetype = wp_check_filetype($filename, null );
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_parent' => $parent_post_id,
				'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
				'post_content' => '',
				'post_status' => 'inherit'
			);
			$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
			if(!is_wp_error($attachment_id)) {
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
				wp_update_attachment_metadata( $attachment_id,  $attachment_data );
			}
		}
		$bien[] = $file;
		$BIENLOCAL[] = wp_get_attachment_image_src($attachment_id , 'full');
		$BIENLOCALS[] = $BIENLOCAL[$i][0];
		// echo $file;
		// echo "<br>";
	}
	$content = str_replace($bien, $BIENLOCALS, $_POST["post_content"]);
	$post_title = $_POST['post_title'];
	$post_category = $_POST['post_category'];
	$post_status = $_POST['post_status'];
	$insert_post = array(
			"post_title" => "$post_title",
			"post_content" => "$content",
			"post_status" => "$post_status",
			"post_category" => array($post_category),
			"post_type" => "post"
		);
	wp_insert_post( $insert_post );
	die();
}
/*-------------insert post--------- */
	add_action('wp_ajax_save_post','save_post');
	function save_post(){
		include('simple_html_dom.php');
		$replace = str_get_html($_POST["post_content"]);
		foreach($replace->find("img") as $i=> $element){
			$file = str_replace(['"', '\\'],'', $element->src);
			$filename = basename($file);
			$upload_file = wp_upload_bits($filename, null, file_get_contents($file));
			if (!$upload_file['error']) {
				$wp_filetype = wp_check_filetype($filename, null );
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_parent' => $parent_post_id,
					'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
				if(!is_wp_error($attachment_id)) {
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
					$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
					wp_update_attachment_metadata( $attachment_id,  $attachment_data );
				}
			}
			$bien[] = $file;
			$BIENLOCAL[] = wp_get_attachment_image_src($attachment_id , 'full');
			$BIENLOCALS[] = $BIENLOCAL[$i][0];
			// echo $file;
			// echo "<br>";
		}
		$content = str_replace($bien, $BIENLOCALS, $_POST["post_content"]);
		$post_title = $_POST['post_title'];
		$post_category = $_POST['post_category'];
		$post_status = $_POST['post_status'];
		$insert_post = array(
				"post_title" => "$post_title",
				"post_content" => "$content",
				"post_status" => "$post_status",
				"post_category" => array($post_category),
				"post_type" => "post"
			);
		wp_insert_post( $insert_post );
		die();
	}

	/*----------------------------------upload AWS ------------------------------- */
	add_action('wp_ajax_aws','aws');
	function aws(){
		include('simple_html_dom.php');
		include('S3.php');
		if (!defined('awsAccessKey')) {
            define('awsAccessKey', 'AKIAJ53K3XBUJTZANQ3Q');
        }
        if (!defined('awsSecretKey')) {
            define('awsSecretKey', '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');
        }
        $s3 = new S3(awsAccessKey, awsSecretKey);
                $html = str_get_html($_POST["post_content"]);
        		
        		foreach($html->find("img") as $key => $element){
                $replace = str_replace(['"', '\\'],'', $element->src);
                
        	        $customName = uniqid(rand(), true) . '.png';
        	      	if ($s3->putObjectString($replace, 'sang.nguyen', $customName, S3::ACL_PUBLIC_READ) && !empty($replace)) {
                        echo "Upload thành công";
                        die();
                    } else {
                        echo "Lỗi";
                    }

        	    }
        die();
	}
	add_action('wp_ajax_up_license','up_license');
	function up_license(){
		$key = $_POST['key'];
		$conn = mysqli_connect("localhost","root","","test") or die("error die");
		$sql = "SELECT * FROM wp_my_licensekey WHERE license_key = '$key' and status = 'on' ";
		$query = mysqli_query($conn,$sql) or die("select error");
		$row = mysqli_num_rows($query);
		if($row == 0){
			echo "error";
		}else{
			$free = dirname(__FILE__).'/auto-scrape-free.php';
			$link = dirname(__FILE__).'/auto-scrape-pro.php';
			$data = file_get_contents($link);
			file_put_contents($free, $data);
			echo "ok";
			// header("location: $link");
		}
		die();
	}

?>