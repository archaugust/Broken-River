jQuery.noConflict();

(function($) {
    $(document).ready(function() {
        $('li.menu-parent').click(function(event) {
            if ($(window).width() < 1200) {
                console.log($(window).width())
                if (!$(this).hasClass('open')) { //open
                    //close others
                    $('li.menu-parent').removeClass('open');
                    $('li.menu-parent span.open-button').html('+');

                    $(this).removeClass('open');
                    $(this).hide().addClass('open').slideDown();
                    $(this).find('.open-button').html('-');
                } else { //close
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
        $('table').each(function() {
            $(this).css({ "maxWidth": $(this).width() });
            $(this).width('100%');
            if (!$(this).hasClass('clear-table') > 0) {
                $(this).css({ "minHeight": $(this).height() });
            }
            $(this).height('auto');
        });

        $('.table1, .table2, .table3').each(function() {
            $(this).find('tbody td').each(function() {
                var index = $(this).index();
                var content = $(this).closest('.table1, .table2, .table3').find('thead td').eq(index).text();
                $(this).prepend("<div class='cell-title'>" + content + "</div>");
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
            $(this).closest('.event').find('.content').slideToggle();
            event.preventDefault();
        });

        $('.events-header').click(function() {
            alert('a')
        });

        /* VideoPage */
        $('.video-thumb.video-nav a').click(function(event) {
            event.preventDefault();
            var videoID = $(this).parent().attr('id').substring(1, 4);
            var current = $(this).closest('.video-category').find('.video.current');
            var currentID = $(this).closest('.video-category').find('.video.current').data('id');
            if (videoID != currentID) {
                current.removeClass('current');

                //crude but effective way to mute a video in an iframe
                current.clone().insertAfter(current);
                current.remove();

                $('.v' + videoID).addClass('current');
            }

            $('html, body').animate({
                scrollTop: $(this).closest('.video-category').find('.player').offset().top - 200
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
        
        renderFees();

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
        $("#slider").slider({
            range: "max",
            min: -max,
            max: -1,
            value: -1,
            slide: function(event, ui) {
                $('.webcam-image').hide();
                $('.webcam-image#i' + Math.abs(ui.value)).show();
            }
        });

        $('#mobile-slider').on('input change', function(event) {
            $('.webcam-image').hide();
            $('.webcam-image#i' + Math.abs($(this).val())).show();
        });
    }

    $('.blogs').imagesLoaded(function() {
        loadMasonry();
    });

    $('.no-link').click(function(event) {
        event.preventDefault();
    });

    $('.blog').click(function(event) {
        var e = $(this),
            open = e.hasClass('open');

        $('.blog').each(function() {
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

    $('.slide').click(function() {
        if ($(window).width() < 960) {
            $(this).find('.image-overlay').toggle();
        }
    });

    $('a[href*=\\#]').on('click', function(event) {
        if ($(this.hash).length > 0)
            $('html,body').animate({ scrollTop: $(this.hash).offset().top - 200 }, 500);
    });

    $(window).resize(function() {
        if ($(this).width() < 1200) {
            if ($(".o-webcam-mobile").html() == "") {
                $(".o-webcam-mobile").html($(".o-webcam-desktop").html());
                $(".o-webcam-desktop").html("");
                loadSlider();
            }
        } else {
            if ($(".o-webcam-desktop").html() == "") {
                $(".o-webcam-desktop").html($(".o-webcam-mobile").html());
                $(".o-webcam-mobile").html("");
                loadSlider();
            } else
                loadSlider();
        }
    });

    if ($('.form_dob').length > 0) {
        $('body').on('click', '.form_dob', loadDatePicker);

        function loadDatePicker() {
            $('.form_dob').datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                dateFormat: 'dd-mm-yy'
            });
        }
        loadDatePicker();
    }
    
    $('.show-registration-form').click(function(){
    	$('#form-register-main').slideDown();
    });

    $('#form_membershipType').change(function() {
        if ($(this).val() == 'Family') {
            $('.family-only').removeClass('hidden');
            $('.family-hide').addClass('hidden');
        } else {
            $('.family-only').addClass('hidden');
            $('.family-hide').removeClass('hidden');
        }
    });

    function newSwitcher() {
        $(".o-new-account .o-new").change(function() {
            var parent = $(this).closest('.o-new-account');
            if ($(this).val() == 'New') {
                parent.find('.o-membership-number').addClass('hidden');
            } else {
                parent.find('.o-membership-number').removeClass('hidden');
            }
        });
    }
    newSwitcher();


    var members = 1;
    
    $('#add-more').click(function() {
        members++;
        $('#additional-forms').append('<br /><div class="o-new-account">' +
            '<div class="o-membership-form">' +
            '<input type="hidden" class="o-form-membership-type" name="Members[' + (members - 1) + '][MembershipType]" value="" />' +
            '<div class="u-1/1"><strong>APPLICANT ' + members + '</strong><input type="hidden" class="o-new" name="Members[' + (members - 1) + '][New]" id="Form_MembershipForm_New_1_' + members + '" value="New" />' +
            '<input class="o-membership-number hidden" type="text" name="Members[' + (members - 1) + '][MembershipNumber]" placeholder="Enter your membership number" />' +
            '</div><div class="u-1/4">' +
            '<label for="form_fname_' + members + '"><span>1.</span> First Name *</label>' +
            '<input class="required o-form-fname" type="text" name="Members[' + (members - 1) + '][FirstName]" id="form_fname_' + members + '" required="required" />' +
            '</div><div class="u-1/4">' +
            '<label for="form_lname_' + members + '"><span>2.</span> Last Name *</label>' +
            '<input class="required o-form-lname" type="text" name="Members[' + (members - 1) + '][LastName]" id="form_lname_' + members + '" required="required" />' +
            '</div><div class="u-1/4">' +
            '<label for="form_email_' + members + '"><span>3.</span> Email</label>' +
            '<input type="email" class="o-form-email" name="Members[' + (members - 1) + '][Email]" id="form_email_' + members + '" />' +
            '</div><div class="u-1/4">' +
            '<label for="form_phone_' + members + '"><span>4.</span> Phone</label>' +
            '<input type="text" class="o-form-phone" name="Members[' + (members - 1) + '][Phone]" id="form_phone_' + members + '" />' +
            '</div><div class="u-1/4">' +
            '<label for="form_city_' + members + '"><span>5.</span> City Where You Live</label>' +
            '<input type="text" class="o-form-city" name="Members[' + (members - 1) + '][City]" id="form_city_' + members + '" />' +
            '</div><div class="u-1/4">' +
            '<label for="form_country_' + members + '"><span>6.</span> Country</label>' +
            '<input type="text" class="o-form-country" name="Members[' + (members - 1) + '][Country]" id="form_country_' + members + '" />' +
            '</div><div class="u-1/4">' +
            '<label for="form_dob_' + members + '"><span>7.</span> Date of Birth *</label>' +
            '<input type="text" class="form_dob required o-form-dob" name="Members[' + (members - 1) + '][DateOfBirth]" id="form_dob_' + members + '" required="required" />' +
            '</div><div class="u-1/4">' +
            '<label><span>8.</span> Sex</label>' +
            '<div class="u-radio o-form-sex">' +
            '<span class="radio">' +
            '<input type="radio" name="Members[' + (members - 1) + '][Sex]" id="form_sex_1_' + members + '" value="M" />' +
            '<label for="form_sex_1_' + members + '"><span></span> M</label>' +
            '</span>' +
            '<span class="radio">' +
            '<input type="radio" name="Members[' + (members - 1) + '][Sex]" id="form_sex_2_' + members + '" value="F" />' +
            '<label for="form_sex_2_' + members + '"><span></span> F</label>' +
            '</span>' +
            '</div>' +
            '</div><div class="u-1/2"><label for="form_occupation_'+ members +'"><span>9.</span> Occupation</label>' +
            '<input name="Members[0][Occupation]" class="o-form-occupation" id="form_occupation_'+ members +'" />' +
            '</div><div class="u-1/1">' +
            '<label for="form_association_' + members + '"><span>10.</span> Previous Association with Broken River. Have you skied or boarded at BR? Do you know anyone in the club? How did you contact us?</label>' +
            '<textarea name="Members[' + (members - 1) + '][Association]" class="o-form-association" id="form_association_' + members + '"></textarea>' +
            '</div><div class="u-1/1">' +
            '<label><span>11.</span> Useful Skills. Our club benefits greatly from the input of our members and their skills. Please select one or more skills that apply.</label>' +
            '<div class="o-checkboxes">' +
            '<div class="u-1/4">' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Administration" id="skills_Administration_' + members + '" /><label for="skills_Administration_' + members + '"> Administration </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Carpentry" id="skills_Carpentry_' + members + '" /><label for="skills_Carpentry_' + members + '"> Carpentry </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Electrical" id="skills_Electrical_' + members + '" /><label for="skills_Electrical_' + members + '"> Electrical </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Architecture" id="skills_Architecture_' + members + '" /><label for="skills_Architecture_' + members + '"> Architecture </label><br />' +
            '</div><div class="u-1/4">' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Plumbing" id="skills_Plumbing_' + members + '" /><label for="skills_Plumbing_' + members + '"> Plumbing </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Painting / Decorating" id="skills_Painting_' + members + '" /><label for="skills_Painting_' + members + '"> Painting / Decorating</label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Communications" id="skills_Communications_' + members + '" /><label for="skills_Communications_' + members + '"> Communications </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Sewing" id="skills_Sewing_' + members + '" /><label for="skills_Sewing_' + members + '"> Sewing </label><br />' +
            '</div><div class="u-1/4">' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Engineering" id="skills_Engineering_' + members + '" /><label for="skills_Engineering_' + members + '"> Engineering </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Computers / IT" id="skills_Computers_' + members + '" /><label for="skills_Computers_' + members + '"> Computers / IT </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Electronics" id="skills_Electronics_' + members + '" /><label for="skills_Electronics_' + members + '"> Electronics </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Signwriting" id="skills_Signwriting_' + members + '" /><label for="skills_Signwriting_' + members + '"> Signwriting </label>' +
            '</div><div class="u-1/4">' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Draughting" id="skills_Draughting_' + members + '" /><label for="skills_Draughting_' + members + '"> Draughting </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="First Aid / Medic" id="skills_First-Aid_' + members + '" /><label for="skills_First-Aid_' + members + '"> First Aid / Medic </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Construction" id="skills_Construction_' + members + '" /><label for="skills_Construction_' + members + '"> Construction </label><br />' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Marketing" id="skills_Marketing_' + members + '" /><label for="skills_Marketing_' + members + '"> Marketing </label>' +
            '</div><div class="u-1/4">' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="HT Licence" id="skills_HT-Licence_' + members + '" /><label for="skills_HT-Licence_' + members + '"> HT Licence </label>' +
            '</div><div class="u-1/2">' +
            '<input type="checkbox" name="Members[' + (members - 1) + '][Skills][]" value="Heavy Machinery experience / licence" id="skills_Heavy-Machinery_' + members + '" /><label for="skills_Heavy-Machinery_' + members + '"> Heavy Machinery experience / licence </label>' +
            '</div>' +
            '</div>' +
            '</div><div class="u-1/1"><label><span>12.</span> Boot Locker</label>'+
			'<div><input type="checkbox" class="o-form-boot-locker" name="Members[' + (members - 1) + '][BootLocker]" id="form_boot_locker_'+ members +'" value="Y" /><label for="form_boot_locker_'+ members +'"> Add $<div class="price-boot-locker"></div></label></div></div><div class="u-1/1">'+
			'<label><span>13.</span> Ski Locker</label>'+
			'<div><input type="checkbox" class="o-form-key-locker" name="Members[' + (members - 1) + '][KeyLocker]" id="form_key_locker_'+ members +'" value="Y" /><label for="form_key_locker_'+ members +'"> Add $<div class="price-key-locker"></div></label></div></div><div class="u-1/1">'+
			'<label><span>14.</span> Season Pass</label>'+
			'<div><input type="checkbox" class="o-form-all-season-pass" name="Members[' + (members - 1) + '][AllSeasonPass]" id="form_all_season_pass_'+ members +'" value="Y" /><label for="form_all_season_pass_'+ members +'"> Add Add $<div class="price-all-season-pass-adult"></div> if adult, $<div class="price-all-season-pass-junior"></div> if junior</label></div>'+
			'</div><div class="u-1/1">' +
            '<label for="form_other_' + members + '"><span>15.</span> Other Pertinent Info. Anything else relating to this application that you think we should know about?</label>' +
            '<textarea name="Members[' + (members - 1) + '][OtherInfo]" id="form_Other_' + members + '"></textarea>' +
            '</div>' +
            '</div>' +
            '</div>');
        $('.form_dob').change(function() {
            var parent = $(this).closest('.o-new-account'),
                dob = $(this).val();
            var dob_month_day = dob.substring(5, 5),
                age;

            age = calculateAge(dob);
            if (age < 18 && dob_month_day != '01-01') {
                parent.find('.o-form-membership-type').val('Junior');
            } else {
                parent.find('.o-form-membership-type').val('Adult');
            }
        });
        renderFees();
        loadDatePicker();
        newSwitcher();
        $('.o-confirmation').addClass('hidden');
        $('.o-summary').html('');
        $('#form_membershipType').val('Family').change();
    });

    // form prices
    function renderFees() {
	    $('.price-all-season-pass-adult').html($('[name=AllSeasonPassAdult]').val());
	    $('.price-all-season-pass-junior').html($('[name=AllSeasonPassJunior]').val());
	    $('.price-key-locker').html($('[name=KeyLocker]').val());
	    $('.price-boot-locker').html($('[name=BootLocker]').val());
    }
    
    $('.form_dob').change(function() {
        var parent = $(this).closest('.o-new-account');
        var dob = $(this).val();
//        var dob_day_month = dob.substring(0, 5);
        var age;
        age = calculateAge(dob);
        if (age <= 18) {
            parent.find('.o-form-membership-type').val('Junior');
        } else {
            parent.find('.o-form-membership-type').val('Adult');
        }
    });

    var total_fees = 0;
    
    $('.o-pre-submit').click(function() {
        // reset fees
        total_fees = 0;

        // check all required fields
        var form = $('#form-register');

        if (form.find('.required').filter(function() { return this.value === '' }).length > 0) {
            alert("Doh! Please complete all required fields.");
            return false;
        } else {
        	// fees 
        	var fee_new = parseInt($('[name=RegistrationFee]').val());
        	var fee_adult = parseInt($('[name=AnnualAdult]').val());
        	var fee_adult_discounted = parseInt($('[name=AnnualAdultDiscounted]').val());
        	var fee_junior = parseInt($('[name=AnnualJunior]').val());
        	var fee_boot_locker = parseInt($('[name=BootLocker]').val());
        	var fee_key_locker = parseInt($('[name=KeyLocker]').val());
        	var fee_all_season_adult = parseInt($('[name=AllSeasonPassAdult]').val());
        	var fee_all_season_junior = parseInt($('[name=AllSeasonPassJunior]').val());
        	
            // summary
            var html = '',
                ctr = 1,
                registrationType = $('#form_membershipType').val(),
                fees = 0;
            adult = 0;
            youth = 0;
            var total_adults = 0;
            var total_junior = 0;
            $('.o-new-account').each(function() {
                var e = $(this);
                if (e.find(".o-form-membership-type").val() == 'Adult') {
                	total_adults++;
                }
                else {
                	total_junior++;
                }
            });

            if (registrationType == 'Family' && (total_adults < 1 || total_junior < 1)) {
                alert("Family membership requires at least two (2) members of at least one (1) adult and (1) junior.")
                return false;
            }    	
            else {
                $('.o-confirmation').removeClass('hidden');
                $('.o-summary').html('');
	            $('.o-new-account').each(function() {
	                var e = $(this),
	                    applicant,
	                    html_fees;
	                
	                // add email requirement if Individual registration
	                if (registrationType != "Family") 
	                	e.find('.o-form-email').prop('required','required');
	                else
	                	e.find('.o-form-email').removeProp('required');
	
	                // calculate fees 
	                if (e.find(".o-form-membership-type").val() == 'Adult') {
	                    adult++;
	                    
	                    // joining fee
	                    fees = fee_new;
                    	html_fees = "<tr><td>Joining Fee:</td><td class='text-right'>$"+ fee_new +"</td></tr>";
	
	                    // annual fee 
	                    // if family, first adult = half annual fee, succeeding adults full fee
	                    if (registrationType == "Family" && adult == 1) {
	                        fees += fee_adult_discounted; // half annual fee
	                        html_fees += "<tr><td>Annual Fee - Adult (Discounted):</td><td class='text-right'>$"+ fee_adult_discounted +"</td></tr>"; 
	                    }
	                    else {
	                    	html_fees += "<tr><td>Annual Fee - Adult:</td><td class='text-right'>$"+ fee_adult +"</td></tr>"; 
	                    	fees += fee_adult;
	                    }
	                } else {
	                    // youth have no joining fee
	                    youth++;
                    	html_fees = "<tr><td>Joining Fee:</td><td class='text-right'>NONE</td></tr>";

	                    // annual fees, if family, 3rd youth is free
	                    if (registrationType == "Family") {
	                        if (youth < 3) {
	                            fees = fee_junior;
		                    	html_fees += "<tr><td>Annual Fee - Junior:</td><td class='text-right'>$"+ fee_junior +"</td></tr>"; 
	                        }
	                        else {
	                            fees = 0;
		                    	html_fees += "<tr><td>Annual Fee - Junior:</td><td class='text-right'>NONE</td></tr>"; 
	                        }
	                    } else {
	                        fees = fee_junior;
	                    	html_fees += "<tr><td>Annual Fee - Junior:</td><td class='text-right'>$"+ fee_junior +"</td></tr>"; 
	                    }
	                }
	
	                if (ctr == 1) {
	                    if (registrationType == "Family")
	                        applicant = 'Lead Applicant';
	                    else
	                        applicant = 'Applicant 1';
	                } else
	                    applicant = ('Applicant ' + ctr);
	                html = '<div class="u-1/4"><strong class="u-uppercase">' + applicant + '</strong><br />';
	                html += 'New Member';
	                html += '<br />Name: ' + e.find(".o-form-fname").val() + ' ' + e.find(".o-form-lname").val();
	                html += '<br />Email: ' + e.find(".o-form-email").val();
	                html += '<br />Phone: ' + e.find(".o-form-phone").val();
	                html += '<br />City: ' + e.find(".o-form-city").val();
	                html += '<br />Country: ' + e.find(".o-form-country").val();
	                html += '<br />DOB: ' + e.find(".o-form-dob").val();
	                html += '<br />Sex: ' + e.find(".o-form-sex input[type='radio']:checked").val();
	                html += '<br />Occupation: ' + e.find(".o-form-occupation").val();
	                html += '<br />' + e.find(".o-form-membership-type").val();
	                html += '<br />Boot Locker: ';
	                if (e.find(".o-form-boot-locker").is(':checked')) {
	                    html += 'Y';
	                    fees += fee_boot_locker;
                    	html_fees += "<tr><td>Boot Locker:</td><td class='text-right'>$"+ fee_boot_locker +"</td></tr>"; 
	                }
	                else
	                    html += 'N';
	                html += '<br />Ski Locker: ';
	                if (e.find(".o-form-key-locker").is(':checked')) {
	                    html += 'Y';
	                    fees += fee_key_locker;
                    	html_fees += "<tr><td>Ski Locker:</td><td class='text-right'>$"+ fee_key_locker +"</td></tr>"; 
	                } else
	                    html += 'N';
	                html += '<br />Season Pass: ';
	                if (e.find(".o-form-all-season-pass").is(':checked')) {
	                    html += 'Y';
	                    if (e.find(".o-form-membership-type").val() == "Adult") {
	                    	fees += fee_all_season_adult;
	                    	html_fees += "<tr><td>Season Pass - Adult:</td><td class='text-right'>$"+ fee_all_season_adult +"</td></tr>"; 
	                    } 
	                    else {
	                    	fees += fee_all_season_junior;
	                    	html_fees += "<tr><td>Season Pass - Junior:</td><td class='text-right'>$"+ fee_all_season_junior +"</td></tr>"; 
	                    }
	                } else
	                    html += 'N';
	                
	                html += '<br /><br /><table class="table">'+ html_fees +'<tr><td><strong>Subtotal:</strong></td><td class="text-right"><strong>$' + fees + '</strong></td></tr></table>';
	                html += '</div>';
	
	                ctr++;
	                total_fees += fees;
	
	                $('.o-summary').append(html);
	            });
	
	            $('.o-summary').append('<br /><br /><div class="o-total">Total Fees: $' + total_fees + '</div>');
            }
        }
    });

    $("#form-register").submit(function(event) {
        // if family registration, need at least 2 members 
        if ($('#form_membershipType').val() == 'Family' && (members < 2 || junior < 1 || adult < 1)) {
            alert("Family membership requires at least two (2) members of at least one (1) adult and (1) junior.")
            event.preventDefault();
        } else {
            $('.o-submit-button').html('Sending Application');
            var recaptcha = grecaptcha.getResponse();
            var data = $(this).serialize();
            $.ajax({
                url: "/about-br/of-interest/membership/Register",
                data: data+"&g-recaptcha-response="+recaptcha,
                type: "POST",
                success: function(data) {
                    if (data == true) {
                        $('.o-submit-button').html('Application Sent');
                        $('.o-success').removeClass('hidden').slideDown();

                        // set PxPay variables
                        $("#px_name").val($(".o-form-fname").first().val() + ' ' + $(".o-form-lname").first().val());
                        $("#px_email").val($(".o-form-email").first().val());
                        $("#px_membership_type").val($(".o-form-membership-type").first().val());
                        $("#px_total").val(total_fees * 1.025);
                    } else {
                        $('.o-submit-button').html('Submit Application').removeAttr('disabled');
                        grecaptcha.reset();
                        alert(data);
                    }
                }
            })
            event.preventDefault();
        }
    });

    $("#form-login-new").submit(function(event) {
        var e = $(this);
        if (e.find("[name=Password]").val() != e.find("[name=Password2]").val() || e.find("[name=Password]").val() == '' || e.find("[name=Password2]").val() == '') {
            $("#msgDivNew").html("Passwords do not match.");
        } else {
            e.find('.button').html('Verifying Account').prop('disabled', 'true');
            var data = $(this).serialize();
            $.ajax({
                url: "/members-area/LoginNew",
                data: data,
                type: "POST",
                success: function(data) {
                    if (data == true) {
                        // redirect
                        window.location.replace('/members-area/');
                    } else {
                        e.find('.button').html('Create Account').removeAttr('disabled');
                        $("#msgDivNew").html(data);
                    }
                }
            });
        }
        event.preventDefault();
    });

    $("#form-login-member").submit(function(event) {
        var e = $(this);

        e.find('.button').html('Verifying Account').prop('disabled', 'true');
        var data = $(this).serialize();
        $.ajax({
            url: "/members-area/LoginMember",
            data: data,
            type: "POST",
            success: function(data) {
                if (data == true) {
                    // redirect
                    window.location.replace('/members-area/');
                } else {
                    e.find('.button').html('Login').removeAttr('disabled');
                    $("#msgDivMember").html(data);
                }
            }
        });
        event.preventDefault();
    });

    $("#form-reset").submit(function(event) {
        var e = $(this);

        e.find('.button').html('Verifying Account').prop('disabled', 'true');
        var data = $(this).serialize();
        $.ajax({
            url: "/members-area/password-reset/PasswordReset",
            data: data,
            type: "POST",
            success: function(data) {
                if (data == true) {
                    e.find('.button').html('Password Sent');
                    $("#msgDiv").html("Please check your email.");
                } else {
                    e.find('.button').html('Send Request').removeAttr('disabled');
                    $("#msgDiv").html(data);
                }
            }
        });
        event.preventDefault();
    });

    $("#form-change").submit(function(event) {
        var e = $(this);

        e.find('.button').html('Verifying Password').prop('disabled', 'true');
        var data = $(this).serialize();
        $.ajax({
            url: "/members-area/password-change/PasswordChange",
            data: data,
            type: "POST",
            success: function(data) {
                if (data == true) {
                    e.find('.button').html('Password updated');
                    $("#msgDiv").html("");
                } else {
                    e.find('.button').html('Change Password').removeAttr('disabled');
                    $("#msgDiv").html(data);
                }
            }
        });
        event.preventDefault();
    });
}(jQuery));

function calculateAge(dob) {
    var date = new Date();
    var year = parseInt(date.getFullYear());
    var dob_year = parseInt(dob.substring(6));
    var age = year - dob_year;
    return age;
}


var width = jQuery(window).width();
var adult, junior;

jQuery(window).load(function() {
    jQuery('.section').imagesLoaded(function() {
        if (window.location.hash) {
            jQuery('html,body').animate({ scrollTop: jQuery(window.location.hash).offset().top - 200 }, 500);
            jQuery(window.location.hash).trigger('click');
        }
    });
});