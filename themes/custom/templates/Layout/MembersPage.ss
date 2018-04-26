<% include MembersMenu %>
<div class="c-members">
<div class="inner">
	<div class="content-container">
		<article>
			<div class="content o-members-page">
				<% if $isLogged %>
					<% with $LoggedMember %>
						<% if $Status == 'Inactive' %><h3 align="center"><a href="/members-area/Renew">Your membership status is currently inactive. Renew your membership here.</a></h3><br /><br /><% end_if %>
					<% end_with %>
					$ContentMembers 
				<% else %>
					<div align="center">$Content</div>
					<% include LoginForms %>
				<% end_if %>
			</div>
		</article>
	</div>
</div>

</div>