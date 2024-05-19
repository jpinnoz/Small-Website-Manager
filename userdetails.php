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
	
		$oldUserName = $_SESSION['user_name'];
		$newUserName = $_POST['fusername'];
		$firstName = $_POST['ffirstname'];
		$lastName = $_POST['flastname'];
			
		if ($oldUserName == $newUserName) {
			$query2 = "UPDATE `Users` SET `First_Name`='$firstName',`Last_Name`='$lastName' WHERE `User_Name`='$oldUserName'";
			mysqli_query($cxn,$query2);
			
			$url1 = "usersettings.php";
			$location = "Location: ".$url1;
			header($location);
			die();
		} else {
			$query1 = "SELECT `User_Name` FROM `Users` WHERE `User_Name`='$newUserName'";
			$result1 = mysqli_query($cxn,$query1);
			if ($row1 = mysqli_fetch_assoc($result1)) {
				echo "<div class='message'>Username \"$newUserName\" already taken!</div>";
			} else {
				$query2 = "UPDATE `Users` SET `First_Name`='$firstName',`Last_Name`='$lastName',`User_Name`='$newUserName' WHERE `User_Name`='$oldUserName'";
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
} else {
	if (isset($_SESSION['user_name'])) {
		$userName = $_SESSION['user_name'];
		$query1 = "SELECT `First_Name`, `Last_Name`, `User_Name` FROM `Users` WHERE `User_Name`='$userName'";
		$result1 = mysqli_query($cxn,$query1);
		$row1 = mysqli_fetch_assoc($result1);
		$firstName = $row1['First_Name'];
		$lastName = $row1['Last_Name'];
	
		echo "<h3>User Details</h3>
		<div>
		<form action='".htmlentities($_SERVER['PHP_SELF'])."' method='post'>
		<table>
		<tr><td>First Name: </td><td><input type='text' name='ffirstname' value='$firstName'></td></tr>
		<tr><td>Last Name: </td><td><input type='text' name='flastname' value='$lastName'></td></tr>
		<tr><td>Username: </td><td><input type='text' name='fusername' value='$userName'></td></tr>";
		// <tr><td>eMail: </td><td><input type='text' name='femail'></input></td></tr>
		echo "</table>
		<input type='hidden' id='submitCode' name='submitCode' value='User_Details'>
		<input type='submit' name='Button' value='Update' />
		<input type='submit' name='Button' value='Cancel' />
		</form>
		<br>
		</div>\r\n";
	} else {
		echo "<div class='error'>This is a restricted area. You must log in to access!</div>";
	}
}
	
?>
</article>
<?php
include ("footer.inc");
?>