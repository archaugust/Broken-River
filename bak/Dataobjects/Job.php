<?php

Class Job extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar(250)',
		'Description' => 'Varchar(500)',
		'Date' => 'SS_Datetime',
		'BackgroundColour' => 'varchar(50)'
	);
	
	static $has_one = array(
		'EmploymentPage' => 'EmploymentPage'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$colours = array(
			'black' => 'Black',
			'grey' => 'Grey',
			'orange'=> 'Orange'
		);
		$fields->addFieldToTab('Root.Main', DropdownField::create('BackgroundColour', 'Background Colour', $colours));
		
		
		$datetimeField = new DatetimeField('Date', 'Date');
		$datetimeField->getDateField()->setConfig('showcalendar', true);
		//$datetimeField->setConfig('datavalueformat', 'yyyy-MM-dd hh:mm');
		$fields->addFieldToTab('Root.Main', $datetimeField);
		
		$fields->addFieldToTab('Root.Main', new TextareaField('Description'));
		
		return $fields;
	}
	
	public function populateDefaults() {
		parent::populateDefaults();
		$this->setField('Date', date('Y-m-d H:i:s', strtotime('now')));
	}
}