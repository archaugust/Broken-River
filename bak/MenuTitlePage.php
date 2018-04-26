<?php

class MenuTitlePage extends Page {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	public static $has_many = array( 
	);
	
	private static $description = 'Used only to organise things in the menu - has no content';
	
	static $defaults = array('ShowInSearch' => '0');
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->removeByName('Content');
		$fields->removeByName('QuickLink');
		$fields->removeByName('Slides');
		$fields->removeByName('Sections');
		$fields->removeByName('Metadata');
		
		return $fields;
	}
	

}
class MenuTitlePage_Controller extends Page_Controller {

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
