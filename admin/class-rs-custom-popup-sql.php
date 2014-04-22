<?php
 
class MyPopup {

	public function __construct() {
		global $wpdb;
		$this->table_name 	= $wpdb->prefix."rs_custom_popup";
		$this->pages_table 	= $wpdb->prefix."posts";
		$this->pages 		= $this->getPages();
	}

	public function outputPages(){
		$data = '<select name="pages" multiple id="pages">';
		foreach($this->pages as $value){
			$data .= '<option value="'.$value->ID.'">'.$value->post_title.'</option>';
		}
		$data .= '</select>';
		return $data;
	}

	public function getPages(){
		global $wpdb;
		$result = $wpdb->get_results("SELECT * FROM ".$this->pages_table." WHERE post_type = 'page'");
		return $result;
	}

}