jQuery.noConflict();

(function($) {
	$(document).ready(function() {
		$('li.menu-parent').click(function(event) {
			if ($(window).width() < 1200) {
				console.log($(window).width())
				if (!$(this).hasClass('open')) {//open
					//close others
					$('li.menu-parent').removeClass('open');
					$('li.menu-parent span.open-button').html('+');
					
					$(this).removeClass('open');
					$(this).addClass('open');
					$(this).find('.open-button').html('-');
				}else {//close
					$(this).removeClass('open');
					$(this).find('.open-button').html('+');
				}
			}
		});
		
		$('.open-contacts').click(function(event) {
			//$('.header-contact').toggle();
		});
		
		/* Tables */
		//responsive tables
		$('table').each(function(){
			$(this).css({"maxWidth": $(this).width()});
			$(this).width('100%');
			if (!$(this).hasClass('clear-table') > 0 ) { 
				$(this).css({"minHeight": $(this).height()}); 
			}
			$(this).height('auto');
		});
		
		$('.table1, .table2, .table3').each(function() {
			$(this).find('tbody td').each(function() {
				var index = $(this).index();
				var content = $(this).closest( '.table1, .table2, .table3' ).find('thead td').eq(index).text();
				$(this).prepend( "<div class='cell-title'>" + content + "</div>" );
			});
		});
		
		/* EmploymentPage */
		$('.job .short').click(function(event) {
			event.preventDefault();
			$(this).children('.expand').toggleClass('expanded');
			$(this).parent().find('.more').toggle();
		});
		
		/* EventsPage */
		$('.event-more').click(function(event) {
			event.preventDefault();
			$(this).parent().parent().siblings('.content').slideToggle();
		});
		
		/* VideoPage */
		$('.video-thumb.video-nav a').click(function(event) {
			event.preventDefault();
			var videoID = $(this).parent().attr('id').substring(1, 4);
			var current = $('.video.current');
			var currentID = $('.video.current').data('id');
			if (videoID != currentID) {
				current.removeClass('current');
				
				//crude but effective way to mute a video in an iframe
				current.clone().insertAfter(current);
				current.remove();
				
				$('.v' + videoID).addClass('current');
			}
			
			$('html, body').animate({
				scrollTop: $('.player').offset().top
			}, 2000);
		});
		
		/* GalleryPage */
		$('.gallery .photos').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
				delegate: 'a', // child items selector, by clicking on it popup will open
				type: 'image',
				gallery: {
				  enabled: true
				},
				image: {
					titleSrc: function(item) {
						return '<div class="open-caption"></div><span class="caption">' + item.el.attr('title') + '</span>';
					}
				}
			  // other options
			});
		});
		
		$(window).trigger('resize');
	});
	
		
	/* BlogPage */
	/* ArchAugust edits */
	function loadMasonry() {
		$('.blogs').masonry({
			// options
		    itemSelector: '.blog',
			columnWidth: '.blog-sizer',
			percentPosition: true,
		    fitWidth: true
		});
	}
	
	/* Webcam */
	var max = $('.webcam-image').length;
	function loadSlider() {
		$( "#slider" ).slider({
		  range: "max",
		  min: -max,
		  max: -1,
		  value: -1,
		  slide: function( event, ui ) {
			$('.webcam-image').hide();
			$('.webcam-image#i' + Math.abs(ui.value)).show();
		  }
		});
	
		$('#mobile-slider').on('input change', function(event) {
			$('.webcam-image').hide();
			$('.webcam-image#i' + Math.abs($(this).val())).show();
		});
	}
	
	$('.blogs').imagesLoaded( function() {
		loadMasonry();
	});	

	$('.no-link').click(function(event) {
		event.preventDefault();
	});
	
	$('.blog').click(function(event) {
		var e = $(this),
			open = e.hasClass('open');
		
		$('.blog').each(function(){
			$(this).removeClass('open');
			$(this).find('.blog-short').removeClass('u-hidden');
			$(this).find('.blog-full').addClass('u-hidden');
		});
		
		if (open == false) {
			e.addClass('open');
			e.find('.blog-short').addClass('u-hidden');
			e.find('.blog-full').removeClass('u-hidden');
		}
		
		loadMasonry();
	});
	
	$('.slide').click(function(){
		if ($(window).width() < 960){
			$(this).find('.image-overlay').toggle();
		}
	});
	
	$('a[href*=\\#]').on('click', function(event){
		if ($(this.hash).length > 0)
			$('html,body').animate({scrollTop:$(this.hash).offset().top - 200}, 500);
	});
	
	$(window).resize(function(){
		if ($(this).width() < 1200) {
			if ($(".o-webcam-mobile").html() == "") {
				$(".o-webcam-mobile").html($(".o-webcam-desktop").html());
				$(".o-webcam-desktop").html("");
				loadSlider();
			}
		}
		else {
			if ($(".o-webcam-desktop").html() == "") {
				$(".o-webcam-desktop").html($(".o-webcam-mobile").html());
				$(".o-webcam-mobile").html("");
				loadSlider();
			}
			else 
				loadSlider();
		}
	});

	if ($('.form_dob').length > 0) {
		$('body').on('click','.form_dob', loadDatePicker);
	
		function loadDatePicker(){
			$('.form_dob').datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: "-100:+0",
				dateFormat: 'yy-mm-dd'
			});
		}
		loadDatePicker();
	}

	$('#form_membershipType').change(function(){
		if ($(this).find(':selected').val() == 'Family') {
			$('.family-only').removeClass('hidden');
		}
		else {
			$('.family-only').addClass('hidden');
		}
	});

	function newSwitcher() {
		$(".o-new-account .o-new").change(function(){
			var parent = $(this).closest('.o-new-account'); 
			if ($(this).val() == 'New') {
				parent.find('.o-membership-number').addClass('hidden');
			}
			else {
				parent.find('.o-membership-number').removeClass('hidden');
			}
		});
	}
	newSwitcher();

	
	var members = 1;

	$('#add-more').click(function(){
		members++;
		$('#additional-forms').append(`<br />
	<div class="o-new-account">
	<div class="o-membership-form">
		<input type="hidden" class="o-form-membership-type" name="Members[`+ (members - 1) +`][MembershipType]" value="" />
		<div class="u-1/1"><strong>APPLICANT `+ members +`</strong></div><div class="u-1/1">
			<label><span>1.</span> Are you a new or existing member?</label>
		</div><div class="u-1/4">
			<div class="u-radio o-form-new"><span class='radio'>
			<input type="radio" class="o-new" name="Members[`+ (members - 1) +`][New]" id="Form_MembershipForm_New_1_`+ members +`" selected value="New" />
			<label for="Form_MembershipForm_New_1_`+ members +`"><span></span> New</label>
			</span> &nbsp; &nbsp;
			<span class='radio'>
			<input type="radio" class="o-new" name="Members[`+ (members - 1) +`][New]" id="Form_MembershipForm_New_2_`+ members +`" value="Returning" />
			<label for="Form_MembershipForm_New_2_`+ members +`"><span></span> Returning</label>
			</span>
			</div>
		</div><div class="u-1/4">
			<input class="o-membership-number hidden" type="text" name="Members[`+ (members - 1) +`][MembershipNumber]" placeholder="Enter your membership number" />
		</div>
	</div>
	<div class="o-membership-form">
		<div class="u-1/4">
			<label for="form_fname_`+ members +`"><span>2.</span> First Name *</label>
			<input class="required o-form-fname" type="text" name="Members[`+ (members - 1) +`][FirstName]" id="form_fname_`+ members +`" required="required" />
		</div><div class="u-1/4">
			<label for="form_lname_`+ members +`"><span>3.</span> Last Name *</label>
			<input class="required o-form-lname" type="text" name="Members[`+ (members - 1) +`][LastName]" id="form_lname_`+ members +`" required="required" />
		</div><div class="u-1/4">
			<label for="form_email_`+ members +`"><span>4.</span> Email</label>
			<input type="email" class="o-form-email" name="Members[`+ (members - 1) +`][Email]" id="form_email_`+ members +`" />
		</div><div class="u-1/4">
			<label for="form_phone_`+ members +`"><span>5.</span> Phone</label>
			<input type="text" class="o-form-phone" name="Members[`+ (members - 1) +`][Phone]" id="form_phone_`+ members +`" />
		</div><div class="u-1/4">
			<label for="form_city_`+ members +`"><span>6.</span> City Where You Live</label>
			<input type="text" class="o-form-city" name="Members[`+ (members - 1) +`][City]" id="form_city_`+ members +`" />
		</div><div class="u-1/4">
			<label for="form_country_`+ members +`"><span>7.</span> Country</label>
			<input type="text" class="o-form-country" name="Members[`+ (members - 1) +`][Country]" id="form_country_`+ members +`" />
		</div><div class="u-1/4">
			<label for="form_dob_`+ members +`"><span>8.</span> Date of Birth *</label>
			<input type="text" class="form_dob required o-form-dob" name="Members[`+ (members - 1) +`][DateOfBirth]" id="form_dob_`+ members +`" required="required" />
		</div><div class="u-1/4">
			<label><span>9.</span> Sex</label>
			<div class="u-radio o-form-sex">
			<span class='radio'>
			<input type="radio" name="Members[`+ (members - 1) +`][Sex]" id="form_sex_1_`+ members +`" value="M" />
			<label for="form_sex_1_`+ members +`"><span></span> M</label>
			</span>
			<span class='radio'>
			<input type="radio" name="Members[`+ (members - 1) +`][Sex]" id="form_sex_2_`+ members +`" value="F" />
			<label for="form_sex_2_`+ members +`"><span></span> F</label>
			</span>
			</div>
		</div><div class="u-1/1">
			<label for="form_association_`+ members +`"><span>10.</span> Previous Association with Broken River. Have you skied or boarded at BR? Do you know anyone in the club? How did you contact us?</label>
			<textarea name="Members[`+ (members - 1) +`][Association]" class="o-form-association" id="form_association_`+ members +`"></textarea>
		</div><div class="u-1/1">
			<label><span>11.</span> Useful Skills. Our club benefits greatly from the input of our members and their skills. Please select one or more skills that apply.</label>
			<div class="o-checkboxes">
			<div class="u-1/4">
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Administration" id="skills_Administration_`+ members +`" /><label for="skills_Administration_`+ members +`"> Administration </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Carpentry" id="skills_Carpentry_`+ members +`" /><label for="skills_Carpentry_`+ members +`"> Carpentry </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Electrical" id="skills_Electrical_`+ members +`" /><label for="skills_Electrical_`+ members +`"> Electrical </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Architecture" id="skills_Architecture_`+ members +`" /><label for="skills_Architecture_`+ members +`"> Architecture </label><br />
			</div><div class="u-1/4">
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Plumbing" id="skills_Plumbing_`+ members +`" /><label for="skills_Plumbing_`+ members +`"> Plumbing </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Painting / Decorating" id="skills_Painting_`+ members +`" /><label for="skills_Painting_`+ members +`"> Painting / Decorating</label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Communications" id="skills_Communications_`+ members +`" /><label for="skills_Communications_`+ members +`"> Communications </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Sewing" id="skills_Sewing_`+ members +`" /><label for="skills_Sewing_`+ members +`"> Sewing </label><br />
			</div><div class="u-1/4">
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Engineering" id="skills_Engineering_`+ members +`" /><label for="skills_Engineering_`+ members +`"> Engineering </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Computers / IT" id="skills_Computers_`+ members +`" /><label for="skills_Computers_`+ members +`"> Computers / IT </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Electronics" id="skills_Electronics_`+ members +`" /><label for="skills_Electronics_`+ members +`"> Electronics </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Signwriting" id="skills_Signwriting_`+ members +`" /><label for="skills_Signwriting_`+ members +`"> Signwriting </label>
			</div><div class="u-1/4">
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Draughting" id="skills_Draughting_`+ members +`" /><label for="skills_Draughting_`+ members +`"> Draughting </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="First Aid / Medic" id="skills_First-Aid_`+ members +`" /><label for="skills_First-Aid_`+ members +`"> First Aid / Medic </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Construction" id="skills_Construction_`+ members +`" /><label for="skills_Construction_`+ members +`"> Construction </label><br />
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Marketing" id="skills_Marketing_`+ members +`" /><label for="skills_Marketing_`+ members +`"> Marketing </label>
			</div><div class="u-1/4">
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="HT Licence" id="skills_HT-Licence_`+ members +`" /><label for="skills_HT-Licence_`+ members +`"> HT Licence </label>
			</div><div class="u-1/2">
				<input type="checkbox" name="Members[`+ (members - 1) +`][Skills][]" value="Heavy Machinery experience / licence" id="skills_Heavy-Machinery_`+ members +`" /><label for="skills_Heavy-Machinery_`+ members +`"> Heavy Machinery experience / licence </label>
			</div>			
			</div>
	 	</div><div class="u-1/1">
			<label for="form_other_`+ members +`"><span>12.</span> Other Pertinent Info. Anything else relating to this application that you think we should know about?</label>
			<textarea name="Members[`+ (members - 1) +`][OtherInfo]" id="form_Other_`+ members +`"></textarea>
		</div><div class="u-1/1">
			<label><span>13.</span> Communications</label>
			<div>
			<input type="checkbox" class="o-form-newsletter-email" name="Members[`+ (members - 1) +`][Skills][NewsletterEmail]" id="Form_MembershipForm_Comm_1_`+ (members - 1) +`" value="Y" />
			<label for="Form_MembershipForm_Comm_1_`+ (members - 1) +`"><span></span> Monthly E-Newsletter (no fee)</label>
			</span> &nbsp; &nbsp;
			
			<input type="checkbox" class="o-form-newsletter-print" name="Members[`+ (members - 1) +`][Skills][NewsletterPrint]" id="Form_MembershipForm_Comm_2_`+ (members - 1) +`" value="Y" />
			<label for="Form_MembershipForm_Comm_2_`+ (members - 1) +`"><span></span> Printed & Posted Newsletter ($10)</label>
			</div>
		</div>
	</div>
	</div>
	`);
		$('.form_dob').change(function(){
			var parent = $(this).closest('.o-new-account'),
				dob = $(this).val();
			var	dob_month_day = dob.substring(5,5),
				age;
			
			age = calculateAge(dob);
			if (age < 18 && dob_month_day != '01-01') {
				parent.find('.o-form-membership-type').val('Junior');
			}
			else {
				parent.find('.o-form-membership-type').val('Adult');
			}
			console.log(parent.find('.o-membership-type').val());
		});
		loadDatePicker();
		newSwitcher();
	});
	
	function calculateAge(dob) {
		var date = new Date();
		var year = parseInt(date.getFullYear());
		var dob_year = parseInt(dob.substring(0,4)),
			age = year - dob_year;
			
		return age;
	}
	
	$('.form_dob').change(function(){
		var parent = $(this).closest('.o-new-account'),
			dob = $(this).val();
		var	dob_month_day = dob.substring(5,5),
			age;
		
		age = calculateAge(dob);
		if (age < 18 && dob_month_day != '01-01') {
			parent.find('.o-form-membership-type').val('Junior');
		}
		else {
			parent.find('.o-form-membership-type').val('Adult');
		}
	});
	
	$('.o-pre-submit').click(function(){
		// check all required fields
	    var form = $('#form-register');

	    if (form.find('.required').filter(function(){ return this.value === '' }).length > 0) {
	        alert("Doh! Please complete all required fields.");
	        return false;
	    }
	    else {
	    	// summary
	    	$('.o-confirmation').removeClass('hidden');
	    	$('.o-summary').html('');
	    	var html = '', ctr = 1,
	    		registrationType = $('#form_membershipType').val(),
    			total_fees = 0,
    			fees = 0,
    			adult = 0, 
    			youth = 0;
	    	
	    	$('.o-new-account').each(function(){
	    		var e = $(this),
	    			applicant;

	    		// calculate fees 
	    		if (e.find(".o-form-membership-type").val() == 'Adult') {
	    			adult ++;
	    			fees = 150;
	    			
	    			// if family, first adult = half annual fee, succeeding adults full fee
	    			if (registrationType == "Family" && adult == 1) 
	    				fees += 50; // half annual fee
	    			else
	    				fees += 100;
	    		}
	    		else {
	    			// youth have no joining fee
	    			youth ++;
	    			// annual fees, if family, 3rd youth is free
	    			if (registrationType == "Family") {
		    			if (youth < 3)
		    				fees = 35;
		    			else
		    				fees = 0;
	    			}
	    			else 
	    				fees = 35;
	    		}
	    		
	    		if (ctr == 1) {
	    			if (registrationType == "Family") 
	    				applicant = 'Lead Applicant';
	    			else
	    				applicant = 'Lead Applicant';
	    		}
	    		else
	    			applicant = ('Applicant '+ ctr);
	    		html = '<div class="u-1/4"><strong class="u-uppercase">'+ applicant + '</strong><br />';
	    		if (e.find(".o-form-new input[type='radio']").val() == 'New') {
	    			html += 'Existing Member';
	    		}
	    		else {
	    			html += 'New Member';
	    		}
	    		html += '<br />Name: '+ e.find(".o-form-fname").val() +' '+ e.find(".o-form-lname").val();
	    		html += '<br />Email: '+ e.find(".o-form-email").val();
	    		html += '<br />Phone: '+ e.find(".o-form-phone").val();
	    		html += '<br />City: '+ e.find(".o-form-city").val();
	    		html += '<br />Country: '+ e.find(".o-form-country").val();
	    		html += '<br />DOB: '+ e.find(".o-form-dob").val();
	    		html += '<br />Sex: '+ e.find(".o-form-sex input[type='radio']").val();
	    		html += '<br />' + e.find(".o-form-membership-type").val();
	    		html += '<br />Monthly E-Newsletter: ';
	    		if (e.find(".o-form-newsletter-email").is(':checked'))
	    			html += 'Y';
	    		else
	    			html += 'N';
	    		html += '<br />Printed Newsletter: ';
	    		if (e.find(".o-form-newsletter-print").is(':checked')) {
	    			html += 'Y';
	    			
	    			// 1 newsletter fee if family
	    			if (registrationType != 'Family') {
	    				fees += 10;
	    			}
	    			else 
	    				if (ctr == 1) {
	    					fees += 10;
	    				}
	    			
	    		}
	    		else
	    			html += 'N';
	    		html += '<br /><br /><strong>'+ applicant +' Fees: $'+ fees +'</strong>';
	    		html += '</div>';
	    		
	    		ctr ++;
	    		total_fees += fees;
	    		
		    	$('.o-summary').append(html);
	    	});
	    	
	    	$('.o-summary').append('<br /><br /><div class="o-total">Total Fees: $'+ total_fees +'</div>');
	    }
	});
	
	$("#form-register").submit(function(event){
		// if family registration, need at least 2 members 
		if ($('#form_membershipType').val() == 'Family' && members < 2) {
			alert("Family membership requires at least two members.")
			event.preventDefault();
		}
		else {
			$('.o-submit-button').html('Sending Application').attr('disabled','true');
			var data = $(this).serialize();
		    $.ajax({
		        url: "/about-br/packaging-and-pricing-2/membership/Register",
		        data: data,
		        type: "POST",
		        success: function (data) {
	            	$('.o-submit-button').html('Application Sent');
	            	$('.o-success').removeClass('hidden');
	            }
		    })
		    event.preventDefault();
		}
	});
}(jQuery));

var width = jQuery(window).width();

jQuery(window).load(function(){
	jQuery('.section').imagesLoaded( function() {
		if(window.location.hash) {
			jQuery('html,body').animate({scrollTop:jQuery(window.location.hash).offset().top - 200}, 500);
			jQuery(window.location.hash).trigger('click');
		}
	});	
});