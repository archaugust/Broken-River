<?php
include_once('Report/Report.php');

class Page extends SiteTree {

	private static $db = array(
		'QuickLink' => 'Boolean',
		'ShortDescription' => 'Varchar(250)'
	);

	private static $has_one = array(
		'Thumbnail' => 'Image'
	);
	
	private static $has_many = array( 
		'Slides' => 'Slide',
		'Sections' => 'Section'
	);
	
	private static $report;
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', new CheckboxField('QuickLink'), 'Content');
		$fields->addFieldToTab('Root.Menu', new UploadField('Thumbnail'));
		$fields->addFieldToTab('Root.Menu', new TextareaField('ShortDescription'));
		
		
		//Slides
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			'Image' => 'Image'
        ));
		//$config->addComponent(new GridFieldSortableRows('Position'));
		
		$slideField = new GridField(
            'Slides', // Field name
            'Slide', // Field title
            $this->Slides(), // List of all related slides
            $config
        );  
		$fields->addFieldToTab('Root.Slides', $slideField);
		
		
		//Sections
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			'Title' => 'Title'
        ));
		$config->addComponent(new GridFieldSortableRows('Position'));
		
		$gridField = new GridField(
            'Sections', // Field name
            'Section', // Field title
            $this->Sections(), // List of all related sections
            $config
        );
		$fields->addFieldToTab('Root.Sections', $gridField);
		
		return $fields;
	}
	
	
	public function getQuickLinks() {
		$pages = Page::get()->filter(array(
			'QuickLink' => '1'
		));
		return $pages;
	}
	
	
	/* Creates a singleton report if it doesn't exist already and returns the latest snowfall date */
	public function getLatestFallDate(){
		if (!isset($this->report)) {
			$this->report = Report::getReport();
		}
		return $this->report->getLatestFallDateShort();
	}
	
	/* Creates a singleton report if it doesn't exist already and returns the latest snowfall average */
	public function calcSnowAvg(){
		if (!isset($this->report)) {
			$this->report = Report::getReport();
		}
		return $this->report->calcSnowAvg();
	}
	
	/* Creates a singleton report if it doesn't exist already */
	public function getWeatherBrief(){
		if (!isset($this->report)) {
			$this->report = Report::getReport();
		}
		return $this->report->getWeatherBrief();
	}
	
	/* Reports Page link */
	public function getReportsLink(){
		$result = ReportsPage::get()->limit(1);
		return (sizeof($result) > 0 ) ? $result[0]->link() : '#';
	}
	
	/* Contact Page link */
	public function getContactLink(){
		$result = ContactPage::get()->limit(1);
		return (sizeof($result) > 0 ) ? $result[0]->link() : '#';
	}
	
	/* News Page link */
	public function getBlogLink(){
		$result = BlogPage::get()->limit(1);
		return (sizeof($result) > 0 ) ? $result[0]->link() : '#';
	}
	
	/* Accommodation Page link */
	public function getAccommodationLink(){
		$result = AccommodationPage::get()->limit(1);
		return (sizeof($result) > 0 ) ? $result[0]->link() : '#';
	}
	
	/* Helper functions to clear some logic out of the template */
	
	public function ouputMenuLink() {
		$hasChildren = $this->hasChildren();
		$html = ($this->ClassName === 'MenuTitlePage') ? '<span class="'.$this->LinkingMode.' menu-title">' : '<a href="'.$this->Link().'" title="'.$this->Title.'" class="'.$this->LinkingMode.'">' ;
			$html .= $this->MenuTitle;
			$html .= ($hasChildren && !$this->parent) ? '<span class="open-button">+</span>' : '';//TDOD check this
		$html .= ($this->ClassName === 'MenuTitlePage') ? '</span>' : '</a>';
		return $html;
	}
	
	public function hasChildren() {
		if ($this->ClassName === 'BlogPage'){
			return false;
		//}else if ($this->ClassName === 'VideoPage') {
		//	return sizeof($this->VideoCategories()) > 0;
		}else {
			return sizeof($this->Children()) > 0;
		}
	}
	
	public function sortedSections() {
		return $this->Sections()->sort('Position');
	}
	

}
class Page_Controller extends ContentController {

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
	}

	public function isLogged() {
		return Session::get('isLogged');
	}

	public function StatusMessage() {
		if(Session::get('ActionMessage')) {
			$message = Session::get('ActionMessage');
			$status = Session::get('ActionStatus');

			Session::clear('ActionStatus');
			Session::clear('ActionMessage');

			return new ArrayData(array('Message' => $message, 'Status' => $status));
		}

		return false;
	}	
}
