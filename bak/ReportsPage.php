<?php
include_once('Report/Report.php');
include_once('Report/HtmlParser.php');
require_once('dompdf/autoload.inc.php');
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportsPage extends Page {

	private static $db = array(
		'SponsorLink' => 'Varchar(250)'
	);

	private static $has_one = array(
		'SponsorImage' => 'Image'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Sponsor', new UploadField('SponsorImage'));
		$fields->addFieldToTab('Root.Sponsor', new TextField('SponsorLink'));
		
		return $fields;
	}
	
	public function getReport() {
		$report = Report::getReport();
		return $report;
	}
	
	/** 
	 * Gets the feed's date and time
	 * @return	String	The date and time in the format like 'Mon April 4th, 6:11pm'
	 */
	public function getFeedDateAndTime() {
		$feed = file_get_contents('https://api@brokenriver.co.nz:ycKNH6C287WQzyuk@www.snowhq.com/nz/canterbury/broken-river/broken-river-snow-report/xml');
		$xml = simplexml_load_string($feed);
		$dateAndTime = $xml->date.$xml->time;
		return date("D F jS, g:ia", strtotime($dateAndTime));
	}
	
	public function convertDate($date) {
		return date("j F", strtotime($date));
	}
	
	/*
	* @return String	html to display the webcam
	*/
	public function webcam() {
		/*
		$location = 'snowhq/';
		$dir = '.././'.$location;
		$feed = file_get_html('http://snow.co.nz/canterbury/brokenriver/snowreport/');
		
		// Find and save images
		$imagesDir = '.././'. $location;
		$url = 'http://snow.co.nz';
		$webcam_images = array();
		
		$first = 0; // don't pull first image match since it's a copy of the latest image
		foreach($feed->find('img') as $element) {

			if (substr($element->src,0,36) == '/media/cameras/brokenriver/DayLodge/') {
				if ($first > 0) {
					$webcam_image = explode('/', $element->src);
					$webcam_images[] = end($webcam_image);
					
					// check if file exists 
					if (!file_exists ( $dir . end($webcam_image) )) {
						$resized = $imagesDir . end($webcam_image);
						$this->resize($url . $element->src, null, 640, 1200, true, $resized, false, false, 80);
					}
				}
				$first++;
			}
		}
		*/
		$dir = ".././webcamshots/";

		if (is_dir($dir)) {
			$files = array_diff(scandir($dir, 1), array('..', '.'));
			rsort($files);
			$html = '<div class="br-webcam">';
			$i = 0;
			foreach($files as $file) {

				if (substr($file, 0, 3) === "IMG"){ 
/*
					$date = date(
								'l, F jS g:i a',
								mktime(
									substr($file, 11, 2),  //hour
									substr($file, 13, 2),  //min
									0, //second
									substr($file, 7, 2), //month
									substr($file, 9, 2),  //day
									substr($file, 3, 4)  //year
								)
							);
*/
					$date = date(
								'l, F jS g:i a',
								mktime(
									substr($file, 11, 2),  //hour
									substr($file, 13, 2),  //min
									0, //second
									substr($file, 3, 2), //month
									substr($file, 5, 2),  //day
									substr($file, 7, 4)  //year
								)
							);
				}
				
				$html .= '<div class="webcam-image" id="i'.($i+1).'">
							<div><img src="'.Director::BaseURL() . $dir . $file.'"/></div>
							<span>'.$date.'</span>
						</div>';
				$i++;
				if ($i > 16) break;
			}
			$html .= '	<div id="slider"></div>
						<input id="mobile-slider" type="range" min="-'.$i.'" max="-1" step="1" value ="1" />
					</div>';
			return $html;
		}
	}

	public function resize($file,
			$string             = null,
			$width              = 0,
			$height             = 0,
			$proportional       = false,
			$output             = 'file',
			$delete_original    = true,
			$use_linux_commands = false,
			$quality = 90
			) {
				if ( $height <= 0 && $width <= 0 ) return false;
				if ( $file === null && $string === null ) return false;
				
				# Setting defaults and meta
				$info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
				$image                        = '';
				$final_width                  = 0;
				$final_height                 = 0;
				list($width_old, $height_old) = $info;
				$cropHeight = $cropWidth = 0;
				
				# Calculating proportionality
				if ($proportional) {
					if      ($width  == 0)  $factor = $height/$height_old;
					elseif  ($height == 0)  $factor = $width/$width_old;
					else                    $factor = min( $width / $width_old, $height / $height_old );
					
					$final_width  = round( $width_old * $factor );
					$final_height = round( $height_old * $factor );
				}
				else {
					$final_width = ( $width <= 0 ) ? $width_old : $width;
					$final_height = ( $height <= 0 ) ? $height_old : $height;
					$widthX = $width_old / $width;
					$heightX = $height_old / $height;
					
					$x = min($widthX, $heightX);
					$cropWidth = ($width_old - $width * $x) / 2;
					$cropHeight = ($height_old - $height * $x) / 2;
				}
				
				# Loading image to memory according to type
				switch ( $info[2] ) {
					case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
					case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
					case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
					default: return false;
				}
				
				
				# This is the resizing/resampling/transparency-preserving magic
				$image_resized = imagecreatetruecolor( $final_width, $final_height );
				if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
					$transparency = imagecolortransparent($image);
					$palletsize = imagecolorstotal($image);
					
					if ($transparency >= 0 && $transparency < $palletsize) {
						$transparent_color  = imagecolorsforindex($image, $transparency);
						$transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
						imagefill($image_resized, 0, 0, $transparency);
						imagecolortransparent($image_resized, $transparency);
					}
					elseif ($info[2] == IMAGETYPE_PNG) {
						imagealphablending($image_resized, false);
						$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
						imagefill($image_resized, 0, 0, $color);
						imagesavealpha($image_resized, true);
					}
				}
				imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
				
				
				# Taking care of original, if needed
				if ( $delete_original ) {
					if ( $use_linux_commands ) exec('rm '.$file);
					else @unlink($file);
				}
				
				# Preparing a method of providing result
				switch ( strtolower($output) ) {
					case 'browser':
						$mime = image_type_to_mime_type($info[2]);
						header("Content-type: $mime");
						$output = NULL;
						break;
					case 'file':
						$output = $file;
						break;
					case 'return':
						return $image_resized;
						break;
					default:
						break;
				}
				
				# Writing image according to type to the output destination and image quality
				switch ( $info[2] ) {
					case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
					case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
					case IMAGETYPE_PNG:
						$quality = 9 - (int)((0.9*$quality)/10.0);
						imagepng($image_resized, $output, $quality);
						break;
					default: return false;
				}
				
				return true;
	}
	
}

