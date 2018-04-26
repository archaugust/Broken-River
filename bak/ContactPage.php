<?php
class ContactPage extends Page {
	
	public static $db = array(
		'Email' => 'Varchar(50)',
		'Reply' => 'Varchar(500)',
		'ContactDetails' => 'HTMLText'
	);
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', new EmailField('Email'), 'Content');
		$fields->addFieldToTab('Root.Main', new TextareaField('Reply'), 'Content');
		$fields->addFieldToTab('Root.Main', new HTMLEditorField('ContactDetails'));
		
		$fields->removeByName('SideImage');
		
		return $fields;
	}
}
class ContactPage_Controller extends Page_Controller {
	
	public static $mail_sent = false;
	
	public static $allowed_actions = array('ContactForm', 'SubscriptionForm');
	
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
	
	public function ContactForm() {
		
		$fields = new FieldList(
			TextField::create("Name"),
			EmailField::create("Email"),
			TextField::create("Subject"),
			TextareaField::create("Message")
		);
		$actions = new FieldList(FormAction::create("sendMail")->setTitle("Send"));
		$form = new Form($this, "ContactForm", $fields, $actions, new RequiredFields("Name", "Email", "Phone"));
		
		$form->enableSpamProtection()
			->fields()->fieldByName('Captcha')
			->setTitle("Spam protection")
			->setDescription("");
		return $form;
	}
	
	public function sendMail($data, Form $form){
		$headers = 'From: '.$data['Email'];
		$reply_headers = 'From: '.$this->Email;
		$message = $data['Message']. "\n\nFrom ".$data['Name'];
		
		mail($this->Email, 'enquiry via Broken River website', $message, $headers); 
		mail($data['Email'], $data['Subject'], $this->Reply, $reply_headers); 
		
		ContactPage_Controller::$mail_sent = true;
		return $this->render();
	}
	
	public function getMailSent(){
		if (ContactPage_Controller::$mail_sent){
			return true;
		}else {
			return false;
		}
		
	}

}