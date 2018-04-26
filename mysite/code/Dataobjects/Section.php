<?php 
class Section extends DataObject {
	static $db = array(
		'Title' => 'Varchar(250)',
		'Link' => 'Varchar(250)',
		'Content' => 'HTMLText',
		'BannerImage' => 'Boolean',
		'OrangeFade' => 'Boolean',
		'Position' => 'Int'
	);
	
	static $has_one = array(
        'Page' => 'Page',
		'Image' => 'Image'
	);
	
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$bannerImage = new checkboxField('BannerImage');
		$bannerImage->setDescription("If selected this section will be a full width banner image, with the title an content over it.<br />*Unless this is on the homepage, in which case it will be treated as a banner image anyway");
		$fields->addFieldToTab('Root.Main', $bannerImage, 'Content');
		
		$orange = new checkboxField('OrangeFade');
		$orange->setDescription("Only applicable to homepage sections");
		$fields->addFieldToTab('Root.Main', $orange, 'Content');
		
		//$fields->addFieldToTab('Root.Main', new checkboxField('ContentOnly'), 'Content');
		
		$fields->addFieldToTab('Root.Main', new uploadField('Image'));
		
		return $fields;
	}
}