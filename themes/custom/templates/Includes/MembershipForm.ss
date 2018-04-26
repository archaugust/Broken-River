
<form action="{$Link}Register" method="post" id="form-register" class="u-1/1">
<input type="hidden" name="RegistrationFee" value="$SiteConfig.RegistrationFee" />
<input type="hidden" name="AnnualAdultDiscounted" value="$SiteConfig.AnnualAdultDiscounted" />
<input type="hidden" name="AnnualAdult" value="$SiteConfig.AnnualAdult" />
<input type="hidden" name="AnnualJunior" value="$SiteConfig.AnnualJunior" />
<input type="hidden" name="BootLocker" value="$SiteConfig.BootLocker" />
<input type="hidden" name="KeyLocker" value="$SiteConfig.KeyLocker" />
<input type="hidden" name="AllSeasonPassAdult" value="$SiteConfig.AllSeasonPassAdult" />
<input type="hidden" name="AllSeasonPassJunior" value="$SiteConfig.AllSeasonPassJunior" />
<div class="o-new-account">
	<div class="o-membership-form">
		<div class="u-1/1">
			<div class="text-center">
				<h4>WHAT WOULD YOU LIKE TO DO?</h4>
				<input type="hidden" id="form_membershipType" name="RegistrationType" value="Individual">
				<input class="o-form-membership-type" type="hidden" name="Members[0][MembershipType]" />
				<div class="row-custom">
					<div class="col-50">
						<a href="#form-register-mid" class="button show-registration-form">Apply for Membership</a>
						<div>(New members only)</div>
					</div><div class="col-50">
						<a class="button" href="/members-area/">Renew Membership</a><br />
						<div>(Current members with <br />online account only)</div>
					</div>
				</div>
				<div>If you are an <b>Associate</b> or <b>Veteran</b> and would like to renew to a full/active membership, please contact <a href="mailto:membership@brokenriver.co.nz">membership@brokenriver.co.nz</a> for renewal of membership.</div>
				<div>If you are a <b>current member but don't have an online account</b>, please contact us at <a href="mailto:membership@brokenriver.co.nz">membership@brokenriver.co.nz</a> and we'll help you create an account.</div>
			</div> 
		</div>
	</div>
	<div id="form-register-main">
		<div class="o-membership-form">
			<div class="u-1/1"><strong><span class="family-only hidden">LEAD </span>APPLICANT</strong>
				<input type="hidden" class="o-new" name="Members[0][New]" id="Form_MembershipForm_New_1" value="New" />
				<input class="o-membership-number hidden" type="text" name="Members[0][MembershipNumber]" placeholder="Enter your membership number" />
			</div><div class="u-1/4">
				<label for="form_fname"><span>1.</span> First Name *</label>
				<input class="required o-form-fname" type="text" name="Members[0][FirstName]" required="required" />
			</div><div class="u-1/4">
				<label for="form_lname"><span>2.</span> Last Name *</label>
				<input class="required o-form-lname" type="text" name="Members[0][LastName]" id="form_lname" required="required" />
			</div><div class="u-1/4">
				<label for="form_email"><span>3.</span> Email *</label>
				<input type="email" class="o-form-email" name="Members[0][Email]" id="form_email" required="required" />
			</div><div class="u-1/4">
				<label for="form_phone"><span>4.</span> Phone</label>
				<input type="text" class="o-form-phone" name="Members[0][Phone]" id="form_phone" />
			</div><div class="u-1/4">
				<label for="form_city"><span>5.</span> City Where You Live</label>
				<input type="text" class="o-form-city" name="Members[0][City]" id="form_city" />
			</div><div class="u-1/4" id="form-register-mid">
				<label for="form_country"><span>6.</span> Country</label>
				<input type="text" class="o-form-country" name="Members[0][Country]" id="form_country" />
			</div><div class="u-1/4">
				<label for="form_dob"><span>7.</span> Date of Birth *</label>
				<input type="text" class="form_dob required o-form-dob" name="Members[0][DateOfBirth]" id="form_dob" required="required" />
			</div><div class="u-1/4">
				<label><span>8.</span> Sex</label>
				<div class="u-radio o-form-sex">
				<span class='radio'>
				<input type="radio" name="Members[0][Sex]" id="form_sex_1" value="M" />
				<label for="form_sex_1"><span></span> M</label>
				</span>
				<span class='radio'>
				<input type="radio" name="Members[0][Sex]" id="form_sex_2" value="F" />
				<label for="form_sex_2"><span></span> F</label>
				</span>
				</div>
			</div><div class="u-1/2">
		        <label for="form_occupation"><span>9.</span> Occupation</label>
		        <input name="Members[0][Occupation]" class="o-form-occupation" id="form_occupation" />
		    </div><div class="u-1/1">
				<label for="form_association"><span>10.</span> Previous Association with Broken River. Have you skied or boarded at BR? Do you know anyone in the club? How did you contact us?</label>
				<textarea name="Members[0][Association]" class="o-form-association" id="form_association"></textarea>
			</div><div class="u-1/1">
				<label><span>11.</span> Useful Skills. Our club benefits greatly from the input of our members and their skills. Please select one or more skills that apply.</label>
				<div class="o-checkboxes">
				<div class="u-1/4">
					<input type="checkbox" name="Members[0][Skills][]" value="Administration" id="skills_Administration" /><label for="skills_Administration"> Administration </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Carpentry" id="skills_Carpentry" /><label for="skills_Carpentry"> Carpentry </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Electrical" id="skills_Electrical" /><label for="skills_Electrical"> Electrical </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Architecture" id="skills_Architecture" /><label for="skills_Architecture"> Architecture </label><br />
				</div><div class="u-1/4">
					<input type="checkbox" name="Members[0][Skills][]" value="Plumbing" id="skills_Plumbing" /><label for="skills_Plumbing"> Plumbing </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Painting / Decorating" id="skills_Painting" /><label for="skills_Painting"> Painting / Decorating</label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Communications" id="skills_Communications" /><label for="skills_Communications"> Communications </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Sewing" id="skills_Sewing" /><label for="skills_Sewing"> Sewing </label><br />
				</div><div class="u-1/4">
					<input type="checkbox" name="Members[0][Skills][]" value="Engineering" id="skills_Engineering" /><label for="skills_Engineering"> Engineering </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Computers / IT" id="skills_Computers" /><label for="skills_Computers"> Computers / IT </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Electronics" id="skills_Electronics" /><label for="skills_Electronics"> Electronics </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Signwriting" id="skills_Signwriting" /><label for="skills_Signwriting"> Signwriting </label>
				</div><div class="u-1/4">
					<input type="checkbox" name="Members[0][Skills][]" value="Draughting" id="skills_Draughting" /><label for="skills_Draughting"> Draughting </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="First Aid / Medic" id="skills_First-Aid" /><label for="skills_First-Aid"> First Aid / Medic </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Construction" id="skills_Construction" /><label for="skills_Construction"> Construction </label><br />
					<input type="checkbox" name="Members[0][Skills][]" value="Marketing" id="skills_Marketing" /><label for="skills_Marketing"> Marketing </label>
				</div><div class="u-1/4">
					<input type="checkbox" name="Members[0][Skills][]" value="HT Licence" id="skills_HT-Licence" /><label for="skills_HT-Licence"> HT Licence </label>
				</div><div class="u-1/2">
					<input type="checkbox" name="Members[0][Skills][]" value="Heavy Machinery experience / licence" id="skills_Heavy-Machinery" /><label for="skills_Heavy-Machinery"> Heavy Machinery experience / licence </label>
				</div>			
				</div>
		 	</div><div class="u-1/1">
				<label><span>12.</span> Boot Locker</label>
				<div><input type="checkbox" class="o-form-boot-locker" name="Members[0][BootLocker]" id="form_boot_locker_1" value="Y" /><label for="form_boot_locker_1"> Add $<div class="price-boot-locker"></div></label></div>
			</div><div class="u-1/1">
				<label><span>13.</span> Ski Locker</label>
				<div><input type="checkbox" class="o-form-key-locker" name="Members[0][KeyLocker]" id="form_key_locker_1" value="Y" /><label for="form_key_locker_1"> Add $<div class="price-key-locker"></div></label></div>
			</div><div class="u-1/1">
				<label><span>14.</span> Season Pass</label>
				<div><input type="checkbox" class="o-form-all-season-pass" name="Members[0][AllSeasonPass]" id="form_all_season_pass_1" value="Y" /><label for="form_all_season_pass_1"> Add $<div class="price-all-season-pass-adult"></div> if adult, $<div class="price-all-season-pass-junior"></div> if junior</label></div>
			</div><div class="u-1/1">
				<label for="form_other"><span>15.</span> Other Pertinent Info. Anything else relating to this application that you think we should know about?</label>
				<textarea name="Members[0][OtherInfo]" class="o-form-other" id="form_Other"></textarea>
			</div><div class="u-1/1">
				<div>
					As a Club Member you will receive e-newsletters. Your email will be used by the Club solely for the purposes of marketing in relation to Club activities and local information relating to snow sports. If you have family members joining we would appreciate receiving each individual person's email address.
				</div>
			</div>
		</div>

		<div id="additional-forms"></div>
		<div class="o-membership-form">		
			<div class="u-1/1">
				<button class="button o-pre-submit" type="button">Done</button> <a class="button" id="add-more">ADD ANOTHER APPLICANT</a>
			</div>
		</div>
	</div>
