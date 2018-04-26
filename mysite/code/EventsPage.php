<?php

class EventsPage extends Page {

	private static $db = array(
	);

	private static $has_one = array(
	);
	
	private static $has_many = array(
		'Events' => 'Event'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			'Name' => 'Name'
        ));
		//$config->addComponent(new GridFieldSortableRows('Position'));
		
		$eventField = new GridField(
            'Events', // Field name
            'Event', // Field title
            $this->Events(), // List of all related slides
            $config
        );  
		$fields->addFieldToTab('Root.Events', $eventField); 
		
		return $fields;
	}
	
	public function eventsByDate(){
		$events = $this->Events();
		if( !$events )
		  return null; // no events, nothing to work with
		
		$events = $events->sort('Date');

		// return sorted set
		return $events;
	}

}
class EventsPage_Controller extends Page_Controller {

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
