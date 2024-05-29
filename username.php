<?php
include ("db_connect.inc");
session_start();

include ("header.inc");
include ("navbar.inc");
?>
<article id='main'>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="User_Name" AND isset($_SESSION['user_name'])) {
	if ($_POST['Button']=="Update") {
	
		$oldUserName = $_SESSION['user_name'];
		$newUserName = $_POST['fusername'];
			
		if ($oldUserName == $newUserName) {
			$url1 = "usersettings.php";
			$location = "Location: ".$url1;
			header($location);
			die();
		} else {
			$query1 = "SELECT `User_Name` FROM `Users` WHERE `User_Name`='$newUserName'";
			$result1 = mysqli_query($cxn,$query1);
			if ($row1 = mysqli_fetch_assoc($result1)) {
				echo "<div class='error'>Username \"$newUserName\" already taken! Please enter another user name...</div>";
			} else {
				$query2 = "UPDATE `Users` SET `User_Name`='$newUserName' WHERE `User_Name`='$oldUserName'";
				mysqli_query($cxn,$query2);
				$_SESSION['user_name'] = $newUserName;
				
				$url1 = "usersettings.php";
				$location = "Location: ".$url1;
				header($location);
				die();
			}
		}
	} elseif ($_POST['Button']=="Cancel") {
		$url = "usersettings.php";
		$location = "Location: ".$url;
		header($location);
		die();	
	}
}

if (isset($_SESSION['user_name'])) {
	$userName = $_SESSION['user_name'];

	echo "<h3>User Name</h3>\n\r
	<div>\n\r
	<form action='".htmlentities($_SERVER['PHP_SELF'])."' method='post'>\n\r
	<table>\n\r
	<tr><td>Username: </td><td><input type='text' name='fusername' value='$userName'></td></tr>\n\r
	</table>\n\r
	<input type='hidden' id='submitCode' name='submitCode' value='User_Name'>\n\r
	<input type='submit' name='Button' value='Update' />\n\r
	<input type='submit' name='Button' value='Cancel' />\n\r
	</form>\n\r
	<br>\n\r
	</div>\r\n";
} else {
	echo "<div class='error'>This is a restricted area. You must log in to access!</div>";
}
	
?>
</article>
<?php
include ("footer.inc");
?>