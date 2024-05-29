<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");

echo "<article id='main'>\r\n";

if (isset($_SESSION['user_name'])) {
	echo "<h3>User Settings</h3>\r\n
		<div>\r\n
		<ul>\r\n
		<li><a href=\"userdetails.php\">User Details</a></li>\r\n
		<li><a href=\"username.php\">User Name</a></li>\r\n
		<li><a href=\"changepass.php\">Change Password</a></li>\r\n
		</ul>\r\n
		</div>\r\n";
} else {
	echo "<div class='error'>This is a restricted area. You must log in to access!</div>";
}

echo "</article>";

include ("footer.inc");
?>