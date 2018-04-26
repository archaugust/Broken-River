<?php 
class Photo extends DataObject {
	static $db = array(
		//'Position' => 'Int'
		'Photographer' => 'varchar(250)',
		'Date' => 'SS_Datetime'
	 );
	
	static $has_one = array(
        'GalleryPage' => 'GalleryPage',
		'Image' => 'Image'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$datetimeField = new DatetimeField('Date', 'Date');
		$datetimeField->getDateField()->setConfig('showcalendar', true);
		$fields->addFieldToTab('Root.Main', $datetimeField);
		
		return $fields;
	}
	
	public function populateDefaults() {
		parent::populateDefaults();
		$this->setField('Date', date('Y-m-d H:i:s', strtotime('now')));
	}
}