<div class="inner">
	<div class="content-container">
		<article>
			<div class="content">$Content</div>
		</article>
			$Form
			$PageComments
	</div>
</div>

<div class="events inner">
	<div class="events-header">$Now.format(Y) Events Calendar</div>
	<% if $Events %>
		<% loop $eventsByDate() %>
			<div class="event">
				<div class="short">
					<span class="date">$Date.format(M jS)</span>
					<span class="middle"><strong>$Name</strong> - $Description</span>
					<span><a class="button event-more" href="#">More Info</a></span>
				</div>
				<div class="content">$Content</div>
			</div>
		<% end_loop %>
	<% end_if %>	
</div>
<% if $Sections %>
	<h1 class="u-header u-mb-70">Event Details</h1>
	<% include Sections %>
<% end_if %>		