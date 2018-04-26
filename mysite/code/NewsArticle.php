<?php

class NewsArticle extends Page {

	private static $db = array(
		'Date' => 'SS_Datetime',
		'Description' => 'HTMLText'
	);

	private static $has_one = array(
		'Image' => 'Image'
	);
	
	public static $has_many = array( 
		'SidePhotos' => 'NewsArticlePhoto'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->removeByName('QuickLink');
		$fields->removeByName('Sections');
		$fields->removeByName('Slides');
		$fields->removeByName('Menu');
		
		$datetimeField = new DatetimeField('Date', 'Date');
		$datetimeField->getDateField()->setConfig('showcalendar', true);
		$fields->addFieldToTab('Root.Main', $datetimeField, 'Content');
		
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('Description'), 'Content');
		
		$fields->addFieldToTab('Root.Banner', new UploadField('Image'));
		$fields->addFieldToTab('Root.Photos',  GridField::create(
				'SidePhotos',
				'Side Photos',
				$this->SidePhotos(),
				GridFieldConfig_RecordEditor::create()
				));
		
		return $fields;
	}
	
	public function formatDate() {
		return date("F j, Y", strtotime($this->Date));
	}

}
class NewsArticle_Controller extends Page_Controller {

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
