<% include MembersMenu %>
<div class="c-members">
<div class="inner">
	<div class="content-container">
		<article>
			<div class="content o-members-page">
				<% if $isLogged %>
					<h2>Profile</h2>
					<% with $LoggedMember %>
						<table style="width: 100%">
							<tr>
								<td width="150">Membership Type</td>
								<td>$MembershipType</td>
							</tr>
							<tr>
								<td>Membership Number</td>
								<td>$MembershipNumber</td>
							<tr>
								<td>Status</td>
								<td>$Status</td>
							</tr>
							<tr>
								<td>First Name</td>
								<td>$FirstName</td>
							</tr>
							<tr>
								<td>Last Name</td>
								<td>$LastName</td>
							</tr>
							<tr>
								<td>Email</td>
								<td>$Email</td>
							</tr>
							<tr>
								<td>Phone</td>
								<td>$Phone</td>
							</tr>
							<tr>
								<td>City</td>
								<td>$City</td>
							</tr>
							<tr>
								<td>Country</td>
								<td>$Country</td>
							</tr>
							<tr>
								<td>Date of Birth</td>
								<td>$DateOfBirth.Long</td>
							</tr>
							<tr>
								<td>Sex</td>
								<td>$Sex</td>
							</tr>
							<tr>
								<td>Occupation</td>
								<td>$Occupation</td>
							</tr>
							<tr>
								<td>Association</td>
								<td>$Association</td>
							</tr>
							<tr>
								<td>Skills</td>
								<td>$Skills</td>
							</tr>
							<tr>
								<td>Key Locker</td>
								<td>$KeyLocker</td>
							</tr>
							<tr>
								<td>Boot Locker</td>
								<td>$BootLocker</td>
							</tr>
							<tr>
								<td>All Season Pass</td>
								<td>$All Season Pass</td>
							</tr>
							<tr>
								<td>Other Info</td>
								<td>$OtherInfo</td>
							</tr>
						</table>
						<a href="/members-area/ProfileEdit?member=$MembershipNumber">Edit Profile</a>
						<br />
					<% end_with %>
					<% if $LoggedMemberFamily %>
					<br />
					<h2>Family Members</h2>
						<% loop $LoggedMemberFamily %>
							<table style="width: 100%">
								<tr>
									<td width="150">Membership Type</td>
									<td>$MembershipType</td>
								</tr>
								<tr>
									<td>Status</td>
									<td>$Status</td>
								</tr>
								<tr>
									<td>First Name</td>
									<td>$FirstName</td>
								</tr>
								<tr>
									<td>Last Name</td>
									<td>$LastName</td>
								</tr>
								<tr>
									<td>Email</td>
									<td>$Email</td>
								</tr>
								<tr>
									<td>Phone</td>
									<td>$Phone</td>
								</tr>
								<tr>
									<td>City</td>
									<td>$City</td>
								</tr>
								<tr>
									<td>Country</td>
									<td>$Country</td>
								</tr>
								<tr>
									<td>Date of Birth</td>
									<td>$DateOfBirth.Long</td>
								</tr>
								<tr>
									<td>Sex</td>
									<td>$Sex</td>
								</tr>
								<tr>
									<td>Occupation</td>
									<td>$Occupation</td>
								</tr>
								<tr>
									<td>Association</td>
									<td>$Association</td>
								</tr>
								<tr>
									<td>Skills</td>
									<td>$Skills</td>
								</tr>
								<tr>
									<td>Key Locker</td>
									<td>$KeyLocker</td>
								</tr>
								<tr>
									<td>Boot Locker</td>
									<td>$BootLocker</td>
								</tr>
								<tr>
									<td>All Season Pass</td>
									<td>$All Season Pass</td>
								</tr>
								<tr>
									<td>Other Info</td>
									<td>$OtherInfo</td>
								</tr>
							</table>
							<a href="/members-area/ProfileEdit?member=$MembershipNumber">Edit Profile</a>
							<br />
						<% end_loop %>
					<% end_if %>
				<% else %>
					<div align="center">$Content</div>
					<% include LoginForms %>
				<% end_if %>
			</div>
		</article>
		
	</div>
</div>

</div>