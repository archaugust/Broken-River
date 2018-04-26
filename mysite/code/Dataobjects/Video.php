<?php 
class Video extends DataObject {
	static $db = array(
		'Title' => 'varchar(250)',
		'Subtitle' => 'Varchar',
		'EmbedCode' => 'varchar(250)',
		'Date' => 'SS_Datetime',
		'Description' => 'varchar(250)',
		'Feature' => 'Boolean'
	 );
	
	static $has_one = array(
        'VideoCategory' => 'VideoCategory',
		'Thumbnail' => 'Image'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$datetimeField = new DatetimeField('Date', 'Date');
		$datetimeField->getDateField()->setConfig('showcalendar', true);
		$fields->addFieldToTab('Root.Main', $datetimeField, 'Thumbnail');
		
		$subtitleField = new textField('Subtitle');
		$subtitleField->setDescription("Set to use 'Title' instead of 'Date' as 'Title'");
		$fields->addFieldToTab('Root.Main', $subtitleField);
		$fields->addFieldToTab('Root.Main', new textareaField('Description'));
		$fields->addFieldToTab('Root.Main', new CheckboxField('Feature'));
		
		return $fields;
	}
	
	/* Link to video */
	public function getLink(){
		$parentCat = VideoCategory::get()->byID($this->VideoCategoryID);
		$parentPage = Page::get()->byID($parentCat->VideoPageID);
		return $parentPage->Link()."?video=".$this->ID;
	}
	
	public function linkedVideo() {
		if (isset($_GET['video'])){
			return $_GET['video'];
		}else {
			return 'none';
		}
	}
}