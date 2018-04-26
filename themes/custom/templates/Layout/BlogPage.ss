<div class="inner">
	<div class="content">$Content</div>
	<% if $Children %>
		<div class="blogs">
			<div class="blog-sizer"></div>
		<% loop $blogsByDate() %>
			<div class="blog" id="$Title.CSSSafe">
				<div class="blog-inner">
					<div class="blog-short">
						<a class="image no-link" href="$Link">$Image.SetWidth(600)</a>
						<div class="blog-content">
							<h3><a href="$Link" class="no-link">$Title</a></h3>
							<p class="date">$formatDate()
								<a class="fb-share" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=#$AbsoluteLink">Share on Facebook</a>
							</p>
							$Description
						</div>
					</div>
					<div class="blog-full u-hidden">
						<% include NewsArticle %>
					</div>
				</div>
			</div>
		<% end_loop %>
		</div>
	<% end_if %>
	<div class="clear"></div>
</div>