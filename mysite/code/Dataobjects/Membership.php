<?php
Class Membership extends DataObject {
	
	private static $db = array(
		'MembershipType' => 'Varchar(20)',
		'MembershipNumber' => 'Varchar',
		'LeadAccountNumber' => 'Varchar',
		'LeadAccountId' => 'Int',
		'Status' => 'Varchar',
		'FirstName' => 'Varchar',
		'LastName' => 'Varchar',
		'Email' => 'Varchar',
		'Phone' => 'Varchar',
		'City' => 'Varchar',
		'Country' => 'Varchar',
		'DateOfBirth' => 'Date',
		'Sex' => 'Varchar(1)',
	    'Occupation' => 'Varchar',
		'Association' => 'Text',
		'Skills' => 'Text',
		'OtherInfo' => 'Text',
//		'NewsletterEmail' => 'Varchar(1)',
//		'NewsletterPrint' => 'Varchar(1)',
        'KeyLocker' => 'Varchar(1)',
	    'BootLocker' => 'Varchar(1)',
	    'AllSeasonPass' => 'Varchar(1)',
	    'Credits' => 'Int',
		'Password' => 'Varchar(100)',
		'Payment' => 'Varchar(100)'
	);

	private static $default_sort = 'ID ASC';
	
	private static $summary_fields = array (
			'MembershipNumber' => 'Membership Number',
			'LeadAccountNumber' => 'Lead Account',
			'MembershipType' => 'Membership Type',
			'LastName' => 'Last Name',
			'FirstName' => 'First Name',
    	    'Status' => 'Status',
    	    'Email' => 'Email',
			'Phone' => 'Phone',
			'City' => 'City',
			'Country' => 'Country',
			'DateOfBirth' => 'Date Of Birth',
			'Payment' => 'Payment',
			'Sex' => 'Sex',
	        'Occupation' => 'Occupation',
//			'NewsletterEmail' => 'Comm Email',
//			'NewsletterPrint' => 'Comm Print',
    	    'KeyLocker' => 'Ski Locker',
    	    'BootLocker' => 'Boot Locker',
    	    'AllSeasonPass' => 'Season Pass',
    	    'Credits' => 'Credits ($)',
	);
	
	public function getCMSFields() {
		
		$fields = FieldList::create(
				DropdownField::create('MembershipType', 'Membership Type', array(
						'Family' => 'Family',
						'Adult' => 'Adult',
						'Junior' => 'Junior',
						'Associate' => 'Associate',
						'Veteran' => 'Veteran',
				        'Life Member' => 'Life Member',
				        'Founding Member' => 'Founding Member'
				)),
				TextField::create('MembershipNumber', 'Membership Number'),
				TextField::create('LeadAccountNumber', 'Lead Account Number'),
				OptionsetField::create('Status','Status', array(
						'Pending' => 'Pending',
						'Active' => 'Active',
						'Inactive' => 'Inactive'
				)),
				TextField::create('FirstName', 'First Name'),
				TextField::create('LastName', 'Last Name'),
				TextField::create('Email', 'Email'),
				TextField::create('Phone', 'Phone'),
				TextField::create('City', 'City'),
				TextField::create('Country', 'Country'),
				DateField::create('DateOfBirth','Date of Birth')->setConfig('showcalendar', true),
				OptionsetField::create('Sex','Sex', array(
						'M' => 'M',
						'F' => 'F'
				)),
	       	    TextField::create('Occupation', 'Occupation'),
    		    TextareaField::create('Association','Association'),
				TextareaField::create('Skills','Skills'),
				TextareaField::create('OtherInfo','Other Info'),
    		    OptionsetField::create('KeyLocker','Ski Locker', array(
    		        'Y' => 'Y',
    		        'N' => 'N'
    		    )),
    		    OptionsetField::create('BootLocker','Boot Locker', array(
    		        'Y' => 'Y',
    		        'N' => 'N'
    		    )),
    		    OptionsetField::create('AllSeasonPass','Season Pass', array(
    		        'Y' => 'Y',
    		        'N' => 'N'
    		    )),
		        TextField::create('Credits', 'Credits ($)'),
    		    HiddenField::create('Password','Password')
			);
				
		return $fields;
	}

	function onAfterWrite(){
		parent::onAfterWrite();
		
		if($this->isChanged("Status") && $this->Status == 'Active' ){
			
			// check if Lead account
			$leadAccountId = $this->LeadAccountId;
			if ($leadAccountId) {

				$children = Membership::get()->filter(array(
					"LeadAccountId" => $leadAccountId
				));

				if ($children->Count() > 0) {
					foreach ($children as $child) {
						$child->Status = 'Active';
						$child->LeadAccountNumber = $this->MembershipNumber;
						$child->write();
					}
				}

				// email member
				$email = new Email();
				
				$html = "<p>Hi ". $this->FirstName ."!</p>
					<p>You membership account has been activated. You can now login at the <a href='http://brokenriver.co.nz/members-area/'>Members Area</a>.</p>
					<p>When logging in for the first time, please fill out the form under <strong>'First Time Here?'</strong> with your:</p>
					<p>Membership Number: ". $this->MembershipNumber ."<br />
					Email: ". $this->Email ."</p>
					<p>and add your new password.</p> 
					<p>After completing this, in the future you can simply login with your email and password.</p>
					<p>Welcome to the Broken River family!</p>
					<p>The Broken River Team</p>";

		//		$email->setTo($member->Email);
				$email->setTo('archaugust@yahoo.com');
				$email->setFrom('noreply@brokenriver.co.nz');
				$email->setSubject("Your Broken River membership account has been activated");
				
				$email->setBody($html);
				$email->send();

				$this->redirectBack();
			}
		}
	}	
}
