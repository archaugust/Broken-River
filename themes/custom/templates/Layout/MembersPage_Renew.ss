<% include MembersMenu %>
<div class="c-members">
<div class="inner">
	<div class="content-container">
		<article>
			<div class="content">
				<% if $isLogged %>
					<h2>Renew Membership</h2>
					<hr />
					<div class="o-membership-form o-summary">
					<% with $LoggedMember %><div class="u-1/4 account">
						<strong class="u-uppercase">Lead Account</strong><br />
						<input type="hidden" class="account-id" value="$ID" />
						<input type="hidden" class="form-membership-type" value="" />
						<input type="hidden" class="date-of-birth" value="$DateOfBirth" />
            			<br />$FirstName $LastName
						<br /><span class="membership-type">$MembershipType</span>
						<br />$Status
						<% if $Credits > 0 %><br />Credits: $<span class="credits">$Credits</span><% end_if %>
            			<% if $Status != "Active" %>
            				<hr />
            				Fees:<br />
	            			Annual Fee:  
	            			<% if $MembershipType == "Adult" || $MembershipType == "Family" %>
	            				<% if $Top.LoggedMemberFamily %>
	            					$<span class="annual-fee">$SiteConfig.AnnualAdultDiscounted</span>
	            				<% else %>
	            					$<span class="annual-fee">$SiteConfig.AnnualAdult</span>
	            				<% end_if %>
	            			<% else_if $MembershipType == "Junior" %>
	            				$<span class="annual-fee">$SiteConfig.AnnualJunior</span>
	            			<% else_if $MembershipType == "Associate" %>
	            				$<span class="annual-fee">$SiteConfig.AnnualAssociate</span> 
	            			<% else_if $MembershipType == "Veteran" %>
	            				$<span class="annual-fee">$SiteConfig.AnnualVeteran</span> 
	            			<% end_if %>
	            			<br />
            				<label class="renew"><input class="addition" type="checkbox" name="boot-locker" value="1" <% if BootLocker == "Y" %>checked<% end_if %> /> Boot locker (add $$SiteConfig.BootLocker)</label><br />
            				<label class="renew"><input class="addition" type="checkbox" name="key-locker" value="1" <% if KeyLocker == "Y" %>checked<% end_if %> /> Ski locker (add $$SiteConfig.KeyLocker)</label><br />
            				<label class="renew"><input class="addition" type="checkbox" name="all-season-pass" value="1" <% if AllSeasonPass == "Y" %>checked<% end_if %> /> Season Pass (add $<% if $MembershipType == "Junior" %>$SiteConfig.AllSeasonPassJunior<% else %>$SiteConfig.AllSeasonPassAdult<% end_if %>)</label>
            				<hr />
	            			<div>
	            			Subtotal: $<span class="fee"></span><br />
	            			<label class="renew"><input type="checkbox" name="renew" value="1" checked /> <div>Renew</div></label>
	            			</div>
	            		<% end_if %>
            			</span>
					</div><% end_with %><% if $LoggedMemberFamily %><% loop $LoggedMemberFamily %><div class="u-1/4 account">
						<strong class="u-uppercase">Family Member</strong><br />
						<input type="hidden" class="account-id" value="$ID" />
						<input type="hidden" class="form-membership-type" value="" />
						<input type="hidden" class="date-of-birth" value="$DateOfBirth" />
            			<br />$FirstName $LastName 
						<br /><span class="membership-type">$MembershipType</span>
						<br />$Status
						<% if $Credits > 0 %><br />Credits: $<span class="credits">$Credits</span><% end_if %>
            			<% if $Status != "Active" %>
            				<hr />
            				Fees:<br />
	            			Annual Fee:  
	            			<% if $MembershipType == "Adult" || $MembershipType == "Family" %>
	           					$<span class="annual-fee">$SiteConfig.AnnualAdult</span>
	            			<% else_if $MembershipType == "Junior" %>
	            				$<span class="annual-fee">$SiteConfig.AnnualJunior</span>
	            			<% else_if $MembershipType == "Associate" %>
	            				$<span class="annual-fee">$SiteConfig.AnnualAssociate</span> 
	            			<% else_if $MembershipType == "Veteran" %>
	            				$<span class="annual-fee">$SiteConfig.AnnualVeteran</span> 
	            			<% end_if %>
	            			<br />

            				<label class="renew"><input class="addition" type="checkbox" name="boot-locker" value="1" <% if BootLocker == "Y" %>checked<% end_if %> /> Boot locker (add $$SiteConfig.BootLocker)</label><br />
            				<label class="renew"><input class="addition" type="checkbox" name="key-locker" value="1" <% if KeyLocker == "Y" %>checked<% end_if %> /> Ski locker (add $$SiteConfig.KeyLocker)</label><br />
            				<label class="renew"><input class="addition" type="checkbox" name="all-season-pass" value="1" <% if AllSeasonPass == "Y" %>checked<% end_if %> /> Season Pass (add $<% if $MembershipType == "Junior" %>$SiteConfig.AllSeasonPassJunior<% else %>$SiteConfig.AllSeasonPassAdult<% end_if %>)</label>
            				<hr />
	            			<div>
	            			Subtotal: $<span class="fee"></span><br />
	            			<label class="renew"><input type="checkbox" name="renew" value="1" checked /> <div>Renew</div></label>
	            			</div>
	            		<% end_if %>
					</div><% end_loop %>
					<% end_if %>
					<hr />
					<div class="o-layout__item u-1/1"><strong>Total fees: </strong> $<span class="fees">$Fees</div></div>
					<hr />
					<div class="o-layout__item u-1/1">
						<h2>PAYMENT OPTIONS</h2>
					</div><div class="o-layout__item u-1/3">
						<strong>CREDIT CARD</strong>
						<input type="hidden" name="RegistrationFee" value="$SiteConfig.RegistrationFee" />
						<input type="hidden" name="AnnualAdultDiscounted" value="$SiteConfig.AnnualAdultDiscounted" />
						<input type="hidden" name="AnnualAdult" value="$SiteConfig.AnnualAdult" />
						<input type="hidden" name="AnnualAssociate" value="$SiteConfig.AnnualAssociate" />
						<input type="hidden" name="AnnualVeteran" value="$SiteConfig.AnnualVeteran" />
						<input type="hidden" name="AnnualJunior" value="$SiteConfig.AnnualJunior" />
						<input type="hidden" name="BootLocker" value="$SiteConfig.BootLocker" />
						<input type="hidden" name="KeyLocker" value="$SiteConfig.KeyLocker" />
						<input type="hidden" name="AllSeasonPassAdult" value="$SiteConfig.AllSeasonPassAdult" />
						<input type="hidden" name="AllSeasonPassJunior" value="$SiteConfig.AllSeasonPassJunior" />
						<p>You'll be taken to another secure payment page and asked to enter your credit card details.</p>
						<p><strong>Note that your payment will have a surcharge of 2.5% added to the above fees.</strong></p>
						<form action="{$Link}ProcessPayment" method="post" id="form-payment" target="_blank" class="u-1/1">
						<% with $LoggedMember %>
							<input type="hidden" id="px_name" name="Name" value="$FirstName $LastName" />
							<input type="hidden" id="px_email" name="Email" value="$Email" />
						<% end_with %>	
							<input type="hidden" id="px_ids" name="Ids" value="" />
							<input type="hidden" id="px_total" name="Total" value="$Fees" />
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
				<% else %>
					<div align="center">$Content</div>
					<% include LoginForms %>
				<% end_if %>
			</div>
		</article>
		
	</div>
