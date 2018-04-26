<% require javascript(themes/custom/javascript/jquery-1.10.2.js) %>
<% require javascript(themes/custom/javascript/jquery.cycle2.js) %>
<% require javascript(themes/custom/javascript/jquery.cycle2.swipe.js) %>
<div class="slideshow-wrapper typography">
	<div class="cycle-slideshow"
		data-cycle-swipe="true"
		data-cycle-slides=".slide"
		>  
		
		<% loop $slides %>
			<div class="slide banner-image<% if $TopMargin %> u-banner-padding <% end_if %><% if $Link %> linked<% end_if %>">
				<% if $VideoEmbedCode %>
					<div class="video-slide">
						$VideoEmbedCode.Value
					</div>
				<% else %><% if $Link %><a href="$Link"><% end_if %><% if $ImageOverlay %><img class="image-overlay u-hidden" src="$ImageOverlay.Link" alt="$ImageOverlay.Title" /><% end_if %><img src="<% if $TotalItems > 1 %>$Image.CroppedImage(1980,900).Link<% else %>$Image.SetWidth(1980).Link<% end_if %>" data-caption="#$Image.ID"  alt="$Image.Title"/>
						<% if $Title %>
							<div class="content <% if $Arrow %>arrow <% end_if %>inner">
								<div>
									<h2>$Title</h2>
									<p>$Content</p>
								</div>
							</div>
						<% end_if %>
					<% if $Link %>
						</a>
					<% end_if %>
				<% end_if %>
			</div>
		<% end_loop %>
	</div>
	
</div>