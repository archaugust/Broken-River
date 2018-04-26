<?php 

/*
* test details:
*
* bd3eec90bba2e4126dc72f712905fc39-us9
* 35dea6e75e
*/

class SubscriptionForm extends Form {
	
	public function __construct($controller, $name) {
		$fields = new FieldList(
			EmailField::create("Email")->setAttribute('Placeholder','Enter your email address here')->setTitle('Enter your email address here'),
			HiddenField::create('MailingList')->setAttribute('value', '87ea469fa9')
			/*DropdownField::create(
				'MailingList',
				'MailingList',
				array(
					'35dea6e75e' => 'test'
				)
			)*/
		);
		$actions = new FieldList(FormAction::create("doSubscription")->setTitle("Sign Up"));
		
		parent::__construct($controller, $name, $fields, $actions, new RequiredFields("Name", "Email"));
	}
	
	public function doSubscription($data, Form $form){
		$MailChimp = new \Drewm\MailChimp('74fce20c7ed436a9b80a5255fa0578bc-us1');
		$result = $MailChimp->call('lists/subscribe', array(
					'id'                => $data['MailingList'],
					'email'             => array('email'=>$data['Email']),
					//'merge_vars'        => array('NAME'=>$data['Name']),
					'double_optin'      => false,
					'update_existing'   => true,
					'replace_interests' => false,
					'send_welcome'      => false,
				));
		Session::set("subscriptionSent", true);
		Controller::curr()->redirectBack();
	}
	
}