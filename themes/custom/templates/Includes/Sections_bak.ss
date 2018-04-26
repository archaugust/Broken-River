<div class="sections">
	<% loop $sortedSections() %>
		<div class="page-section $FirstLast typography 
				<% if $BannerImage %>banner-image <% else %>inner not-banner<% end_if %> 
				<% if not $Image %>content-only <% else %>has-image <% end_if %>
				<% if $odd %>image-right <% else %>image-left <% end_if %>
				<% if $Link %>linked <% end_if %>
			">
			<% if $Link %>
				<a href="$Link">
			<% end_if %>
				<% if $Image %>
					<% if $BannerImage %>
						<div class="image">$Image</div>
					<% else %>
						<div class="image" style="background-image: url('$Image.Link')">$Image</div>
					<% end_if %>
				<% end_if %>
				<div class="content <% if $BannerImage %>inner<% end_if %>">
					<% if $BannerImage %><div><% end_if %>
						<% if $Image %><h2>$Title</h2><% end_if %>
						$Content
					<% if $BannerImage %></div><% end_if %>
				</div>
			<% if $Link %>
				</a>
			<% end_if %>
		</div>
		<div class="clear"></div>
	<% end_loop %>
</div>