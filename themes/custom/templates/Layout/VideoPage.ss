<div class="inner">
	<div class="content">$Content</div>
	
	<% if $VideoCategories %>
		<% loop $VideoCategories %>
		<div class="video-category">
			<% if $Content %><div class="content">$Content</div><% end_if %>
			
			<div class="player">
				<% loop $Videos.Sort(Date, DESC) %>
					<div class="v{$ID} video <% if $Feature %> current<% end_if %>" data-id="{$ID}">
						<% if $EmbedCode %><div class="video-embed">$EmbedCode.Value</div><% end_if %>
						<p class="date"><% if $Subtitle %>$Title<% else %>$Date.format('j F, Y')<% end_if %></p>
						<p class="title"><% if $Subtitle %>$Subtitle<% else %>$Title<% end_if %></p>
					</div>
				<% end_loop %>
			</div>
		
			<% if $Videos %>
				<div class="videos">
					<% loop $videosByDate() %>
						<div class="video video-thumb video-nav" id="v{$ID}">
							<a href="#" class="image">$Thumbnail.CroppedImage(263,148)</a>
							<p class="date"><% if $Subtitle %>$Title<% else %>$Date.format('j F, Y')<% end_if %></p>
							<p class="title"><% if $Subtitle %>$Subtitle<% else %>$Title<% end_if %></p>
						</div>
					<% end_loop %>
					<div class="clear"></div>
				</div>
			<% else %>
				<p>There are no videos in this section.</p>
			<% end_if %>
		</div>
		<% end_loop %>
	<% end_if %>
</div>	
