<?php

/* Helper class for Report. Contains Facilities */
class FacilityType extends ViewableData{
	
	public $name = '';
	private $Facilities = [];
	
	public static function createFromXMLElement($data){
		$facilityType = new FacilityType();
		
		$facilityType->name = (string)$data->name;
		
		return $facilityType;
	}
	
}