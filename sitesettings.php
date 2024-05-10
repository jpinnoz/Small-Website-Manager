<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");

echo "
	<article id='main'>\r\n
	<h3>Site Settings</h3>\r\n
	<div>\r\n
	<ul>\r\n
	<li><a href=\"sitedetails.php\">Site Details</a></li>\r\n
	<li><a href=\"activepagelist.php\">Active Pages Listing</a></li>\r\n
	<li><a href=\"deletedpagelist.php\">Deleted Pages Listing</a></li>\r\n
	</ul>\r\n
	</div>\r\n
	</article>";

include ("footer.inc");
?>