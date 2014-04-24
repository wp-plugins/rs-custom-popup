<?php
 
class MyPopup {

	public function __construct() {
		global $wpdb;
		$this->table_name 	= $wpdb->prefix."rs_custom_popup";
		$this->pages 		= $this->getPages();
		$this->popup 		= $this->getPopup();
	}

	public function getPages($id = 0){
		global $wpdb;
		$result = $wpdb->get_results("SELECT rscustompopup_pages FROM ".$this->table_name);
		if(count($result)>0){
			// Now we need to explode the results and check to see if the id passed in is our man
			$myArray = explode(",",$result[0]->rscustompopup_pages);
			foreach($myArray as $value){
				if($id == $value){
					return true;
				}
			}
		}
		return false;
	}

	public function showPopup($id = 0){
		return $this->getPages($id);
	}

	public function getImage(){
		return $this->image;
	}

	public function getURL(){
		return $this->url;
	}

	public function getBackColour(){
		return $this->backColour;
	}

	public function getTextColour(){
		return $this->textColour;
	}

	private function getPopup(){
		global $wpdb;
		$result = $wpdb->get_results("SELECT * FROM ".$this->table_name);
		foreach($result as $value){
			$this->image 		= $value->rscustompopup_image;
			$this->url 			= $value->rscustompopup_url;
			$this->backColour	= $value->rscustompopup_background_colour;
			$this->textColour	= $value->rscustompopup_text_colour;
		}
	}

}