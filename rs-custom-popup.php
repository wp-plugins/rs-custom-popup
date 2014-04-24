<?php
/**
 * Plugin Name:       RS Custom Popup
 * Plugin URI:        http://www.rstandley.co.uk
 * Description:       A plugin that allows you to create your own popup
 * Version:           1.0.1
 * Author:            Rory Standley
 * Author URI:		  http://www.rstandley.co.uk
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$rscustompopup_db_version = "1.0.0";

require_once( plugin_dir_path( __FILE__ ) . 'public/class-rs-custom-popup.php' );
add_action( 'plugins_loaded', array('RSCustomPopup', 'get_instance' ) );

register_activation_hook( __FILE__, array( 'RSCustomPopup', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'RSCustomPopup', 'deactivate' ) );

if(is_admin()){
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-rs-custom-popup-admin.php' );
	add_action( 'plugins_loaded', array( 'RSCustomPopup_Admin', 'get_instance' ) );
}

add_action( 'wp_ajax_getPopup', 'getPopup' );

function getPopup() {
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."rs_custom_popup");
	echo json_encode($result);
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_createPopup', 'createPopup' );

function createPopup() {
	global $wpdb;
	$pageIds = "";
	if(isset($_POST["post_pages_id"]) && count($_POST["post_pages_id"])>0){
		$fakeCount = 1;
		foreach($_POST["post_pages_id"] as $value){
			if($fakeCount < count($_POST["post_pages_id"])){
				$pageIds .= $value.",";
			}else{
				$pageIds .= $value;
			}
			$fakeCount++;
		}			
	}
	$truncateMe = $wpdb->get_results("TRUNCATE ".$wpdb->prefix."rs_custom_popup");
	extract($_POST);
	$result = $wpdb->get_results("INSERT INTO ".$wpdb->prefix."rs_custom_popup"." (rscustompopup_image,rscustompopup_url,rscustompopup_pages,rscustompopup_background_colour,rscustompopup_text_colour,rscustompopup_use_cookie) VALUES ('$post_image','$post_image_url','$pageIds','$post_back_color','$post_front_color','$post_cookie')");
	echo json_encode(array('popup'=>'added'));
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_deletePopup', 'deletePopup' );

function deletePopup() {
	global $wpdb;
	$truncateMe = $wpdb->get_results("TRUNCATE ".$wpdb->prefix."rs_custom_popup");
	echo json_encode(array('popup'=>'deleted'));
	die(); // this is required to return a proper result
}

add_action( 'wp_ajax_createCookie', 'createCookie' );

function createCookie() {
	setcookie("rscustompopup_popup","rscustompopup_popup",time()+(86400*31),"/");
	die(); // this is required to return a proper result
}