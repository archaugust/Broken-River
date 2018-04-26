<?php
class MembersPage extends Page {
	
	private static $db = array(
		'BannerPadding' => 'Boolean',
		'ContentMembers' => 'HTMLText'
	);

	private static $has_many = array( 
		'Slides' => 'Slide',
	);
	
	private static $allowed_children = array (
		'PasswordResetPage',
		'PasswordChangePage'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('ContentMembers', 'Content Members')->setRows(20), 'Metadata');
		
		return $fields;
	}
}
class MembersPage_Controller extends Page_Controller {

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
		'Profile',
		'ProfileEdit',
		'ProfileSave',
		'LoginMember',
		'Logout',
        'Renew',
	    'RenewUpdate',
	    'ProcessPayment'
	);

	public function init() {
		parent::init();
		
	}

	public function Profile() {
		return array();
	}

	public function ProfileEdit(SS_HTTPRequest $request) {
		$data = $request->getVars();
		$post = $request->postVars();

		if (Session::get('isLogged')) {
			$members = Membership::get();

			$member = $members->filter(array(
					'Email' => Session::get('email'),
			));
			$lead = $member->first();

			// no post
			if (empty($post["MembershipNumber"])) {

				// check if owner
				if ($lead->MembershipNumber == $data['member']) {
					$profile = new ArrayData(array(
						'Member' => $lead
					));
					Session::set('member_id', $lead->ID);
				}
				else {
					$profile = $members->filter(array(
							'LeadAccountNumber' => $lead->MembershipNumber,
							'MembershipNumber' => $data['member']
					));
					$member = $profile->first();
					$profile = new ArrayData(array(
						'Member' => $member
					));
					Session::set('member_id', $member->ID);
				}
			}
			else {
				// check if owner
				$owner = false;
				if ($lead->MembershipNumber == $post['MembershipNumber']) {
					$owner = true;
				}
				else {
					$profile = $members->filter(array(
							'LeadAccountNumber' => $lead->MembershipNumber,
							'MembershipNumber' => $post['MembershipNumber']
					));
					if ($profile->exists())
						$owner = true;
				}

				if ($owner) {
					// check for duplicate emails
					$duplicates = 0;
					
					foreach ($post['Members'] as $item) {
						$check = $members->filter(array(
							'Email' => $item['Email'],
							'MembershipNumber:StartsWith:not' => $lead->MembershipNumber
						));
						if ($check->exists())
							$duplicates++;
					}
					if ($duplicates) {
						return "Email address is already in use. Please use a unique email address.";
					}
					
					foreach ($post['Members'] as $item) {
					    if ($item['Email'] != $member->Email) {
					        // email admin
					        $email = new Email();
					        
					        $html = "Old email: ". $member->Email ."<br />New Email: ". $item['Email']; 
					        
					        $email->setTo('membership@brokenriver.co.nz');
					        //	        $email->setTo('archaugust@yahoo.com');
					        $email->setFrom('noreply@brokenriver.co.nz');
					        $email->setSubject("Email changed from ". $member->Email ." to ". $item['Email']);
					        
					        $email->setBody($html);
					        $email->send();
					    }

						$member = $members->filter(array(
							'MembershipNumber' => $post["MembershipNumber"]
						));
						$member = $member->first();
					
						$member->FirstName = $item['FirstName'];
						$member->LastName = $item['LastName'];
						$member->Email = $item['Email'];
						$member->Phone = $item['Phone'];
						$member->City = $item['City'];
						$member->Country = $item['Country'];
						$member->DateOfBirth = $item['DateOfBirth'];
						$member->Sex = $item['Sex'];
						$member->Occupation = $item['Occupation'];
						$member->Association = $item['Association'];
						$member->Skills = implode(', ', $item['Skills']);
						$member->OtherInfo = $item['OtherInfo'];

						$member->write();
					}

					$this->redirectBack();
					
				}

			}
		}

		return array(
			'Profile' => $profile
		);
	}

	public function ProfileSave(SS_HTTPRequest $request) {
		$data = $request->postVars();

		if (Session::get('isLogged')) {
			$members = Membership::get();
		}

		$this->redirectBack();
	}

	public function LoginMember(SS_HTTPRequest $request) {
		$data = $request->postVars();
		
		$member = Membership::get()->filter(array(
				'Email' => $data['Email'],
		))->sort("ID");

		if ($member->exists()) {
			$member = $member->first();
			// check status 
			if ($member->Status == 'Pending') {
				return 'Your account is still awaiting review. Please try again later.';
			}

			if ($member->Status == 'Inactive') {
//				return 'Your account is inactive. Please contact us to reactivate your account.';
			}
			
			// must not be non-lead family member
			if ($member->LeadAccountNumber && $member->LeadAccountNumber != $member->MembershipNumber)
				return 'Please login with the Family Lead Account.';
			
//			if (hash_equals($member->Password, crypt($data['Password'], $member->Password)) && $data['Password'] != '') {
			if ($data['Password'] == $member->Password && $data['Password'] != '') {
				// Password verified
				Session::set('isLogged', true);
				Session::set('email', $member->Email);
			}
			else {
				return 'Incorrect password.';
			}
			
			return true;
		}
		else 
			return 'Email address is not registered.';
	}

