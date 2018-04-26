<?php

class GalleryPage extends Page {

	private static $db = array(
		'GalleryText' => 'Varchar(250)',
		'ArchiveText' => 'Varchar(250)'
	);

	private static $has_one = array(
	);
	
	public static $has_many = array( 
		'Photos' => 'Photo'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', new TextareaField('GalleryText'), 'Content');
		$fields->addFieldToTab('Root.Main', new TextareaField('ArchiveText'), 'Content');
		
		//Slides
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			'Image' => 'Image'
        ));
		//$config->addComponent(new GridFieldSortableRows('Position'));
		
		$photoField = new GridField(
            'Photos', // Field name
            'Photo', // Field title
            $this->Photos(), // List of all related slides
            $config
        );  
		$fields->addFieldToTab('Root.Photos', $photoField);
		
		return $fields;
	}
	
	public function getPhotos($sort='current'){
		$now = new DateTime('NOW');
		$photos = Photo::get()->sort('Date DESC');
		$sortedPhotos = new ArrayList();
		foreach ($photos as $photo) {
			$pDate = new DateTime($photo->Date);
			if ($sort === 'current' && $pDate->format('Y') === $now->format('Y')) {
				$sortedPhotos->add($photo);
			}else if($sort === 'archived' && $pDate->format('Y') < $now->format('Y')) {
				$sortedPhotos->add($photo);
			}
		}
		return $sortedPhotos;
	}
}
class GalleryPage_Controller extends Page_Controller {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
	}

}
