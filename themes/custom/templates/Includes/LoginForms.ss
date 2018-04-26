<div class="o-members-page-forms">
	<div class="o-form u-1/2 u-bg-gray">
		<form action="{$Link}LoginMember" method="post" id="form-login-member">
			<h3>Member Login</h3>
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
