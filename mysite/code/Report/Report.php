<?php
include_once('Facility.php');
include_once('FacilityType.php');

class Report extends ViewableData{
	
	public $id = '';
	public $name = '';
	public $date = '';
	public $time = '';
	private $status = [];
	private $weather = [];
	private $snow =[];
	private $road = [];
	public $facilityTypes = []; //An array of FacilityTypes, which have an array of Facilities
	public $information = ''; //Called Further Details in Thrive
	public $dailycomment = ''; //Called Weekend Outlook in Thrive
	public $hasWebcam = false;
	
	
	/** 
	 * Create a Report from a SimpleXMLElement object
	 * @property	SimpleXMLElement	$data	SimpleXMLElement from the feed
	 */
	public function __construct($data){
		$this->id = $data->id;
		$this->name = (string)$data->name;
		$this->date = (string)$data->date;
		$this->time = (string)$data->time;
		$this->information = (string)$data->information;
		$this->dailycomment = (string)$data->dailycomment;
		
		$this->status['code'] = (string)$data->status->code;
		$this->status['openingdate'] = (string)$data->status->openingdate;
		$this->status['updatetime'] = (string)$data->status->updatetime;
		
		$this->snow['base'] = (string)$data->snow->mindepth; //min
		$this->snow['upperbase'] = (string)$data->snow->base; //max
		$this->snow['latestfall'] = (string)$data->snow->latestfall;
		$this->snow['latestfalldate'] = (string)$data->snow->latestfalldate;
		$this->snow['detail'] = (string)$data->snow->detail;
		
		$this->road['code'] = (string)$data->road->code;
		$this->road['brief'] = (string)$data->road->brief;
		$this->road['detail'] = (string)$data->road->detail;
		
		$this->weather['detail'] = (string)$data->weather->detail;
		$this->weather['brief'] = (string)$data->weather->brief;
		$this->weather['temperature'] = (string)$data->weather->temperature;
		
		$this->facilityTypes = new ArrayList();
		foreach($data->facilities->facilitytype as $type) {
			$t = FacilityType::createFromXMLElement($type);//mostly just to get this viewable in template, and display it's name
			$t->facilities = new ArrayList();
			foreach($type as $name=>$facility){
				if ($name === 'facility'){//avoid the facility type's name and ID
					$f = Facility::createFromXMLElement($facility);
					$t->facilities->push($f);
				}
			}
			$this->facilityTypes->push($t);
		}
	}
	
	/** 
	 * Gets relevant ski fields from the feed by id
	 * @return	ArrayList	An ArrayList of relevant ski fields as ArrayData
	 */
	public static function getReport() {
		//IDs of the ski fields we want from the feed
		$targets = array(13); //Broken River's feed ID
		$feed = file_get_contents('https://api@brokenriver.co.nz:ycKNH6C287WQzyuk@www.snowhq.com/nz/canterbury/broken-river/broken-river-snow-report/xml');
		if ($feed) {
			$xml = simplexml_load_string($feed);
			
			$report = null;
			foreach($xml->skiareas->skiarea as $data){
				if (in_array($data->id, $targets)) {
					if ($data->id == 13){//BR
						//$data->status->code = 5;
						$report = new Report($data);
					}
				}
			}
			return $report;
		}
	}
	
	/** 
	 * Returns the appropriate string to display based on the status code
	 * @return		string	Readable status
	 */
	public function getStatus() {
		$code = $this->status['code'];
		if ($code === '0'){
			return 'Closed';
		}else if($code === '1'){
			return 'On Hold';
		}else if($code === '2'){
			return 'Open';
		}else if($code === '3'){
			$openingDate = ($this->status['openingdate'] === '') ? 'soon' : date("j M", strtotime($this->status['openingdate']));
			return 'Opening '.$openingDate; 
		}else if($code === '4'){
			return 'Closed For Season'; 
		}else if($code === '5'){ 
			$updateTime = ($this->status['updatetime'] === '') ? 'No Estimate' : 'Estimated: '.date("g:ia", strtotime($this->status['updatetime']));
			return 'Delayed '.$updateTime; 
		}
	}
	
