<?php
include ("db_connect.inc");
session_start();
if ($_GET['username'] AND $_GET['temppass']) {
	$userName = $_GET['username'];
	$query1 = "SELECT `Activate_Pass` FROM `Users` WHERE `User_Name`='{$userName}'";
	$result1 = mysqli_query($cxn,$query1);
	$row1 = mysqli_fetch_assoc($result1);
	$activatePass = $row1['Activate_Pass'];

	$tempPass = $_GET['temppass'];
	
	if (password_verify($tempPass, $activatePass)) {
		$query1 = "UPDATE `Users` SET `Active`=TRUE WHERE `User_Name`='$userName'";
		mysqli_query($cxn,$query1);
		$message .= "You have successfully activated your account. You can now sign in.<br>\r\n";
		$registrationAttempt = true;
		//leave registrationAttempt as true... this could all be coded better :-P
	} else {
		$message .= "Your temporary activation code was incorrect.<br>\r\n";
		$registrationAttempt = true;
		//leave registrationAttempt as true... this could all be coded better :-P
	}
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Register") {
	$firstname = $_POST['ffirstname'];
	$lastname = $_POST['flastname'];
	$username = $_POST['fusername'];
	$password = password_hash($_POST['fpassword'], PASSWORD_DEFAULT);
	$emailAddress = $_POST['femail'];
	
	$charSet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$charSetLen = strlen($charSet)-1;
	
	for ($i = 0; $i < 16; $i++) {
		$pick = rand(0, $charSetLen);
   	$randvalue .= $charSet[$pick];
	}
		
	$activatePass = password_hash($randvalue, PASSWORD_DEFAULT);	
	
	$query = "INSERT INTO `Users`(`First_Name`, `Last_Name`, `eMail`, `User_Name`, `Password`, `DateTime_Joined`, `Last_Logged`, `Active`, `Activate_Pass`) VALUES ('$firstname','$lastname','$emailAddress','$username','$password', NOW(), NOW(), FALSE, '$activatePass')";
	//echo "<html><body>$query";
	if (mysqli_query($cxn,$query)) {
		
		$query1 = "SELECT Value FROM Globals WHERE Global='Website Name'";
		$result1 = mysqli_query($cxn,$query1);
		$row1 = mysqli_fetch_assoc($result1);
		$webSiteName = $row1['Value'];
		
		$query2 = "SELECT Value FROM Globals WHERE Global='URL'";
		$result2 = mysqli_query($cxn,$query2);
		$row2 = mysqli_fetch_assoc($result2);
		$url1 = $row2['Value'];
				
		$subject = "Confirmation from $webSiteName";
		
		$eMailMessage = "
		<h3>You signed up for $webSiteName</h3>
		<p>Hello {$firstname},</p>
		<p><a rel=\"nofollow\" href=\"{$url1}/register.php?username={$username}&temppass={$randvalue}\">Click here to activate your account</a></p>
		<p>If you cannot click the link, copy the following url into your browser (and GO):</p>
		<p>{$url1}/register.php?username={$username}&temppass={$randvalue}</p>
		";
		
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$query3 = "SELECT Value FROM Globals WHERE Global='Site Email Address'";
		$result3 = mysqli_query($cxn,$query3);
		$row3 = mysqli_fetch_assoc($result3);
		$siteEmail = $row3['Value'];

		$headers .= 'From: <{$siteEmail}>' . "\r\n";
		
		$mailResult = mail($emailAddress,$subject,$eMailMessage,$headers);
		//echo "Email address: ".htmlentities($emailAddress)."<br>";
		//echo $subject."<br>";
		//echo $eMailMessage."<br>";
		//echo $headers."<br>";
		if ($mailResult) {
			$message .= "You have successfully registered. Please check your email to activate your account.<br>\r\n";
			$registrationAttempt = true;
		} else {
			$message .= "An error occurred when trying to send the confirmation email. Please try to register again.<br>\r\n";
			$registrationAttempt = false;
		}
	} else {
		$message .= "There was an error when registering your record. Please try to register again.<br>\r\n";
		$registrationAttempt = false;
	}
}
include ("header.inc");
include ("navbar.inc");
?>
<article id='main'>
<h3>Register</h3>
<?php
if ($registrationAttempt==true) {
	echo "<div class='message'>".$message."</div>\r\n";
}	else {
	echo "
	<div class='error'>".$message."</div>
	<div>
	<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">
	<table>
	<tr><td>First Name: </td><td><input type=\"text\" name=\"ffirstname\"></input></td></tr>
	<tr><td>Last Name: </td><td><input type=\"text\" name=\"flastname\"></input></td></tr>
	<tr><td>Username: </td><td><input type=\"text\" name=\"fusername\"></input></td></tr>
	<tr><td>Password: </td><td><input type=\"password\" name=\"fpassword\"></input></td></tr>
	<tr><td>eMail: </td><td><input type=\"text\" name=\"femail\"></input></td></tr>
	</table>
	<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Register\">
	<input type=\"submit\" name=\"Button\" value=\"Register\" />
	</form>
	<br>
	Please Input a password of no less than 8 characters, including at least 1 uppercase character and 1 special character.
	</div>\r\n";
}
?>
</article>
<?php
include ("footer.inc");
?>