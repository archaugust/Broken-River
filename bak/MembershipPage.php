<?php
include_once('PxPay_Curl.php') ;

class MembershipPage extends Page {

	private static $db = array(
		'SectionsTitle' => 'Varchar',
		'ContentMiddle' => 'HTMLText',
		'ContentBottom' => 'HTMLText',
	);

	private static $has_one = array(
		'BannerMiddle' => 'Image',
		'RegistrationFormPdf' => 'File'
	);
	
	private static $has_many = array( 
		'Slides' => 'Slide',
		'Sections' => 'Section'
	);
	
	private static $allowed_children = array ();
	
	public function getCMSFields() {
		$uploader = array();
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', $uploader[] = UploadField::create('RegistrationFormPdf', 'RegistrationFormPdf'), 'Metadata');
		$fields->addFieldToTab('Root.Main', TextField::create('SectionsTitle', 'Sections Title'), 'Metadata');
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('ContentMiddle', 'Content - Middle')->setRows(20), 'Metadata');
		$fields->addFieldToTab('Root.Main', $uploader[] = UploadField::create('BannerMiddle', 'Middle Banner'), 'Metadata');
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('ContentBottom', 'Content - Bottom')->setRows(20), 'Metadata');
		$fields->addFieldToTab('Root.Sections',  GridField::create(
				'Sections',
				'Sections',
				$this->Sections(),
				GridFieldConfig_RecordEditor::create()
		));
		
		foreach ($uploader as $uploaderField) {
			$uploaderField->getValidator()->setAllowedExtensions(array('png','gif','jpeg','jpg','pdf'));
		}
		
		return $fields;
	}

}
class MembershipPage_Controller extends Page_Controller {

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
			'Register',
			'ProcessPayment'
	);

	public function init() {
		parent::init();
		
		Requirements::javascript("https://www.google.com/recaptcha/api.js");
	}

	public function Register(SS_HTTPRequest $request) {
		$data = $request->postVars();
		
		if(isset($data['g-recaptcha-response']) && !empty($data['g-recaptcha-response'])) {
		    $siteConfig = SiteConfig::current_site_config();
		    
		    $secret = $siteConfig->CaptchaSecret;
		    $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$data['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
		    
		    if ($response['success'] != false) {
		        
        		$registrationType = $data['RegistrationType'];
        		$leadAccountNumber = '';
        		
        		$members = count($data['Members']);
        		$total_fees = 0;
        		$fees = 0;
        		$adult = 0;
        		$youth = 0;
        		$html = '';
        		$ctr = 1;
        		
        		// check for duplicate emails
        		$duplicates = 0;
        		$members = Membership::get();
        		
        		foreach ($data['Members'] as $item) {
        			$check = $members->filter(array('Email' => $item['Email']));
        			if ($check->exists())
        				$duplicates++;
        		}
        		
        		if ($duplicates) {
        			return "Application includes an email address that is already in use. Please use a unique email address.";
        		}
        		
        		$memberLeadId = null;
        		foreach ($data['Members'] as $item) {
        
        		    // calculate fees
        		    if ($item['MembershipType'] == 'Adult') {
        		        $adult ++;
        		        $fees = 150;
        		        
        		        // if family, first adult = half annual fee, succeeding adults full fee
        		        if ($registrationType == "Family" && adult == 1)
        		            $fees += 50; // half annual fee
        		        else
        		            $fees += 100;
        		    }
        		    else {
        		        // youth have no joining fee
        		        $youth ++;
        		        // annual fees, if family, 3rd youth is free
        		        if ($registrationType == "Family"){
        		            if ($youth < 3)
        		                $fees = 35;
        		            else
        		                $fees = 0;
        		        }
        		        else 
        		            $fees = 35;
        		    }
        		    
        		    $member = Membership::create();
        			$member->MembershipType = $item['MembershipType'];
        			$member->Status = "Pending";
        			$member->Payment = "Pending";
        			$member->FirstName = $item['FirstName'];
        			$member->LastName = $item['LastName'];
        			$member->Email = $item['Email'];
        			$member->Phone = $item['Phone'];
        			$member->City = $item['City'];
        			$member->Country = $item['Country'];
        			$member->DateOfBirth = $item['DateOfBirth'];
        			$member->Sex = $item['Sex'];
        			$member->Association = $item['Association'];
        			$member->Skills = implode(', ', $item['Skills']);
        			$member->OtherInfo = $item['OtherInfo'];
        			$member->NewsletterEmail = ($item['NewsletterEmail'] == 'Y') ? 'Y' : 'N';
        			$member->NewsletterPrint = ($item['NewsletterPrint'] == 'Y') ? 'Y' : 'N';
        
        			$id = $member->write();
        
        			if ($memberLeadId == null) {
        				$memberLeadId = $id;
        				Session::set('memberLeadId', $id);
        			}
        			
        			if ($item['MembershipNumber'] == '')
        				$membershipNumber = 'New-'. $id;
        			else 
        				$membershipNumber = $item['MembershipNumber'];
        			
        			$member->MembershipNumber = $membershipNumber;
        				
        			// if registrationType = Family
        			if ($registrationType == 'Family') {
        			    if ($leadAccountNumber == '')
        			        $leadAccountNumber = $membershipNumber;
        				if ($ctr > 1)
        			    	$member->LeadAccountNumber = $leadAccountNumber;
        			}
        			
        			$leadAccountId = $member->write();
        			
        			if ($ctr == 1) 
        			    $applicant = 'Lead Applicant';
        		    else {
        			    $applicant = ('Applicant '+ $ctr);
        
        				$member->LeadAccountId = $leadAccountId;
        				$member->write();
        			}
        	        $html = '<strong>'. $applicant .'</strong><br />';
        	        if ($item['New'] == 'New') {
        	            $html .= 'Existing Member';
        	        }
        	        else {
        	            $html .= 'New Member';
        	        }
        	        $html .= '<br />Name: '. $item['FirstName'] .' '. $item['LastName'];
        	        $html .= '<br />Email: '. $item['Email'];
        	        $html .= '<br />Phone: '. $item['Phone'];
        	        $html .= '<br />City: '. $item['City'];
        	        $html .= '<br />Country: '. $item['Country'];
        	        $html .= '<br />DOB: '. $item['DateOfBirth'];
        	        $html .= '<br />Sex: '. $item['Sex'];
        	        $html .= '<br />'. $item['MembershipType'];
        	        $html .= '<br />Monthly E-Newsletter: ';
        	        if ($item['NewsletterEmail'] == 'Y')
        	            $html .= 'Y';
                    else
        	            $html .= 'N';
        	        $html .= '<br />Printed Newsletter: ';
        	        if ($item['NewsletterPrint'] == 'Y') {
        	            $html .= 'Y';
        	            
           	            $fees += 10;
        	        }
        	        else
        	            $html .= 'N';
        	        $html .= '<br /><br /><strong>'. $applicant .' Fees: $'. $fees .'</strong></div>';
        	                        
        	        $ctr ++;
        	        $total_fees += $fees;
        		}
        
        		$html .= '<br /><br /><strong>Total Fees: $'. $total_fees .'</div>';
        		
        		$email = new Email();
        		
        		$email->setTo('membership@brokenriver.co.nz');
        //		$email->setTo('archaugust@yahoo.com');
        		$email->setFrom('noreply@brokenriver.co.nz');
        		$email->setSubject("Membership Application");
        		
        		$email->setBody($html);
        		$email->send();
        	
        		return true;
		    }
		    else
		    {
		        return "Invalid captcha.";
		    }
		}
		else 
		{
		    return "Please verify that you are not a robot.";
		}
		
	}

	public function ProcessPayment(SS_HTTPRequest $request) {
		$config = SiteConfig::current_site_config(); 
		$data = $request->postVars();
		$result = $request->getVar('result');
		
		$PxMode = ($config->PxDevMode) ? "uat" : "sec";
		$PxPay_Url    = "https://". $PxMode .".paymentexpress.com/pxaccess/pxpay.aspx";
		$PxPay_Userid = $config->PxPayUserId;
		$PxPay_Key    = $config->PxPayKey;

		$pxpay = new PxPay_Curl( $PxPay_Url, $PxPay_Userid, $PxPay_Key );

		if (!empty($result))
		{
			# this is a redirection from the payments page.
			$this->processResult($pxpay, $result);
		}
		else
		{
			# this is a post back -- redirect to payments page.
	
			$request = new PxPayRequest();

			$http_host   = getenv("HTTP_HOST");
			$request_uri = getenv("SCRIPT_NAME");
			$server_url  = "http://$http_host";
			$script_url = (version_compare(PHP_VERSION, "4.3.4", ">=")) ?"$server_url$request_uri" : "$server_url/$request_uri";

			# the following variables are read from the form
			$MerchantReference = 'Brokenriver.co.nz Online Payment';  
			$txnData1 = htmlspecialchars($data['Name']);
			$txnData2 = htmlspecialchars($data['Email']);
			$txnData3 = htmlspecialchars($data['MembershipType']);
			$AmountInput = htmlspecialchars($data['Total']);
			
			#Generate a unique identifier for the transaction
			$TxnId = uniqid("ID");
			
			#Set PxPay properties
			$request->setMerchantReference($MerchantReference);
			$request->setAmountInput($AmountInput);
			$request->setTxnData1($txnData1);
			$request->setTxnData2($txnData2);
			$request->setTxnData3($txnData3);
			$request->setTxnType("Purchase");
			$request->setCurrencyInput("NZD");
			$request->setEmailAddress($txnData2);
			$request->setUrlFail('https://brokenriver.co.nz/about-br/of-interest/membership/ProcessPayment');			# can be a dedicated failure page
			$request->setUrlSuccess('https://brokenriver.co.nz/about-br/of-interest/membership/ProcessPayment');			# can be a dedicated success page
			$request->setTxnId($TxnId);  
			
			#The following properties are not used in this case
			# $request->setEnableAddBillCard($EnableAddBillCard);    
			# $request->setBillingId($BillingId);
			# $request->setOpt($Opt);
			

			
			#Call makeRequest function to obtain input XML
			$request_string = $pxpay->makeRequest($request);

			#Obtain output XML
			$response = new MifMessage($request_string);
		
			#Parse output XML
			$url = $response->get_element_text("URI");
			$valid = $response->get_attribute("valid");
			
			#Redirect to payment page
			$this->redirect($url);
		}
		
	}

	public function processResult($pxpay, $result)
	{
		$enc_hex = $result;
		#getResponse method in PxPay object returns PxPayResponse object
		#which encapsulates all the response data
		$rsp = $pxpay->getResponse($enc_hex);
		
		# the following are the fields available in the PxPayResponse object
		$Success           = $rsp->getSuccess();   # =1 when request succeeds
		$AmountSettlement  = $rsp->getAmountSettlement();
		$AuthCode          = $rsp->getAuthCode();  # from bank
		$CardName          = $rsp->getCardName();  # e.g. "Visa"
		$CardNumber        = $rsp->getCardNumber(); # Truncated card number
		$DateExpiry        = $rsp->getDateExpiry(); # in mmyy format
		$DpsBillingId      = $rsp->getDpsBillingId();
		$BillingId    	 = $rsp->getBillingId();
		$CardHolderName    = $rsp->getCardHolderName();
		$DpsTxnRef	     = $rsp->getDpsTxnRef();
		$TxnType           = $rsp->getTxnType();
		$TxnData1          = $rsp->getTxnData1();
		$TxnData2          = $rsp->getTxnData2();
		$TxnData3          = $rsp->getTxnData3();
		$CurrencySettlement= $rsp->getCurrencySettlement();
		$ClientInfo        = $rsp->getClientInfo(); # The IP address of the user who submitted the transaction
		$TxnId             = $rsp->getTxnId();
		$CurrencyInput     = $rsp->getCurrencyInput();
		$EmailAddress      = $rsp->getEmailAddress();
		$MerchantReference = $rsp->getMerchantReference();
		$ResponseText		 = $rsp->getResponseText();
		$TxnMac            = $rsp->getTxnMac(); # An indication as to the uniqueness of a card used in relation to others
		
		if ($rsp->getSuccess() == "1")
		{
			$config = SiteConfig::current_site_config(); 

			// update member account
			$memberLeadId = Session::get('memberLeadId');
			$member = Membership::get()->byID($memberLeadId);
			$member->Payment = 'Paid Online - '. date('j M Y');
			$member->write();

			// email admin
			$email = new Email();
			
			$html = "<p>Membership Type: <br />". $member->MembershipType 
				."</p><p>Temporary Member ID: <br />". $member->MembershipNumber
				."</p><p>First Name: <br />". $member->FirstName
				."</p><p>Last Name: <br />". $member->LastName
				."</p><p>Email Address: <br />". $member->Email
				."</p><p>Phone: <br />". $member->Phone
				."</p><p>DPS Billing ID: <br />". $DpsBillingId 
				."</p><p>Billing ID: <br />". $BillingId
				."</p><p>DPS Transaction Reference: <br />". $DpsTxnRef
				."</p><p>Auth Code: <br />". $AuthCode ."</p>";

			$email->setTo('membership@brokenriver.co.nz');
	//		$email->setTo('archaugust@yahoo.com');
			$email->setFrom('noreply@brokenriver.co.nz');
			$email->setSubject("Online Payment");
			
			$email->setBody($html);
			$email->send();


			Session::set('ActionStatus', 'o-alert info');
			Session::set('ActionMessage', 'Payment processed.');

			$this->redirect('/thank-you');
		}
		else
		{
			Session::set('ActionStatus', 'o-alert error');
			Session::set('ActionMessage', 'Transaction has been declined.');

			$this->redirectBack();
		}
	}

}