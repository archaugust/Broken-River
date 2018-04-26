<% if $isLogged %>
<div class="c-member-menu">
	<div class="inner">
	<% with $LoggedMember %>
		Hi $FirstName!
	    <% if $Status == 'Inactive' %><b><a href="/members-area/Renew">Renew Membership</a></b><% end_if %>    
	<% end_with %>
        <a href="/members-area/">Accommodation</a>    
		<a href="/members-area/Profile">Profile</a>
		<a href="/members-area/password-change">Change Password</a>
		<a href="/members-area/Logout">Logout</a>
	</div>
</div>

<% end_if %>
