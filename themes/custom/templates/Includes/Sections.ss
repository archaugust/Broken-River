<div class="sections">
	<% loop $sortedSections() %>
		<div <% if $Link %>id="$Link"<% end_if %> class="page-section $FirstLast typography 
				<% if $BannerImage %>banner-image <% else %>inner not-banner<% end_if %> 
				<% if not $Image %>content-only <% else %>has-image <% end_if %>
				<% if $odd %>image-right <% else %>image-left <% end_if %>
				<% if $Link %>linked <% end_if %>
			">
				<% if $Image %>
					<% if $BannerImage %>
						<div class="image">$Image.SetWidth(1980)</div>
					<% else %>
						<div class="image" style="background-image: url('$Image.SetWidth(1980).Link')">$Image.SetWidth(1980)</div>
					<% end_if %>
				<% end_if %>
				<div class="content <% if $BannerImage %>inner<% end_if %>">
					<% if $BannerImage %><div><% end_if %>
						<% if $Image %><h2>$Title</h2><% end_if %>
						$Content
					<% if $BannerImage %></div><% end_if %>
				</div>
		</div>
		<div class="clear"></div>
	<% end_loop %>
</div>