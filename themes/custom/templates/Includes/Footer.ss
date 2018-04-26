<footer class="footer" role="contentinfo">
	<div class="inner">
		<div class="columns">
			<div class="top-columns">
				<div class="column typography footer-nav">
					<h4><a href="$getReportsLink()">SNOW REPORT</a></h4>
				</div>
				<div class="column typography">
					<h4><a href="$getContactLink()">CONTACT INFO</a></h4>
				</div>
				<div class="column typography">
					<h4><a href="$getAccommodationLink()">ACCOMMODATION</a></h4>
				</div>
				<div class="column typography last">
					<h4><a href="$getBlogLink()">NEWS</a></h4>
				</div>
			</div>
			
			<div class="column typography footer-nav">
				<p class="footer-white">QUICK LINKS</p>
				<hr />
				<ul>
					<% loop $getQuickLinks() %>
						<li><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
					<% end_loop %>
				</ul>
			</div>
			<div class="column typography">
				$SiteConfig.FooterContactDetails
			</div>
			<div class="column typography">
				$SiteConfig.FooterAccomDetails
			</div>
			<div class="column typography last">
				$SiteConfig.FooterOperatingHours
			</div>
		</div>
		
		<a href="/stay-with-us/book-your-stay/" class="button book">Book Accommodation</a>
		
		<% include Social %>
		<a href="http://www.skitheclubbies.nz" class="stc" target="_blank"><img src="{$ThemeDir}/images/STC-Logo.png"></a>
		<a class="to-top" href="#">To Top</a>
		<div class="copyright">&copy; Broken River Ski Club $Now.format(Y) | <a href="http://spinifexnz.com/">Website by Spinifex</a> </div>
	</div>
</footer>