<div class="subscription">
	<div class="inner">
		<h2>Hot deals & the latest news via the Powderlines E-Bulletin</h2>
		<p>Receive the latest news from the snowy slopes - it's free and comes straight to your inbox about once a week throughout winter.</p>
		<% if $getSubscriptionSent() %>
			<p>You have been subscribed</p>
			<a class="back" href="$Link">Return</a>
		<% else %>
			$SubscriptionForm
		<% end_if %>
	</div>
</div>