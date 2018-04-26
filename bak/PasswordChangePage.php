<?php
class PasswordChangePage extends Page {

	private static $allowed_children = array ();
	
}
class PasswordChangePage_Controller extends Page_Controller {

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
			'PasswordChange'
	);

	public function init() {
		parent::init();
	}

	public function PasswordChange(SS_HTTPRequest $request) {
		if (Session::get('isLogged')) {
			$data = $request->postVars();
			
			// check password
			if ($data['Password'] == $data['Password2'] && $data['Password'] != '') {
				$member = Membership::get()->filter(array(
						'Email' => Session::get('email'),
				));
				$member = $member->first();
				
//				$password = crypt($data['Password']);
				$password = $data['Password'];
				$member->Password = $password;
				$member->write();
				
				return true;
			}
			else 
				return 'Passwords do not match.';
		}
		else 
			return 'Please login.';
	}
}