</div>
</div>
<div class="o-confirmation hidden">
	<div class="o-membership-form">
		<div class="u-1/1">
		<hr />
		<strong class="orange">SUMMARY</strong>
		</div>
	</div>
	<div class="o-membership-form o-summary"></div>
	<div class="o-membership-form">
		<div class="u-1/1">
			<hr />
			<h2>CONFIRMATION & PAYMENT</h2>
			<p>Please check the summary information above is correct before proceeding. Scroll back up to make corrections to the form as required and hit the 'Done' button again to update changes.</p>
			<p>Membership is subject to approval by the Club Committee or Management. Please allow up to 5 weeks for your application to be processed (longer during Christmas holidays) before members' discounted lift/accommodation rates will apply. Broken River Ski Club reserves the right to decline any application or to terminate membership of any member found to be violating club terms &amp; conditions. Membership fees and season passes are non-refundable unless new membership application is declined then a full refund will apply.</p>
				<input type="checkbox" name="terms" id="form_terms" value="Y" required />
				<label for="form_terms"><span></span> I have read and understood Broken River's <a href="/terms-and-conditions/" target="_blank">Terms & Conditions</a>.</label>
			<br />
			<div class="g-recaptcha" data-sitekey="6LdENyAUAAAAAOvKDVlvC8ictu7giamnfH5GfULi"></div>
			<button class="button o-submit-button" type="submit">Submit Application</button>
		</div>
	</div>