class ReportsPage_Controller extends Page_Controller {
	
	public static $allowed_actions = array('ContactForm', 'SubscriptionForm', 'Pdf');
	
	public function SubscriptionForm() {
		return new SubscriptionForm($this, "SubscriptionForm");
	}
	
	public function getSubscriptionSent(){
		if (Session::get("subscriptionSent") == true){
			Session::set("subscriptionSent", false);
			return true;
		}else {
			return false;
		}
	}
	/*
	* HTML for the snow report PDF
	*/
	public function pdfHtml() {
		$baseUrl = "http://" . $_SERVER['SERVER_NAME'] . Director::BaseURL();
		$themeDir = $baseUrl . 'themes/' . SSViewer::current_theme();
		$cssLocation = $themeDir . '/css';
		$html = '
			<!DOCTYPE html>
			<html>
			<head>
				<title>Snow Report</title>
				<link type="text/css" href="'.$cssLocation.'/typography.css" rel="stylesheet" >
				<link type="text/css" href="'.$cssLocation.'/layout.css" rel="stylesheet" >
				<link type="text/css" href="'.$cssLocation.'/reportPdf.css" rel="stylesheet" >
			</head>
			<body class="ReportsPage Pdf typography">
				<div class="header">
					<p class="pdf-logo"><img src="'.$themeDir.'/images/logo.png" alt="logo" /></p>
					<h1>SNOW REPORT</h1>
					<p class="update-time">'.$this->report->getDateAndTime().'</p>
				</div>
				<div class="report-left">
					'.$this->report->getBrief().'
					<hr />
					<h5>Weather Conditions</h5>
					<p class="orange"><strong>'.$this->report->getWeatherBrief().', '.$this->report->getWeatherTempurature().'&deg;C</strong></p>
					<p>'.$this->report->getWeatherDetail().'</p>
					<hr />
					<h5>Snow Conditions</h5>
					<p class="orange"><strong>Average depth: '.$this->report->calcSnowAvg().'cm</strong> ('.$this->report->getMinSnow().'cm-'.$this->report->getMaxSnow().'cm)</p>
					<p class="orange"><strong>Last snowfall:</strong> '.$this->report->getLatestFall().'cm on '.$this->report->getLatestFallDate().'</p>
					<p>'.$this->report->getSnowDetail().'</p>
					<hr />
					<h5>Upcoming Events</h5>
					<p>'.$this->report->information.'</p>
				</div>
				<div class="report-right">';
				foreach ($this->report->facilityTypes as $facilityType)	{
					$html .= '<h5>' . $facilityType->name . '</h5>
							<div class="facilities">';
							foreach ($facilityType->facilities as $facility)
							{
								$html .= '<div class="facility">
											<p>
												<span class="f-name">'. $facility->name .'</span>
												<span class="f-status s'. $facility->getStatusCode() .'">'.$facility->getStatusLabel().'</span>
											</p>
											<div class="u-brief">'. $facility->getBrief() .'</div>
										</div>';
							}
					$html .= '</div>';
				}
				$html .= '</div>
						<div class="clear"></div>';
			
				if ($this->report->information !== '' || $this->report->dailycomment !== '') {
					$html .= '<div class="info-section">';
						if ($this->report->dailycomment) {
							$html .= '<div class="info">
										<h5>Other Info</h5>
										<p>'.$this->report->dailycomment.'</p>
									</div>';
						}
					$html .= '	<div class="clear"></div>
							</div>';
				}
				
				$html .= '<div class="bottom-section">
							<div class="content">
								'.$this->Content.'
							</div>
						</div>';
/* removed part of footer
 *							<div class="social">
								<div>
									<img src="'.$themeDir.'/images/webcam_knob.png" alt="logo" /><br />
									Broken River Ski Area
								</div>
								<div>
									<img src="'.$themeDir.'/images/webcam_knob.png" alt="logo" /><br />
									@brokenriver
								</div>
							</div>
							<div class="clear"></div>
 */						
			$html .='
			</body>
			</html>
			';
		return $html;
	}
	
	/*
	* Displays a PDF of the snow report
	*/
	public function Pdf() {
//		echo $this->pdfHtml();
//		die();//test html in browser
		
		$html = $this->pdfHtml();
		
		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf->setOptions($options);

		$dompdf->set_option('enable_css_float', TRUE);
		$dompdf->loadHtml($html);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream('Broken River Snow Report - '. date('j F Y'), ["Attachment" => 0]);
	}
}
