	<div class="image">$Image</div>
	<div class="blog-content">
		<h2>$Title</h2>
		<p class="date">$formatDate() 
			<a class="fb-share" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=#$AbsoluteLink">Share on Facebook</a>
		</p>
		<div class="o-layout">
			<div class="o-layout__item u-1/2">
				$Content
			</div>
			<div class="o-layout__item u-1/2 side-photos">
				<% loop SidePhotos %>
				$Photo.setWidth(600)
				<% end_loop %>
			</div>
		</div>
	</div>