</div>
</form>
<div class="o-success o-membership-form hidden">
	<div class="u-1/1">
		<p><br /><i class="u-orange">Woohoo! Welcome to the BR Family!</i> Your application is subject to approval and payment. See below a list of payment options. If you're paying via credit card, go there now (don't leave this page) by hitting the 'Pay Now' button.</p>
		<hr /><br />
		<h2>PAYMENT OPTIONS</h2>
	</div><div class="o-layout__item u-1/3">
		<strong>CREDIT CARD</strong>
		<p>You'll be taken to another secure payment page and asked to enter your credit card details.</p>
		<p><strong>Note that your payment will have a surcharge of 2.5% added to the above fees.</strong></p>
		<form action="{$Link}ProcessPayment" method="post" id="form-payment" class="u-1/1">
			<input type="hidden" id="px_name" name="Name" />
			<input type="hidden" id="px_email" name="Email" />
			<input type="hidden" id="px_membership_type" name="MembershipType" />
			<input type="hidden" id="px_total" name="Total" />
			<button type="submit" class="button">Pay Now</button>
		</form>
	</div><div class="o-layout__item u-1/3">
		<strong>ONLINE BANK TRANSFER</strong>
		<p>Just head over to your own online banking page and make a payment to bank account: {$SiteConfig.BankAccountNumber}.</p> <p>Please include first initial and surname of the Lead Account person and 'fees' as reference so we can record your payment.</p>
	</div><div class="o-layout__item u-1/3">
		<strong>CHEQUE</strong>
		<p>Please make cheques payable to {$SiteConfig.CheckPayableTo}, add $1 for bank fees and post to:<br />
		$SiteConfig.PostalAddress
		</p>
	</div>
</div>
</div>
