<?php 
class MembershipAdmin extends ModelAdmin {

	private static $menu_title = 'Membership';

	private static $url_segment = 'membership';

	private static $managed_models = array (
			'Membership'
	);
	
	private static $menu_icon = 'themes/custom/images/icon-members.png';
}
?>