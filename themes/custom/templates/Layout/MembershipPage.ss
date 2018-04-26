<script type="text/javascript" src="framework/thirdparty/jquery-ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="framework/thirdparty/jquery-ui-themes/smoothness/jquery-ui.css">

<div class="c-membership">
<div class="inner">
	<div class="content-container">
		<article>
			<div class="content">$Content
				<p align="center"><br />
					<a class="button" href="#form-register">Join Online Now</a> <a class="button" href="$RegistrationFormPdf.Link" target="_blank">Download Printable Membership Form</a>
				</p>				
			</div>
		</article>
	</div>
</div>

<% if $Sections %>
	<h2 align="center">$SectionsTitle</h2><br /><br />
	<% include Sections %>
<% end_if %>

<div class="inner">
	<div class="content-container">
		<div class="content" align="center">
			$ContentMiddle
		</div>
	</div>
</div>

<div class="banner-image">
	$BannerMiddle.SetWidth(1980)
</div>

<div class="inner">
	<div class="content-container">
		<div class="content" align="center">
			$ContentBottom
		</div>
		<div class="content">
			<% include MembershipForm %>
			<a id="more"></a>
		</div>
	</div>
</div>
</div>