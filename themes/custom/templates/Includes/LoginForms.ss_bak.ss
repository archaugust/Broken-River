<div class="o-members-page-forms">
	<div class="o-layout">
		<div class="o-layout__item u-1/2">
			<form method="post" id="form-login-new">
				<h3>First Time Here?</h3>
				<p>Create an account below<br /><br />
				<label for="new-number">Membership Number <span class="u-orange">*</span></label>
				<input type="text" name="MembershipNumber" id="new-number" required="required" />
				<label for="new-email">Email <span class="u-orange">*</span></label>
				<input type="email" name="Email" id="new-email" required="required" />
				<label for="new-password">Password <span class="u-orange">*</span></label>
				<input type="password" name="Password" id="new-password" required="required" />
				<label for="new-password-2">Confirm Password <span class="u-orange">*</span></label>
				<input type="password" name="Password2" id="new-password-2" required="required" />
				<button class="button" type="submit">Create Account</button>
				</p>
				<p id="msgDivNew"></p>
			</form>
		</div><div class="o-layout__item u-1/2 u-bg-gray">
			<form action="{$Link}LoginMember" method="post" id="form-login-member">
				<h3>Existing Account Holders</h3>
				<p>Enter your login credentials below<br /><br />
				<label for="new-email">Email <span class="u-orange">*</span></label>
				<input type="email" name="Email" id="new-email" required="required" />
				<label for="new-password">Password <span class="u-orange">*</span></label>
				<input type="password" name="Password" id="new-password" required="required" />
				<button class="button" type="submit">Login</button>
				<br />
				<span class="small"><a class="small" href="/members-area/password-reset">Forgotten your password?</a></span>
				</p>
				<p id="msgDivMember"></p>
			</form>
		</div>
	</div>
</div>
