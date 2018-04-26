$('#form_membershipType').change(function(){
	if ($(this).find(':selected').val() == 'Family') {
		$('.family-only').removeClass('hidden');
	}
	else {
		$('.family-only').addClass('hidden');
	}
});

$(".o-new-account input[type='radio']").change(function(){
	var parent = $(this).closest('.o-new-account'); 
	if ($(this).val() == 'New') {
		parent.find('.o-membership-number').addClass('hidden');
	}
	else {
		parent.find('.o-membership-number').removeClass('hidden');
	}
});

var members = 1;
$('#add-more').click(function(){
	members++;
	$('#additional-forms').append(`<hr />
<div class="o-membership-form o-new-account">
	<input type="hidden" name="MembershipType[]" value="Family" />
	<div class="u-1/1"><strong>APPLICANT `+ members +`</strong></div><div class="u-1/1">
		<label><span>1.</span> Are you a new or existing member?</label>
	</div><div class="u-1/4">
		<div class="u-radio"><span class='radio'>
		<input type="radio" name="New_`+ members +`" id="Form_MembershipForm_New_1_`+ members +`" selected value="New" />
		<label for="Form_MembershipForm_New_1_`+ members +`"><span></span> New</label>
		</span> &nbsp; &nbsp;
		<span class='radio'>
		<input type="radio" name="New_`+ members +`" id="Form_MembershipForm_New_2_`+ members +`" value="Returning" />
		<label for="Form_MembershipForm_New_2_`+ members +`"><span></span> Returning</label>
		</span>
		</div>
	</div><div class="u-1/4">
		<input class="o-membership-number hidden" type="text" name="MembershipNumber[]" placeholder="Enter your membership number" />
	</div>
</div>
<div class="o-membership-form">
	<div class="u-1/4">
		<label for="form_fname_`+ members +`"><span>2.</span> First Name</label>
		<input type="text" name="FirstName[]" id="form_fname_`+ members +`" />
	</div><div class="u-1/4">
		<label for="form_lname_`+ members +`"><span>3.</span> Last Name</label>
		<input type="text" name="LastName[]" id="form_lname_`+ members +`" />
	</div><div class="u-1/4">
		<label for="form_email_`+ members +`"><span>4.</span> Email</label>
		<input type="text" name="Email[]" id="form_email_`+ members +`" />
	</div><div class="u-1/4">
		<label for="form_phone_`+ members +`"><span>5.</span> Phone</label>
		<input type="text" name="Phone[]" id="form_phone_`+ members +`" />
	</div><div class="u-1/4">
		<label for="form_city_`+ members +`"><span>6.</span> City Where You Live</label>
		<input type="text" name="City[]" id="form_city_`+ members +`" />
	</div><div class="u-1/4">
		<label for="form_country_`+ members +`"><span>7.</span> Country</label>
		<input type="text" name="Country[]" id="form_country_`+ members +`" />
	</div><div class="u-1/4">
		<label for="form_dob_`+ members +`"><span>8.</span> Date of Birth</label>
		<input type="text" class="form_dob" name="DateOfBirth[]" id="form_dob_`+ members +`" />
	</div><div class="u-1/4">
		<label><span>9.</span> Sex</label>
		<div class="u-radio">
		<span class='radio'>
		<input type="radio" name="Sex[]" id="form_sex_1_`+ members +`" value="M" />
		<label for="form_sex_1_`+ members +`"><span></span> M</label>
		</span>
		<span class='radio'>
		<input type="radio" name="Sex[]" id="form_sex_2_`+ members +`" value="F" />
		<label for="form_sex_2_`+ members +`"><span></span> F</label>
		</span>
		</div>
	</div><div class="u-1/1">
		<label for="form_association_`+ members +`"><span>10.</span> Previous Association with Broken River. Have you skied or boarded at BR? Do you know anyone in the club? How did you contact us?</label>
		<textarea name="Association[]" id="form_association_`+ members +`"></textarea>
	</div><div class="u-1/1">
		<label><span>11.</span> Useful Skills. Our club benefits greatly from the input of our members and their skills. Please select one or more skills that apply.</label>
		<div class="o-checkboxes">
		<div class="u-1/4">
			<input type="checkbox" name="Skills[][]" value="Administration" id="skills_Administration_`+ members +`" /><label for="skills_Administration_`+ members +`"> Administration </label><br />
			<input type="checkbox" name="Skills[][]" value="Carpentry" id="skills_Carpentry_`+ members +`" /><label for="skills_Carpentry_`+ members +`"> Carpentry </label><br />
			<input type="checkbox" name="Skills[][]" value="Electrical" id="skills_Electrical_`+ members +`" /><label for="skills_Electrical_`+ members +`"> Electrical </label><br />
			<input type="checkbox" name="Skills[][]" value="Architecture" id="skills_Architecture_`+ members +`" /><label for="skills_Architecture_`+ members +`"> Architecture </label><br />
		</div><div class="u-1/4">
			<input type="checkbox" name="Skills[][]" value="Plumbing" id="skills_Plumbing_`+ members +`" /><label for="skills_Plumbing_`+ members +`"> Plumbing </label><br />
			<input type="checkbox" name="Skills[][]" value="Painting / Decorating" id="skills_Painting_`+ members +`" /><label for="skills_Painting_`+ members +`"> Painting / Decorating</label><br />
			<input type="checkbox" name="Skills[][]" value="Communications" id="skills_Communications_`+ members +`" /><label for="skills_Communications_`+ members +`"> Communications </label><br />
			<input type="checkbox" name="Skills[][]" value="Sewing" id="skills_Sewing_`+ members +`" /><label for="skills_Sewing_`+ members +`"> Sewing </label><br />
		</div><div class="u-1/4">
			<input type="checkbox" name="Skills[][]" value="Engineering" id="skills_Engineering_`+ members +`" /><label for="skills_Engineering_`+ members +`"> Engineering </label><br />
			<input type="checkbox" name="Skills[][]" value="Computers / IT" id="skills_Computers_`+ members +`" /><label for="skills_Computers_`+ members +`"> Computers / IT </label><br />
			<input type="checkbox" name="Skills[][]" value="Electronics" id="skills_Electronics_`+ members +`" /><label for="skills_Electronics_`+ members +`"> Electronics </label><br />
			<input type="checkbox" name="Skills[][]" value="Signwriting" id="skills_Signwriting_`+ members +`" /><label for="skills_Signwriting_`+ members +`"> Signwriting </label>
		</div><div class="u-1/4">
			<input type="checkbox" name="Skills[][]" value="Draughting" id="skills_Draughting_`+ members +`" /><label for="skills_Draughting_`+ members +`"> Draughting </label><br />
			<input type="checkbox" name="Skills[][]" value="First Aid / Medic" id="skills_First-Aid_`+ members +`" /><label for="skills_First-Aid_`+ members +`"> First Aid / Medic </label><br />
			<input type="checkbox" name="Skills[][]" value="Construction" id="skills_Construction_`+ members +`" /><label for="skills_Construction_`+ members +`"> Construction </label><br />
			<input type="checkbox" name="Skills[][]" value="Marketing" id="skills_Marketing_`+ members +`" /><label for="skills_Marketing_`+ members +`"> Marketing </label>
		</div><div class="u-1/4">
			<input type="checkbox" name="Skills[][]" value="HT Licence" id="skills_HT-Licence_`+ members +`" /><label for="skills_HT-Licence_`+ members +`"> HT Licence </label>
		</div><div class="u-1/2">
			<input type="checkbox" name="Skills[][]" value="Heavy Machinery experience / licence" id="skills_Heavy-Machinery_`+ members +`" /><label for="skills_Heavy-Machinery_`+ members +`"> Heavy Machinery experience / licence </label>
		</div>			
		</div>
 	</div><div class="u-1/1">
		<label for="form_other_`+ members +`"><span>12.</span> Other Pertinent Info. Anything else relating to this application that you think we should know about?</label>
		<textarea name="OtherInfo[]" id="form_Other_`+ members +`"></textarea>
	</div>
</div>
`);
loadDatePicker();	
});

$(function() {
	function loadDatePicker() {
		$( ".form_dob" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy'
		});
	}

	loadDatePicker();
});