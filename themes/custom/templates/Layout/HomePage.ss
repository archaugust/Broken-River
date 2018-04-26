<% require javascript(themes/custom/javascript/jquery-1.10.2.js) %>
<% require javascript(themes/custom/javascript/instafeed.min.js) %>
<% require javascript(themes/custom/javascript/home.js) %>

<% if $Tiles %>
	<div class="tiles">
		<% loop $Tiles %>
			<div class="tile"><% if $Link %><a href="$Link"><% end_if %><div class="hover">
					<div class="tile-content">
						<h2>$Title</h2>
						<% if $SubHeading %><p class="sub-heading">$SubHeading</p><% end_if %>
						<p>$Content</p>
						<p><span class="button">$ButtonText</span></p>
					</div>
					<div class="fade"></div>
				</div>
				$Image<% if $Link %></a><% end_if %></div>
		<% end_loop %>
	</div>
<% end_if %>

<% if $Sections %>
	<div class="sections">
		<% loop $sortedSections() %>
			<div class="page-section banner-image <% if $Link %>linked<% end_if %>">
				<% if $Link %>
					<a href="$Link">
				<% end_if %>
					<% if $Image %>
						<div class="image">$Image</div>
					<% end_if %>
					<div class="content inner">
						<div>
							<h2>$Title</h2>
							$Content
						</div>
					</div>
					<div class="fade <% if OrangeFade %>orange<% end_if %>"></div>
				<% if $Link %>
					</a>
				<% end_if %>
			</div>
		<% end_loop %>
	</div>
<% end_if %>

<div class="orange-strip">
	<p><img src="$ThemeDir/images/icon_instagram_white.png" alt="instagram"> Follow us: @brokenriver</p>
</div>
<div id="instagram" class=""></div>

<div class="inner">
	<div class="content-container">
		<article>
			<div class="content">$Content</div>
		</article>
	</div>
</div>

<% include Subscription %>
