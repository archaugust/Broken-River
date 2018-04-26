<?php
 
class CustomSiteConfig extends DataExtension {
     
    private static $db = array(
		'HeaderContactDetails' => 'HTMLText',
		'FooterContactDetails' => 'HTMLText',
		'FooterAccomDetails' => 'HTMLText',
		'FooterOperatingHours' => 'HTMLText',
		'FacebookLink' => 'Varchar(250)',
		'InstagramLink' => 'Varchar(250)',
		'YoutubeLink' => 'Varchar(250)',
		'BankAccountNumber' => 'Varchar(250)',
		'CheckPayableTo' => 'Varchar(100)',
		'PostalAddress' => 'HTMLText',
        'PxDevMode' => 'Boolean',
		'PxPayUserId' => 'Varchar(100)',
		'PxPayKey' => 'Varchar(100)',
        'CaptchaSiteKey' => 'Varchar(100)',
        'CaptchaSecret' => 'Varchar(100)',
    );
	
	private static $has_one = array(
	);
 
    public function updateCMSFields(FieldList $fields) {
		
		$fields->addFieldToTab("Root.Header", new HTMLEditorField('HeaderContactDetails'));
		$fields->addFieldToTab("Root.Footer", new HTMLEditorField('FooterContactDetails'));
		$fields->addFieldToTab("Root.Footer", new HTMLEditorField('FooterAccomDetails', 'Footer Accommodation Details'));
		$fields->addFieldToTab("Root.Footer", new HTMLEditorField('FooterOperatingHours'));
		
		$fields->addFieldToTab("Root.Main", new textField('FacebookLink'));
		$fields->addFieldToTab("Root.Main", new textField('InstagramLink'));
		$fields->addFieldToTab("Root.Main", new textField('YoutubeLink'));
		$fields->addFieldToTab('Root.Main', new textField('CaptchaSiteKey', 'ReCaptcha Site Key'));
		$fields->addFieldToTab('Root.Main', new textField('CaptchaSecret', 'ReCaptcha Secret'));
		$fields->addFieldToTab('Root.Payments', new CheckboxField('PxDevMode', 'Development Mode'));
		$fields->addFieldToTab('Root.Payments', new textField('PxPayUserId', 'PxPay User ID'));
		$fields->addFieldToTab('Root.Payments', new textField('PxPayKey', 'PxPay Key'));
		$fields->addFieldToTab('Root.Payments', new textField('BankAccountNumber', 'Bank Account Number'));
		$fields->addFieldToTab('Root.Payments', new textField('CheckPayableTo', 'Check Payable To'));
		$fields->addFieldToTab('Root.Payments', new HTMLEditorField('PostalAddress', 'Postal Address'));
    }
}