<div class="inner">
	<div class="content-container">
		<article>
			<div class="content">
				$Content
				<% if $MembersOnly %>
					<% if $isLogged %>
						$EmbedCode
					<% else %>
						Please login as a member to view this page.
					<% end_if %>
				<% else %>
					$EmbedCode
				<% end_if %>
			</div>
		</article>
	</div>
</div>

<% if $Sections %>
	<% include Sections %>
<% end_if %>		