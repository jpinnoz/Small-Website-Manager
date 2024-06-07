<?php
include ("db_connect.inc");
session_start();

include ("header.inc");
include ("navbar.inc");
?>
<article id='main'>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="User_Details" AND isset($_SESSION['user_name'])) {
	if ($_POST['Button']=="Update") {
		$firstName = $_POST['ffirstname'];
		$lastName = $_POST['flastname'];
		$userName = $_SESSION['user_name'];
		
		if (!preg_match("/^[A-Za-z\-\'\ ]{1,50}$/", $firstName) OR !preg_match("/^[A-Za-z\-\'\ ]{1,50}$/", $lastName)) {
			$errormessage .= "<div class='error'>You may only use letters, hyphens or apostraphes! Minumum length is 1, maximum length is 50!</div><p>\r\n";
		} else {
			$query2 = "UPDATE `Users` SET `First_Name`='$firstName',`Last_Name`='$lastName' WHERE `User_Name`='$userName'";
			mysqli_query($cxn,$query2);
			
			$url1 = "usersettings.php";
			$location = "Location: ".$url1;
			header($location);
			die();
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
	$query1 = "SELECT `First_Name`, `Last_Name`, `User_Name` FROM `Users` WHERE `User_Name`='$userName'";
	$result1 = mysqli_query($cxn,$query1);
	$row1 = mysqli_fetch_assoc($result1);
	$firstName = $row1['First_Name'];
	$lastName = $row1['Last_Name'];

	echo "$errormessage\r\n
	<h3>User Details</h3>\r\n
	<div>\r\n
	<form action='".htmlentities($_SERVER['PHP_SELF'])."' method='post'>\r\n
	<table>\r\n
	<tr><td>First Name: </td><td><input type='text' name='ffirstname' value='$firstName'></td></tr>\r\n
	<tr><td>Last Name: </td><td><input type='text' name='flastname' value='$lastName'></td></tr>\r\n
	</table>\r\n
	<input type='hidden' id='submitCode' name='submitCode' value='User_Details'>\r\n
	<input type='submit' name='Button' value='Update' />\r\n
	<input type='submit' name='Button' value='Cancel' />\r\n
	</form>\r\n
	<br>\r\n
	</div>\r\n";
} else {
	echo "<div class='error'>This is a restricted area. You must log in to access!</div>";
}

?>
</article>
<?php
include ("footer.inc");
?>