<?php

/* Helper class for Report */
class Facility extends ViewableData{
	
	public $name = '';
	private $status = [];
	
	public static function createFromXMLElement($data){
		$facility = new Facility();
		
		$facility->name = (string)$data->name;
		$facility->status['code'] = (string)$data->status->code;
		$facility->status['label'] = (string)$data->status->label;
		$facility->brief = (string)$data->brief;
		
		return $facility;
	}
	
	public function getStatusCode(){
		return $this->status['code'];
	}
	
	public function getStatusLabel() {
		return $this->status['label'];
	}

	public function getBrief() {
		return $this->brief;
	}
}