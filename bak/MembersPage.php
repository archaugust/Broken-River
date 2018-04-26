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
//			'LoginNew',
			'Logout'
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
				return 'Your account is inactive. Please contact us to reactivate your account.';
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
					'MembershipNumber:StartsWith:not' => $lead->MembershipNumber
			));
			
			if ($family->exists())
				return $family;
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
}