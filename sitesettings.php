<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");

echo "<article id='main'>\r\n";

if ( isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) AND $_SESSION['auth_lev']==3 ) {
	echo "<h3>Site Settings</h3>\r\n
		<div>\r\n
		<ul>\r\n
		<li><a href=\"sitedetails.php\">Site Details</a></li>\r\n
		<li><a href=\"activepagelist.php\">Active Pages Listing</a></li>\r\n
		<li><a href=\"deletedpagelist.php\">Deleted Pages Listing</a></li>\r\n
		</ul>\r\n
		</div>\r\n";
} else {
	echo "<div class=\"error\">Restricted Area. You need administrative priviledges to access this page.</div>";
}

echo "</article>";

include ("footer.inc");
?>