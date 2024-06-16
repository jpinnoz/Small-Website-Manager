<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Log_Out") {
	session_destroy();
	unset($_SESSION);
}
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Small Website Manager</title>
	<!-- <meta charset="utf-8"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="desktop.css">
</head>

<body>
	<header>
<?php
		$query = "SELECT Value FROM Globals WHERE Global='Website Name'";
		$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
		if ($row = mysqli_fetch_assoc($result))
		{
			$websiteName = $row['Value'];
			echo $websiteName."\r\n";
		} else {
			$message .= "Website Name not found. Check site settings.";		
		}
?>
	<hr>
	</header>

<?php
if (isset($_SESSION['user_name']) AND $_SESSION['auth_lev'] >= 1) {
	echo "<div id='toptabbar' style='margin-bottom: 6pt'>\r\n";
	echo "<span style='text-align:left; margin-bottom: 0%;'>";
	echo "<nav id='hnav2' style='margin-bottom: 0%';>\r\n";
	echo $_SESSION['first_name']." you are logged in. \r\n";
	echo "Authority Level: ".$_SESSION['auth_lev']."\r\n";
	echo "</nav>\r\n";
	echo "</span>";
	echo "<span style='text-align:right; margin-bottom: 0%;'>";
	echo "<nav id='hnav1' style='margin-bottom: 0%;'>\r\n";
	echo "<a href='usersettings.php' style='margin-bottom: 0%;'>User Settings</a>\r\n";
	
	if ( isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) AND $_SESSION['auth_lev']==3 ) {
		echo "<a href='sitesettings.php' style='margin-bottom: 0%;'>Site Settings</a>\r\n";
	}
	
	echo "</span>";
	echo "<span style='text-align:right; margin-bottom: 0'>";
	//echo "<a href='index.php?go=logout'>Log Out</a>\r\n";
	echo "<form style='float:right; margin-left: 1%; margin-top: 0%; margin-bottom: 0; padding: 0%;' id='logout' action='index.php' method=\"post\">\r\n";
	echo "<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Log_Out\" style='width: 0; height: 0'/>\r\n";
	//echo "<input class='logoutbutton' type=\"submit\" name=\"Button\" style='margin-bottom: -6pt; margin-top: -10pt;' value=\"Log&nbsp;out\" />\r\n";
	echo "<input class='logoutbutton' type=\"submit\" name=\"Button\" style='margin-bottom: 0; margin-top: -9%;' value=\"Log&nbsp;out\" />\r\n";
	echo "</form>\r\n";
	echo "</span>";
	echo "</nav>\r\n";
	echo "</div>\r\n";
} elseif (htmlentities($_SERVER['PHP_SELF']) != "/login.php") {
	echo "<span style='text-align:right'>";
	echo "<nav id='hnav1' style='margin-right: 5%'>\r\n";
	echo "<a href='login.php'>Log In</a>\r\n";
	echo "</nav>\r\n";
	echo "</span>";
}
?>