<?php

Class Event extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar(250)',
		'Description' => 'Varchar(250)',
		'Content' => 'HTMLText',
		'Date' => 'SS_Datetime'//,
		//'EndDate' => 'SS_Datetime',
	);
	
	static $has_one = array(
		'EventsPage' => 'EventsPage'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', new textareaField('Description'), 'Content');
		
		$datetimeField = new DatetimeField('Date', 'Date');
		$datetimeField->getDateField()->setConfig('showcalendar', true);
		//$datetimeField->setConfig('datavalueformat', 'yyyy-MM-dd hh:mm');
		$fields->addFieldToTab('Root.Main', $datetimeField, 'Content');
		
		/*$endDatetimeField = new DatetimeField('EndDate', 'End Date');
		$endDatetimeField->getDateField()->setConfig('showcalendar', true);
		//$endDatetimeField->setConfig('datavalueformat', 'yyyy-MM-dd hh:mm');
		$fields->addFieldToTab('Root.Main', $endDatetimeField, 'Content');*/
		
		return $fields;
	}
}