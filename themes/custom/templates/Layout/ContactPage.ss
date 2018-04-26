<div class="content-container inner">
	<div class="content">
		$Content
	</div>
	<div class="o-layout">
		<div class="o-layout__item u-1/2">
			<div class="contact-form">
				<% if $getMailSent = true %>
					<div class="sent_message">
						<p>Thanks, your message has been sent and we'll be in touch soon.</p>
						<a class="back" href="$Link">Return</a>
					</div>
				<% else %>
					$ContactForm
				<% end_if %>
			</div>
		</div><div class="o-layout__item u-1/2">
			<div class="contact-details">
				$ContactDetails
				<% include Social %>
			</div>
		</div>
	</div>
</div>
<div class="clear"></div>

<% include Subscription %>
