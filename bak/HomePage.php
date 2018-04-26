<?php

class HomePage extends Page {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public static $has_many = array( 
		'Tiles' => 'Tile'
	);
	
	public static $report;
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		//Tiles
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			'Title' => 'Title',
			'Image' => 'Image'
        ));
		//$config->addComponent(new GridFieldSortableRows('Position'));
		
		$tileField = new GridField(
            'Tiles', // Field name
            'Tile', // Field title
            $this->Tiles(), // List of all related slides
            $config
        );  
		$fields->addFieldToTab('Root.Tiles', $tileField);
		
		return $fields;
	}

}
class HomePage_Controller extends Page_Controller {

	public static $allowed_actions = array('SubscriptionForm');
	
	public function SubscriptionForm() {
		return new SubscriptionForm($this, "SubscriptionForm");
	}
	
	public function getSubscriptionSent(){
		if (Session::get("subscriptionSent") == true){
			Session::set("subscriptionSent", false);
			return true;
		}else {
			return false;
		}
	}

}
