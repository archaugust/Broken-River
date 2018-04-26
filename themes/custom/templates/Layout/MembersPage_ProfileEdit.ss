<script type="text/javascript" src="framework/thirdparty/jquery-ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="framework/thirdparty/jquery-ui-themes/smoothness/jquery-ui.css">
<% include MembersMenu %>

<div class="inner">
	<div class="content-container">
				<% if $isLogged %>
					<h2>Edit Profile</h2>

                    <form method="post" class="u-1/1">
                    <div class="o-membership-form">
                        <input type="hidden" name="MembershipNumber" value="$Profile.Member.MembershipNumber" />
                        <div class="u-1/4">
                            <label for="form_fname"><span>1.</span> First Name *</label>
                            <input class="required o-form-fname" type="text" name="Members[0][FirstName]" value="$Profile.Member.FirstName" required="required" />
                        </div><div class="u-1/4">
                            <label for="form_lname"><span>2.</span> Last Name *</label>
                            <input class="required o-form-lname" type="text" name="Members[0][LastName]" value="$Profile.Member.LastName" id="form_lname" required="required" />
                        </div><div class="u-1/4">
                            <label for="form_email"><span>3.</span> Email *</label>
                            <input type="email" class="o-form-email" name="Members[0][Email]" id="form_email" value="$Profile.Member.Email" required="required" />
                        </div><div class="u-1/4">
                            <label for="form_phone"><span>4.</span> Phone</label>
                            <input type="text" class="o-form-phone" name="Members[0][Phone]" value="$Profile.Member.Phone" id="form_phone" />
                        </div><div class="u-1/4">
                            <label for="form_city"><span>5.</span> City Where You Live</label>
                            <input type="text" class="o-form-city" name="Members[0][City]" value="$Profile.Member.City" id="form_city" />
                        </div><div class="u-1/4">
                            <label for="form_country"><span>6.</span> Country</label>
                            <input type="text" class="o-form-country" name="Members[0][Country]" value="$Profile.Member.Country" id="form_country" />
                        </div><div class="u-1/4">
                            <label for="form_dob"><span>7.</span> Date of Birth *</label>
                            <input type="text" class="form_dob required o-form-dob" name="Members[0][DateOfBirth]" value="$Profile.Member.DateOfBirth" id="form_dob" required="required" />
                        </div><div class="u-1/4">
                            <label><span>8.</span> Sex</label>
                            <div class="u-radio o-form-sex">
                            <span class='radio'>
                            <input type="radio" name="Members[0][Sex]" id="form_sex_1" value="M" <% if $Profile.Member.Sex == "M" %>selected="selected"<% end_if %> />
                            <label for="form_sex_1"><span></span> M</label>
                            </span>
                            <span class='radio'>
                            <input type="radio" name="Members[0][Sex]" id="form_sex_2" value="F" <% if $Profile.Member.Sex == "F" %>selected="selected"<% end_if %> />
                            <label for="form_sex_2"><span></span> F</label>
                            </span>
                            </div>
                        </div><div class="u-1/2">
                            <label for="form_occupation"><span>9.</span> Occupation</label>
                            <input name="Members[0][Occupation]" class="o-form-occupation" value="$Profile.Member.Occupation" id="form_occupation" />
                        </div><div class="u-1/1">
                            <label for="form_association"><span>10.</span> Previous Association with Broken River. Have you skied or boarded at BR? Do you know anyone in the club? How did you contact us?</label>
                            <textarea name="Members[0][Association]" class="o-form-association" id="form_association">$Profile.Member.Association</textarea>
                        </div><div class="u-1/1">
                            <label><span>11.</span> Useful Skills. Our club benefits greatly from the input of our members and their skills. Please select one or more skills that apply.</label>
                            <div class="o-checkboxes">
                            <div class="u-1/4">
                                <input type="checkbox" name="Members[0][Skills][]" value="Administration" id="skills_Administration" <% if $hasSkill("Administration") %>checked="checked"<% end_if %> /><label for="skills_Administration"> Administration </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Carpentry" id="skills_Carpentry" <% if $hasSkill("Carpentry") %>checked="checked"<% end_if %> /><label for="skills_Carpentry"> Carpentry </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Electrical" id="skills_Electrical" <% if $hasSkill("Electrical") %>checked="checked"<% end_if %> /><label for="skills_Electrical"> Electrical </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Architecture" id="skills_Architecture" <% if $hasSkill("Architecture") %>checked="checked"<% end_if %> /><label for="skills_Architecture"> Architecture </label><br />
                            </div><div class="u-1/4">
                                <input type="checkbox" name="Members[0][Skills][]" value="Plumbing" id="skills_Plumbing" <% if $hasSkill("Plumbing") %>checked="checked"<% end_if %> /><label for="skills_Plumbing"> Plumbing </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Painting / Decorating" id="skills_Painting" <% if $hasSkill("Painting / Decorating") %>checked="checked"<% end_if %> /><label for="skills_Painting"> Painting / Decorating</label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Communications" id="skills_Communications" <% if $hasSkill("Communications") %>checked="checked"<% end_if %> /><label for="skills_Communications"> Communications </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Sewing" id="skills_Sewing" <% if $hasSkill("Sewing") %>checked="checked"<% end_if %> /><label for="skills_Sewing"> Sewing </label><br />
                            </div><div class="u-1/4">
                                <input type="checkbox" name="Members[0][Skills][]" value="Engineering" id="skills_Engineering" <% if $hasSkill("Engineering") %>checked="checked"<% end_if %> /><label for="skills_Engineering"> Engineering </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Computers / IT" id="skills_Computers" <% if $hasSkill("Computers / IT") %>checked="checked"<% end_if %> /><label for="skills_Computers"> Computers / IT </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Electronics" id="skills_Electronics" <% if $hasSkill("Electronics") %>checked="checked"<% end_if %> /><label for="skills_Electronics"> Electronics </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Signwriting" id="skills_Signwriting" <% if $hasSkill("Signwriting") %>checked="checked"<% end_if %> /><label for="skills_Signwriting"> Signwriting </label>
                            </div><div class="u-1/4">
                                <input type="checkbox" name="Members[0][Skills][]" value="Draughting" id="skills_Draughting" <% if $hasSkill("Draughting") %>checked="checked"<% end_if %> /><label for="skills_Draughting"> Draughting </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="First Aid / Medic" id="skills_First-Aid" <% if $hasSkill("First Aid / Medic") %>checked="checked"<% end_if %> /><label for="skills_First-Aid"> First Aid / Medic </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Construction" id="skills_Construction" <% if $hasSkill("Construction") %>checked="checked"<% end_if %> /><label for="skills_Construction"> Construction </label><br />
                                <input type="checkbox" name="Members[0][Skills][]" value="Marketing" id="skills_Marketing" <% if $hasSkill("Marketing") %>checked="checked"<% end_if %> /><label for="skills_Marketing"> Marketing </label>
                            </div><div class="u-1/4">
                                <input type="checkbox" name="Members[0][Skills][]" value="HT Licence" id="skills_HT-Licence" <% if $hasSkill("HT Licence") %>checked="checked"<% end_if %> /><label for="skills_HT-Licence"> HT Licence </label>
                            </div><div class="u-1/2">
                                <input type="checkbox" name="Members[0][Skills][]" value="Heavy Machinery experience / licence" <% if $hasSkill("Heavy Machinery experience / licence") %>checked="checked"<% end_if %> id="skills_Heavy-Machinery" /><label for="skills_Heavy-Machinery"> Heavy Machinery experience / licence </label>
                            </div>			
                            </div>
                        </div><div class="u-1/1">
                            <label for="form_other"><span>12.</span> Other Pertinent Info. Anything else relating to this application that you think we should know about?</label>
                            <textarea name="Members[0][OtherInfo]" class="o-form-other" id="form_Other"></textarea>
                        </div>
                    </div>
                    <button class="button o-submit-button" type="submit">Save Changes</button>
                    </form>
				<% end_if %>
			</div>
		</article>
		
</div>
</div>