<div class="inner typography line">
	<div class="content-container">
		<div class="content">$Content</div>
		<div class="jobs">
			<% loop $Jobs %><div class="job $BackgroundColour">
					<div class="short">
						<span class="expand">expand</span>
						<h3>$Name</h3>
						<p class="date">Posted $Date.format('j F, Y')</p>
					</div>
					<div class="more">
						<p>$Description</p>
						<a class="button" href="/about-br/need-to-know/contact-us/">Contact Us</a>
					</div>
				</div><% end_loop %>
		</div>
	</div>
</div>