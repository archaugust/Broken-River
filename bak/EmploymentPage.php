<?php
class EmploymentPage extends Page {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	private static $has_many = array(
		'Jobs' => 'Job'
	);
	
	private static $allowed_children = array(
		
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			'Name' => 'Name',
			'Description' => 'Description'
        ));
		//$config->addComponent(new GridFieldSortableRows('Position'));
		
		$gridField = new GridField(
            'Jobs', // Field name
            'Job', // Field title
            $this->Jobs(), // List of all related slides
            $config
        );  
		$fields->addFieldToTab('Root.Jobs', $gridField); 
		
		return $fields;
	}

}
class EmploymentPage_Controller extends Page_Controller {


}
