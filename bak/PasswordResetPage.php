<?php
class PasswordResetPage extends Page {

	private static $allowed_children = array ();
	
}
class PasswordResetPage_Controller extends Page_Controller {

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
			'PasswordReset'
	);

	public function init() {
		parent::init();
	}

	public function PasswordReset(SS_HTTPRequest $request) {
		$data = $request->postVars();

		// check if exists
		$member = Membership::get()->filter(array('Email' => $data['Email']));
		if ($member->exists()) {
//			$password = crypt($this->generateRandomString());
			$password = $this->generateRandomString();
			
			$member = $member->first();
			$member->Password = $password;
			$member->write();
			
			$html = 'Your new password is: <p>'. $password .'</p>';
			
			$email = new Email();
			
			//		$email->setTo('membership@brokenriver.co.nz');
			$email->setTo($data["Email"]);
			$email->setFrom('noreply@brokenriver.co.nz');
			$email->setSubject("Password Reset");
			
			$email->setBody($html);
			$email->send();
			
			return true;
		}
		else 
			return 'No account matching email address can be found.';
	}
	
	public function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		
		return $randomString;
	}
}