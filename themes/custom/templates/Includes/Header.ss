<header class="header" role="banner">
	<div class="banner">
		<a href="$BaseHref" class="logo" rel="home">
			<img src="$ThemeDir/images/logo.png" />
			<img class="mobile-logo" src="$ThemeDir/images/logo_mobile.png" width="124" height="17" />
		</a>
		<% include Navigation %>
		<div class="header-right">
			<div class="top">
				<div class="links">
				<a href="/about-br/of-interest/membership/" class="button">Membership</a>
				<a href="/stay-with-us/book-your-stay/" class="button">Book Accommodation</a>
				</div>
				<div class="header-contact-wrapper">
					<a href="#" class="open-contacts"></a>
					<div class="header-contact typography">
						$SiteConfig.HeaderContactDetails
					</div>
				</div>
			</div>			
			<% if $RemoveReports != true %>
			<div class="weather<% if $hideReports %> hidden<% end_if %>">
				<div class="cell icon"><% if $getWeatherBrief() != "" %><img src="$ThemeDir/images/weather_report/white/{$getWeatherBrief()}.png" /><% end_if %></div>	
				<div class="cell"><strong>Avg Base:</strong> {$calcSnowAvg()}cm</div>
				<div class="cell"><strong>Last Snowfall:</strong> $getLatestFallDate()</div>
				<div class="cell"><strong><a href="$getReportsLink()">Webcam & Snow Report ></a></strong></div>
				<div class="cell"><strong><a href="http://www.metservice.com/skifields/broken-river">Met Forecast ></a></strong></div>
			</div>
			<% end_if %>
		</div>
		<% if $SearchForm %>
			<span class="search-dropdown-icon">L</span>
			<div class="search-bar">
				$SearchForm
			</div>
		<% end_if %>
	</div>
	<a class="mobile-reports-link" href="$getReportsLink()">Webcam & Snow Report ></a>
</header>
<% if $slides %>
	<% include Slideshow %>
<% end_if %>
