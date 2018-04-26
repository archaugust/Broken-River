<!DOCTYPE html>


<!--[if !IE]><!-->
<html lang="$ContentLocale">
<!--<![endif]-->
<!--[if IE 6 ]><html lang="$ContentLocale" class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html lang="$ContentLocale" class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html lang="$ContentLocale" class="ie ie8"><![endif]-->
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400" rel="stylesheet">
	<% require themedCSS('reset') %>
	<% require themedCSS('form') %>
	<% require themedCSS('typography') %>
	<% require themedCSS('layout') %>
	<% require themedCSS('responsive') %>
	<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="$ThemeDir/images/favicon.ico" />
</head>
<body class="$ClassName<% if not $Menu(2) %> no-sidebar<% end_if %>" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16854795-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<% include Header %>
<div class="main typography" role="main">
	<% if StatusMessage %>
		<% control StatusMessage %>
		<div id="flash" class="$Status">$Message</div>
		<% end_control %>
	<% end_if %>			
	$Layout
</div>
<% include Footer %>

<% require javascript('framework/thirdparty/jquery/jquery.js') %>
<%-- Please move: Theme javascript (below) should be moved to mysite/code/page.php  --%>
<script type="text/javascript" src="{$ThemeDir}/javascript/script.js"></script>
<script type="text/javascript" src="{$ThemeDir}/javascript/masonry.pkgd.min.js"></script>

<script type="text/javascript" src="{$ThemeDir}/javascript/slider/jquery-ui.min.slider.js"></script>
<link rel="stylesheet" type="text/css" href="{$ThemeDir}/javascript/slider/jquery-ui.min.slider.css">

<script type="text/javascript" src="{$ThemeDir}/javascript/magnific/jquery.magnific-popup.js"></script>
<link rel="stylesheet" type="text/css" href="{$ThemeDir}/javascript/magnific/magnific-popup.css">

<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js"></script>
<script type="text/javascript" src="{$ThemeDir}/javascript/custom.js?id=4"></script>

</body>
</html>