/*
	public function LoginNew(SS_HTTPRequest $request) {
		$data = $request->postVars();
		
		$member = Membership::get()->filter(array(
				'MembershipNumber' => $data['MembershipNumber'], 
				'Email' => $data['Email'],
		));
		
		if ($member->exists()) {
			$member = $member->first();
			// check status
			if ($member->Status == 'Pending') {
				return 'Account is still awaiting review. Please try again later.';
			}
			else {
				// create password, login member
				$member->Password = crypt($data['Password']);
				$member->write();
				Session::set('isLogged', true);
				Session::set('email', $member->Email);
				return true;
			}
		}
		else
			return 'No matching membership details found.';
	}
*/
	public function Renew(SS_HTTPRequest $request) {
	    $data = $request->getVars();
	    $post = $request->postVars();
	    
	    if (Session::get('isLogged')) {
	        $members = Membership::get();

	        $member = $members->filter(array(
	            'Email' => Session::get('email'),
	        ));
	        
	        $lead = $member->first();

	        $adult = 0;
	        $fees = 0;
	        
	        // check for sub accounts
	        $subs = $members->filter(array(
	            'LeadAccountNumber' => $lead->MembershipNumber,
	        ));
	        
	        // calculate fees
	        // lead account
	        switch ($lead->MembershipType) {
	            case 'Junior':
	                $fees += 35;
	                break;
	            default:
	            case 'Family':
	            case 'Adult':
	                $adult++;
	                if (count($subs) > 0 && $adult == 1)
	                   $fees += 75;
	                else 
	                   $fees += 150;
	                break;
	        }

            foreach ($subs as $sub) {
                switch ($sub->MembershipType) {
                    case 'Junior':
                        $fees += 35;
                        break;
                    default:
                    case 'Family':
                    case 'Adult':
                        $adult++;
                        if ($adult == 1)
                            $fees += 75;
                        else
                            $fees += 150;
                        break;
                }
            }
	    }
	    return array(
	        'Fees' => $fees,
	    );
	}
		
	public function RenewUpdate(SS_HTTPRequest $request) {
	    $post = $request->postVars();
	    
	    if (Session::get('isLogged') && $request->isAjax() && $request->isPost()) {
	        $member = Membership::get()->byID($post['id']);
	        
	        $member->MembershipType = $post['membership-type'];
	        $member->KeyLocker = $post['key-locker'];
	        $member->BootLocker = $post['boot-locker'];
	        $member->AllSeasonPass = $post['all-season-pass'];
	        
	        $member->write();
	    }
	    return $member->ID;
	}
	
    public function Logout() {
		Session::set('isLogged', false);
		
		$this->redirectBack();
	}
	
	public function LoggedMember() {
		if (Session::get('isLogged')) {
			$member = Membership::get()->filter(array(
					'Email' => Session::get('email'),
			));
			return $member->first();
		}
	}

	public function LoggedMemberFamily() {
		if (Session::get('isLogged')) {
			$members = Membership::get();
			$member = $members->filter(array(
					'Email' => Session::get('email'),
			));
			$lead = $member->first();
			
			$family = $members->filter(array(
					'LeadAccountNumber' => $lead->MembershipNumber,
//					'MembershipNumber:StartsWith' => $lead->MembershipNumber
			));
			
			if ($family->exists())
				return $family;
		}
	}

	public function TotalSubs() {
	    if (Session::get('isLogged')) {
	        $members = Membership::get();
	        $member = $members->filter(array(
	            'Email' => Session::get('email'),
	        ));
	        $lead = $member->first();
	        
	        $family = $members->filter(array(
	            'LeadAccountNumber' => $lead->MembershipNumber,
	            //					'MembershipNumber:StartsWith' => $lead->MembershipNumber
	        ));
	        
	        $adult = 0;
	        $junior = 0;
	        foreach ($family as $member) {
	            if ($member->MembershipType != "Junior") 
	                $adult ++;
	            else
	                $junior ++;
	        }
	        return new ArrayData(['Adult' => $adult, 'Junior' => $junior]);
	    }
	}

	public function hasSkill($skill) {
		$member_id = Session::get("member_id");
		$members = Membership::get()->filter(array(
			'ID' => $member_id
		));
		$member = $members->first();
		$skills = explode(", ", $member->Skills);

		if (in_array($skill, $skills))
			return true;
		else
			return false;
	}

	public function hideReports() {
		return true;
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
	        $MerchantReference = 'Brokenriver.co.nz Membership Renewal Payment';
	        $txnData1 = htmlspecialchars($data['Name']);
	        $txnData2 = htmlspecialchars($data['Email']);
	        $txnData3 = htmlspecialchars($data['Ids']);
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
	        $request->setUrlFail('https://brokenriver.co.nz/members-area/ProcessPayment');			# can be a dedicated failure page
	        $request->setUrlSuccess('https://brokenriver.co.nz/members-area/ProcessPayment');			# can be a dedicated success page
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
	        
	        // update member accounts
	        foreach (explode(',',$TxnData3) as $member) {
	            $member = Membership::get()->byID($member);
	            $member->Payment = 'Paid Online - DPS Txn Ref: '. $DpsTxnRef .' - '. date('j M Y');
	            $member->write();
	        }
	        
	        $accounts = explode(',', $TxnData3); 
	       
	        // email admin
	        $email = new Email();
	        
	        $html = "<p>DPS Transaction Reference: <br />". $DpsTxnRef
	        ."</p><p>Auth Code: <br />". $AuthCode ."</p><br />";
	        foreach ($accounts as $account) {
	            $html .= "<p><b>Account(s):</b><p>Name: <br />". $member->FirstName ." ". $member->LastName 
	            ."</p><p>Membership Number: <br/>". $member->MembershipNumber
	            ."</p><p>Membership Type: <br />". $member->MembershipType
	            ."</p><p>Email Address: <br />". $member->Email
	            ."</p><p>Phone: <br />". $member->Phone
	            ."</p>";
                ;
	        }
	        
	        $email->setTo('membership@brokenriver.co.nz');
//	        $email->setTo('archaugust@yahoo.com');
	        $email->setFrom('noreply@brokenriver.co.nz');
	        $email->setSubject("Broken River Membership Renewal Fees Payment Confirmation");
	        
	        $email->setBody($html);
	        $email->send();
	        

	        // email member
	        $email = new Email();
	        
	        $html = "<p>Hi ". $member->FirstName .",</p><p>Your payment has been processed.</p><p>Membership renewal is subject to approval by the Club Committee or Management. Please allow up to 5 weeks for your application to be processed (longer during Christmas holidays) before members' discounted lift/accommodation rates will apply. Broken River Ski Club reserves the right to decline any application or to terminate membership of any member found to be violating club terms &amp; conditions. Membership fees and season passes are non-refundable unless new membership application is declined then a full refund will apply.</p><br />";
	        foreach ($accounts as $account) {
	            $html .= "<p><b>Account(s):</b><p>Name: <br />". $member->FirstName ." ". $member->LastName
	            ."</p><p>Membership Number: <br/>". $member->MembershipNumber
	            ."</p><p>Membership Type: <br />". $member->MembershipType
	            ."</p><p>Email Address: <br />". $member->Email
	            ."</p><p>Phone: <br />". $member->Phone
	            ."</p><p>Kind regards, <br />Broken River Team</p>";
	            ;
	        }
	        
	        $email->setTo($member->Email);
//	        $email->setTo('archaugust@yahoo.com');
	        $email->setFrom('noreply@brokenriver.co.nz');
	        $email->setSubject("Broken River Membership Renewal Fees Payment Confirmation");
	        
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