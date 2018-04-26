<% if $Content %>
	<div class="inner">
		<div class="content">$Content</div>
	</div>
<% end_if %>

<div class="gallery">

	<div class="inner">
		<h1>Photo Gallery $Now.format(Y)</h1>
		<p>$GalleryText</p>
	</div>
	<% if $getPhotos('current') %>
		<div class="photos">
			<% loop $getPhotos('current') %>
				<% include Photo %>
			<% end_loop %>
			<div class="clear"></div>
		</div>
	<% else %>
		<div class="inner"><p>There are currently no photos for this year</p></div>
	<% end_if %>
	
	<% if $getPhotos('archived') %>
		<div class="inner">
			<h1>Photo Archive</h1>
			<p>$ArchiveText</p>
		</div>
		<div class="photos">
			<% loop $getPhotos('archived') %>
				<% include Photo %>
			<% end_loop %>
			<div class="clear"></div>
		</div>
	<% end_if %>
</div>

<% if $Sections %>
	<% include Sections %>
<% end_if %>		