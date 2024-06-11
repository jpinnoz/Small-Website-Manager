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
		$message .= "<div class='message'>You have successfully activated your account. You can now sign in.</div><br>\r\n";
		$registrationAttempt = true;
		//leave registrationAttempt as true... this could all be coded better :-P
	} else {
		$message .= "<div class='error'>Your temporary activation code was incorrect. Please contact the administrator.</div><br>\r\n";
		$registrationAttempt = true;
		//leave registrationAttempt as true... this could all be coded better :-P
	}
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Register") {
	$firstName = $_POST['ffirstname'];
	$lastName = $_POST['flastname'];
	$username = $_POST['fusername'];
	$password = $_POST['fpassword'];
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	$emailAddress = $_POST['femail'];
	$error_style = "style='background-color:pink'";
	$err_count = 0;
	
	if (!preg_match("/^[A-Za-z\-\'\ ]{1,50}$/", $firstName)) {
		$err_count++;
		$ffirstname_style=$error_style;
		$message .= "<div class='error'>First Name input ERROR: You may only use letters, hyphens or apostraphes! Minumum length is 1, maximum length is 50!</div><p>\r\n";
	}
	if (!preg_match("/^[A-Za-z\-\'\ ]{1,50}$/", $lastName)) {
		$err_count++;
		$flastname_style=$error_style;
		$message .= "<div class='error'>Last Name input ERROR: You may only use letters, hyphens or apostraphes! Minumum length is 1, maximum length is 50!</div><p>\r\n";
	}
	if (!preg_match("/^[A-Za-z0-9\-\_]{3,100}$/", $username)) {
		$err_count++;
		$fusername_style=$error_style;
		$message .= "<div class='error'>Username input ERROR: You may only use letters, numbers, hyphens or underscores! Minumum length is 3, maximum length is 100!</div><p>\r\n";		
	}
	if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,15}$/', $password)) {
		$err_count++;
		$fpassword_style=$error_style;
		$message .= "<div class='error'>Password input ERROR: You may only use letters, numbers, or special characters (!@#$%)! Minumum length is 8, maximum length is 15!</div><p>\r\n";
		//Must contain at least 1 number and 1 letter
	}
	if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/', $emailAddress)) {
		$err_count++;
		$femail_style=$error_style;
		$message .= "<div class='error'>Email Address input ERROR: You may only use letters, numbers, or periods!</div><p>\r\n";	
	}
	if ($err_count==0) {
	 
		$charSet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$charSetLen = strlen($charSet)-1;
		
		for ($i = 0; $i < 16; $i++) {
			$pick = rand(0, $charSetLen);
		$randvalue .= $charSet[$pick];
		}
			
		$activatePass = password_hash($randvalue, PASSWORD_DEFAULT);	
		
		$query = "INSERT INTO `Users`(`First_Name`, `Last_Name`, `eMail`, `User_Name`, `Password`, `DateTime_Joined`, `Last_Logged`, `Active`, `Activate_Pass`) VALUES ('$firstName','$lastName','$emailAddress','$username','$hashed_password', NOW(), NOW(), FALSE, '$activatePass')";

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
			<p>Hello {$firstName},</p>
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

			if ($mailResult) {
				$message .= "<div class='message'>You have successfully registered. Please check your email to activate your account.</div><br>\r\n";
				$registrationAttempt = true;
			} else {
				$message .= "<div class='error'>An error occurred when trying to send the confirmation email. Please contact the administrator.</div><br>\r\n";
				$registrationAttempt = true;
			}
		} else {
			$message .= "<div class='error'>There was an error when registering your record. Please try to register again.</div><br>\r\n";
			$registrationAttempt = false;
		}
	}
}
include ("header.inc");
include ("navbar.inc");

echo "<article id='main'>";
echo "<h3>Register</h3>";

if ($registrationAttempt==true) {
	echo $message;
}	else {
	echo "$message
	<div>\r\n
	<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">\r\n
	<table>\r\n
	<tr><td>First Name: </td><td><input $ffirstname_style type=\"text\" name=\"ffirstname\" value=\"$firstName\"></input></td></tr>\r\n
	<tr><td>Last Name: </td><td><input $flastname_style type=\"text\" name=\"flastname\" value=\"$lastName\"></input></td></tr>\r\n
	<tr><td>Username: </td><td><input $fusername_style type=\"text\" name=\"fusername\" value=\"$username\"></input></td></tr>\r\n
	<tr><td>Password: </td><td><input $fpassword_style type=\"password\" name=\"fpassword\" value=\"$password\"></input></td></tr>\r\n
	<tr><td>eMail: </td><td><input $femail_style type=\"text\" name=\"femail\" value=\"$emailAddress\"></input></td></tr>\r\n
	</table>\r\n
	<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Register\">\r\n
	<input type=\"submit\" name=\"Button\" value=\"Register\" />\r\n
	</form>\r\n
	<br>\r\n
	Please Input a password of no less than 8 characters, including at least 1 uppercase character and 1 special character (!@#$%).\r\n
	</div>\r\n";
}

echo "</article>";

include ("footer.inc");
?>