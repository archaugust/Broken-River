<nav class="primary">
	<span class="nav-open-button">²</span>
	<ul>
		<% loop $Menu(1) %>
			<li class="$LinkingMode <% if $hasChildren() %> menu-parent<% end_if %>">
				$ouputMenuLink()
				<% if $hasChildren() %>
					<ul class="dropdown">
						<% loop Children %>
							<li class="column">
								$ouputMenuLink()
								<% if $Thumbnail %><a class="thumb" href="$Link">$Thumbnail</a><% end_if %>
								<% if $ShortDescription %><p>$ShortDescription</p><% end_if %>
								<ul>
									<% loop Children %>
										<li><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
									<% end_loop %>
								</ul>
							</li>
						<% end_loop %>
					</ul>
				<% end_if %>
			</li>
		<% end_loop %>
	</ul>
</nav>