</div>

</div>

<script>
$(function(){
	resetForm();
});

var fees, ids;
function resetForm() {
	// fees 
	var fee_new = parseInt($('[name=RegistrationFee]').val());
	var fee_adult = parseInt($('[name=AnnualAdult]').val());
	var fee_adult_discounted = parseInt($('[name=AnnualAdultDiscounted]').val());
	var fee_junior = parseInt($('[name=AnnualJunior]').val());
	var fee_boot_locker = parseInt($('[name=BootLocker]').val());
	var fee_key_locker = parseInt($('[name=KeyLocker]').val());
	var fee_all_season_adult = parseInt($('[name=AllSeasonPassAdult]').val());
	var fee_all_season_junior = parseInt($('[name=AllSeasonPassJunior]').val());

	fees = 0;
	ids = [];
	$('.o-summary .account').each(function(){
        var age;
        var dob = $(this).find('.date-of-birth').val().split('-');
        age = calculateAge(dob[2] + '-' + dob[1] + '-' + dob[0]);

        if (age <= 18) {
            $(this).find('.form-membership-type').val('Junior');
            $(this).find('.membership-type').html('Junior');
        } else {
            $(this).find('.form-membership-type').val('Adult');
            $(this).find('.membership-type').html('Adult');
        }
		
		var fee = parseInt($(this).find('.annual-fee').html());
		if ($(this).find('[name=boot-locker]').is(':checked')) {
			fee += fee_boot_locker;
		}
		if ($(this).find('[name=key-locker]').is(':checked')) {
			fee += fee_key_locker;
		}
		if ($(this).find('[name=all-season-pass]').is(':checked')) {
			fee += $(this).find('.membership-type').html() == "Junior" ? fee_all_season_junior : fee_all_season_adult;
		}
		
		if ($(this).find('.credits').length) {
			fee -= parseInt($(this).find('.credits').html());
		}
		
		if ($(this).find('[name=renew]').is(':checked')) {
			fees += fee;
			ids.push($(this).find('.account-id').val());
		}
		
		$(this).find('.fee').html(fee);
	});
	$('#px_ids').val(ids.join());
	$('#px_total').val(fees * 1.025);
	$('.fees').html(fees);
}

$('[name=renew], .addition').change(function() {
	resetForm();
});


$('#form-payment').submit(function() {
	$('.o-summary .account').each(function(){
		var id = $(this).find('.account-id').val();
		var key_locker = $(this).find('[name=key-locker]').is(':checked') ? 'Y' : 'N';
		var boot_locker = $(this).find('[name=boot-locker]').is(':checked') ? 'Y' : 'N';
		var all_season_pass = $(this).find('[name=all-season-pass]').is(':checked') ? 'Y' : 'N';
		var membership_type = $(this).find('.form-membership-type').val();
		console.log('id=' + id + "&key-locker=" + key_locker +"&boot-locker=" + boot_locker +"&all-season-pass=" + all_season_pass);
        $.ajax({
            method: "POST",
            url: "/members-area/RenewUpdate",
            data: 'id=' + id + "&key-locker=" + key_locker +"&boot-locker=" + boot_locker +"&all-season-pass=" + all_season_pass +"&membership-type=" + membership_type,
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                alert('err')
            }
        });
	});
    return true;
});
</script>