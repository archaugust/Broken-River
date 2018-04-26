<?php 
class Tile extends DataObject {
	static $db = array(
		//'Position' => 'Int'
		'Title' => 'varchar(250)',
		'SubHeading' => 'varchar(250)',
		'Link' => 'Varchar(250)',
		'ButtonText' => 'Varchar(250)',
		'Content' => 'Varchar(500)'
	 );
	
	static $has_one = array(
        'HomePage' => 'HomePage',
		'Image' => 'Image'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', new TextareaField('Content'), 'Link');
		
		return $fields;
	}
}