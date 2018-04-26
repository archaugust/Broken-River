<?php

class VideoPage extends Page {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public static $has_many = array( 
		'VideoCategories' => 'VideoCategory'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			'Name' => 'Name'
        ));
		//$config->addComponent(new GridFieldSortableRows('Position'));
		
		$videoField = new GridField(
            'Video Categories', // Field name
            'Category', // Field title
            $this->VideoCategories(), // List of all related slides
            $config
        );  
		$fields->addFieldToTab('Root.Videos', $videoField); 
		
		return $fields;
	}
	
	private static $allowed_children = array();
	
	public function allVideos() {
		$videos = new ArrayList();
		foreach($this->VideoCategories() as $cat) {
			foreach($cat->Videos() as $v) {
				$videos->add($v);
			}
		}
		return $videos->sort('Date', 'DESC');
	}

	public function latestVideos($limit = 4) {
		return $this->allVideos()->limit($limit);
	}
}
class VideoPage_Controller extends Page_Controller {

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