	/** 
	 * Returns the appropriate string to display based on the status code
	 * @return		string	html for readable status button
	 */
	public function statusButton() {
		$code = $this->status['code'];
		if ($code === '0'){
			return '<div class="status-button s'.$code.'">Closed</div>';
		}else if($code === '1'){
			return '<div class="status-button s'.$code.'">On Hold</div>';
		}else if($code === '2'){
			return '<div class="status-button s'.$code.'">Open</div>';
		}else if($code === '3'){
			$openingDate = ($this->status['openingdate'] === '') ? 'soon' : date("j M", strtotime($this->status['openingdate']));
			return '<div class="status-button s'.$code.'">Opening '.$openingDate.'</div>'; 
		}else if($code === '4'){
			return '<div class="status-button s'.$code.'">Closed <span>For Season</span></div>'; 
		}else if($code === '5'){ 
			$updateTime = ($this->status['updatetime'] === '') ? 'No Estimate' : 'Estimated: '.date("g:ia", strtotime($this->status['updatetime']));
			return '<div class="status-button s'.$code.'">Delayed Opening</div>
					<div class="estimate">'.$updateTime.'</div>'; 
		}
	}
	
	/** 
	 * Returns the appropriate string to display based on the road code
	 * @return		string	Readable road status
	 */
	public function evaluateRoad() {
		$code = $this->road['code'];
		if ($code === '0'){
			return 'Closed';
		}else if($code === '1'){
			return 'Chains on all vehicles';
		}else if($code === '2'){
			return 'Chains or 4WD';
		}else if($code === '3'){ 
			return 'Chains carried'; 
		}else if($code === '4'){ 
			return 'Open'; 
		}else if($code === '5'){ 
			return 'Air Access Only'; 
		}
	}
	
	/**
	 * For convience. This is used in both the ReportsPage template and the Pdf's html function
	 * @return	string	html to display a breif weather overview	
	 */
	public function getBrief() {
		$baseUrl = "http://" . $_SERVER['SERVER_NAME'] . Director::BaseURL();
		$themeDir = $baseUrl . 'themes/' . SSViewer::current_theme();
		$html = '<div class="brief">
					<div class="cell" >'.$this->statusButton().'</div>
					<div class="cell weather"><img src="'.$themeDir.'/images/weather_report/'.$this->getWeatherBrief().'.png" alt="weather-icon" /></div>
					<div class="cell temp">'.$this->getWeatherTempurature().'&deg;</div>
					<div class="cell snowfall">
						Last Snowfall<br />
						<span class="amount">'.$this->getLatestFall().'cm</span><br />
							on '.$this->getLatestFallDate().'
					</div>
				</div>';
		return $html;
	}
	
	/** 
	 * Returns the average snow from the min and max snow fall
	 * @return		int	Average snowfall
	 */
	public function calcSnowAvg() {
		$min = $this->snow['base'];
		$max = $this->snow['upperbase'];
		return ($min + $max)/2;
	}
	
	/** 
	 * Gets the feed's date and time for this ski field
	 * @return	String	The date and time in the format 'Mon April 4th, 6:11pm'
	 */
	public function getDateAndTime() {
		$dateAndTime = $this->date.$this->time;
		return date("g:iA, l jS F Y", strtotime($dateAndTime));
	}
	
	/* Getter for status code */
	public function getStatusCode() {
		return $this->status['code'];
	}
	
	
	/* Road getters */
	
	public function getRoadBrief() {
		return $this->road['brief'];
	}
	
	public function getRoadDetail() {
		return $this->road['detail'];
	}
	
	/* Snow getters */
	
	public function getMinSnow() {
		return $this->snow['base'];
	}
	
	public function getMaxSnow() {
		return $this->snow['upperbase'];
	}
	
	public function getLatestFall() {
		return $this->snow['latestfall'];
	}
	
	public function getLatestFallDate() {
		return date("j F", strtotime($this->snow['latestfalldate']));
	}
	
	public function getLatestFallDateShort() {
		return date("j M", strtotime($this->snow['latestfalldate']));
	}
	
	public function getSnowDetail() {
		return $this->snow['detail'];
	}
	
	/* Weather getters */
	
	public function getWeatherBrief() {
		return $this->weather['brief'];
	}
	
	public function getWeatherDetail() {
		return $this->weather['detail'];
	}
	
	public function getWeatherTempurature() {
		return $this->weather['temperature'];
	}
}