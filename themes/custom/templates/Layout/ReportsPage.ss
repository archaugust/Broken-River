
<div class="inner">
	<div class="content-container typography">
		<div class="report-left">
			<h2>SNOW REPORT & LIVE WEBCAM</h2>
			<% if $getReport() %>
				<% loop $getReport() %>
					<p class="update-time">$getDateAndTime()</p>
					$getBrief()
					<hr />
					<div class="o-webcam-mobile"></div>
					<h5>Weather Conditions</h5>
					<p class="orange"><strong>{$getWeatherBrief()}, {$getWeatherTempurature()}&deg;C</strong></p>
					<p>$getWeatherDetail()</p>
					<hr />
					<h5>Snow Conditions</h5>
					<p class="orange"><strong>Average depth: {$calcSnowAvg()}cm</strong> ({$getMinSnow()}cm-{$getMaxSnow()}cm)</p>
					<p class="orange"><strong>Last snowfall:</strong> {$getLatestFall()}cm on $getLatestFallDate()</p>
					<p>$getSnowDetail()</p>
					<hr />
					<% loop $facilityTypes %>
						<h5>$name</h5>
						<div class="facilities">
							<% loop $facilities %>
								<div class="facility">
									<p>
										<span class="f-name">$name</span>
										<span class="f-status s{$getStatusCode()}">$getStatusLabel()</span>
									</p>
									<div class="u-brief">$getBrief()</div>
								</div>
							<% end_loop %>
						</div>
					<% end_loop %>
				<% end_loop %>
				<div class="report-links">
					<a class="pdf-link" target="_blank" href="{$Link}Pdf">PDF</a>
					<a class="fb-link" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=$AbsoluteLink">Share</a>
				</div>
				<hr />
				<p class="orange u-fs-15">
					<b>NOTE:</b> Broken River Ski Area does not undertake avalanche control or ski patrolling outside the ski area boundary. See our <b><a href="/about-br/mountain/trail-map-and-mountain-stats/">trail map</a></b> for ski area boundaries. Always be suitably prepared when skiing outside the ski area boundary - know the avalanche risks, carry avalanche safety gear and know how to use it. 
					Visit <b><a href="http://www.avalanche.net.nz" target="_blank">www.avalanche.net.nz</a></b> for the most recent avalanche conditions.</p>
			<% else %>
				<div class="inner">
					<p>There was a problem retrieving the weather feed. Please try again later.</p>
				</div>
			<% end_if %>
		</div>
		<div class="report-right">
			<div class="o-webcam-desktop">$webcam()</div>
			<% if $getReport() %>
				<% loop $getReport() %>
					<% if $information %>
						<h5>Upcoming Events</h5>
						<p>$information</p>
					<% end_if %>
					<% if $dailycomment %>
						<h5>Other Info</h5>
						<p>$dailycomment</p>
					<% end_if %>
				<% end_loop %>
			<% end_if %>
			<div class="content">$Content</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<% include Subscription %>