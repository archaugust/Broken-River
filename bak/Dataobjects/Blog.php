<?php

Class Blog extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar(250)',
		'Description' => 'Varchar(250)',
		'Content' => 'HTMLText',
		'Date' => 'SS_Datetime'
	);
	
	static $has_one = array(
		'BlogPage' => 'BlogPage'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', new textareaField('Description'), 'Content');
		
		$datetimeField = new DatetimeField('Date', 'Date');
		$datetimeField->getDateField()->setConfig('showcalendar', true);
		$fields->addFieldToTab('Root.Main', $datetimeField, 'Content');
		
		return $fields;
	}
	
	public function populateDefaults() {
		parent::populateDefaults();
		$this->setField('Date', date('Y-m-d H:i:s', strtotime('now')));
	}
}