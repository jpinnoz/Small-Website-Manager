<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");
$prior = 0;
	
if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Forgot_Pass_Send_Email") {
	if ($_POST['Button']=="Send Email") {

		$email = $_POST['femail'];
		if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/', $email)) {
			$_SESSION['notify'] = "<div class='error'>Email Address input ERROR: You may only use letters, numbers, or periods!</div><p>\r\n";
			
			$url = htmlentities($_SERVER['PHP_SELF']);
			$location = "Location: ".$url;
			header($location);
			die();
		}
		
		$query5 = "SELECT `eMail` FROM `Users` WHERE eMail='{$email}'";
		$result5 = mysqli_query($cxn,$query5);
		$row5 = mysqli_fetch_assoc($result5);
		if ($row5['eMail'] == FALSE) {
			$_SESSION['notify'] = "<div class='error'>Email Address not found in DATABASE: Please try again!</div><p>\r\n";
			
			$url = htmlentities($_SERVER['PHP_SELF']);
			$location = "Location: ".$url;
			header($location);
			die();		
		}

		$query4 = "SELECT `First_Name`, `User_Name` FROM `Users` WHERE `eMail`='{$email}'";
		$result4 = mysqli_query($cxn,$query4);
		$row4 = mysqli_fetch_assoc($result4);
		$firstName = $row4['First_Name'];
		$userName = $row4['User_Name'];
		
		$charSet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$charSetLen = strlen($charSet)-1;
		
		for ($i = 0; $i < 16; $i++) {
			$pick = rand(0, $charSetLen);
			$randvalue .= $charSet[$pick];
		}
		
		$password = password_hash($randvalue, PASSWORD_DEFAULT);
		$query = "UPDATE `Users` SET `Forgot_Pass`='".$password."',`Forgot_Pass_Expire`=NOW() + INTERVAL 1 HOUR WHERE `User_Name`='".$userName."'";
		mysqli_query($cxn,$query);
		
		$to = $email;
		
		$query1 = "SELECT Value FROM Globals WHERE Global='Website Name'";
		$result1 = mysqli_query($cxn,$query1);
		$row1 = mysqli_fetch_assoc($result1);
		$webSiteName = $row1['Value'];
		
		$query2 = "SELECT Value FROM Globals WHERE Global='URL'";
		$result2 = mysqli_query($cxn,$query2);
		$row2 = mysqli_fetch_assoc($result2);
		$url1 = $row2['Value'];
				
		$subject = "Confirmation from $webSiteName";
		
		$message = "
		<h3>You forgot your password</h3>
		<p>Hello {$firstName},</p>
		<p><a rel=\"nofollow\" href=\"{$url1}/forgotpass.php?username={$userName}&temppass={$randvalue}\">Click here to change your password</a></p>
		<p>If you cannot click the link, copy the following url into your browser:</p>
		<p>{$url1}/forgotpass.php?username={$userName}&temppass={$randvalue}</p>
		";
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$query3 = "SELECT Value FROM Globals WHERE Global='Site Email Address'";
		$result3 = mysqli_query($cxn,$query3);
		$row3 = mysqli_fetch_assoc($result3);
		$siteEmail = $row3['Value'];

		$headers .= 'From: <{$siteEmail}>' . "\r\n";
		
		mail($to,$subject,$message,$headers);

		$url = "login.php";
		$location = "Location: ".$url;
		header($location);
		die();
		
	} elseif ($_POST['Button']=="Cancel") {
		$url = "login.php";
		$location = "Location: ".$url;
		header($location);
		die();	
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Change_Pass") {
	$newPass1 = $_POST['fnewpass'];
	$newPass2 = $_POST['fnewpassconfirm'];
	$userName = $_POST['userName'];
	$tempPass = $_POST['tempPass'];
	$err_count = 0;
	$_SESSION['newPass1'] = "style='background-color:pink'";
	$_SESSION['newPass2'] = "style='background-color:pink'";
	
	if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,15}$/', $newPass1)) {
		$_SESSION['notify'] = "<div class='error'>Password input ERROR: You may only use letters, numbers, or special characters (!@#$%)! Minumum length is 8, maximum length is 15!</div><p>\r\n";
		$err_count++;
		$_SESSION['newPass1'] = "style='background-color:pink'";
		//Must contain at least 1 number and 1 letter
	}
	if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,15}$/', $newPass2)) {
		$_SESSION['notify'] .= "<div class='error'>Password confirmation input ERROR: You may only use letters, numbers, or special characters (!@#$%)! Minumum length is 8, maximum length is 15!</div><p>\r\n";
		$err_count++;
		$_SESSION['newPass2'] = "style='background-color:pink'";
		//Must contain at least 1 number and 1 letter
	}
	if ($newPass1 !== $newPass2) {
		$_SESSION['notify'] .= "<div class='error'>Password ERROR: The confirmation password did not match!</div><p>\r\n";
		$err_count++;
		$_SESSION['newPass1'] = "style='background-color:pink'";
		$_SESSION['newPass2'] = "style='background-color:pink'";
	}
	if ($err_count > 0) {
		$url = htmlentities($_SERVER['PHP_SELF']);
		$url = preg_replace('/\/$/', '', $url);
		//$_SESSION['notify'] .= "<div class='error'>$url</div><p>\r\n";
		$location = "Location: ".$url."?username=".$userName."&temppass=".$tempPass;
		header($location);
		die();
	}
	
	$password = password_hash($newPass1, PASSWORD_DEFAULT);
	$query = "UPDATE `Users` SET `Password`='{$password}',`Forgot_Pass`=NULL,`Forgot_Pass_Expire`=NULL WHERE `User_Name`='{$userName}'";
	mysqli_query($cxn,$query);
	
	$url = "login.php";
	$location = "Location: ".$url;
	header($location);
	die();
}

if ($_GET['username'] AND $_GET['temppass']) {
	$userName = $_GET['username'];
	$tempPass = $_GET['temppass'];
	
	echo "<article id='main'>\r\n";
	if (!preg_match("/^[A-Za-z0-9\-\_]{3,100}$/", $userName)) {
		echo "<div class='error'>Username ERROR: Username does not meet requirements!</div><p>\r\n";
	} elseif (!preg_match("/^[A-Za-z0-9\-\_]{16}$/", $tempPass)) {
		echo "<div class='error'>Temporary Password ERROR: Temp Password does not meet requirements!</div><p>\r\n";
	} else {
		$query1 = "SELECT `Forgot_Pass`, `Forgot_Pass_Expire` FROM `Users` WHERE `User_Name`='{$userName}'";
		$result1 = mysqli_query($cxn,$query1);
		$row1 = mysqli_fetch_assoc($result1);
		$changePass = $row1['Forgot_Pass'];
		$changePassExpire = $row1['Forgot_Pass_Expire'];

		if (password_verify($tempPass, $changePass)) {
			if ($changePassExpire > date('Y-m-d H:i:s')) {
				echo "
				{$_SESSION['notify']}
				<h3>Change Password</h3>\r\n
				<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">\r\n
				<table>\r\n
				<tr><td>New Password: </td><td><input {$_SESSION['newPass1']} type=\"password\" name=\"fnewpass\" value=\"\"></input></td></tr>\r\n
				<tr><td>Confirm New Password: </td><td><input {$_SESSION['newPass2']} type=\"password\" name=\"fnewpassconfirm\" value=\"\"></input></td></tr>\r\n
				</table>\r\n
				<input type=\"hidden\" id=\"userName\" name=\"userName\" value=\"".$userName."\">\r\n
				<input type=\"hidden\" id=\"tempPass\" name=\"tempPass\" value=\"".$tempPass."\">\r\n
				<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Change_Pass\">\r\n
				<br>\r\n
				<input type=\"submit\" name=\"Button\" value=\"Update\" />\r\n
				</form>\r\n";
			} else {
				echo "<div class='error'>Your chance to change your password timed out! Please try again!</div><p>\r\n";
				//echo "Time out: ".$changePassExpire."<p>";
				//echo "Now: ".date('Y-m-d H:i:s')."<p></div>";
			}
		} else {
			echo "<div class='error'>Temporary password incorrect. Please contact Administrator!</div><p>\r\n";
		}
	}
	echo "</article>\r\n";
	$prior = 1;
	$_SESSION['notify'] = "";
	$_SESSION['newPass1'] = "";
	$_SESSION['newPass2'] = "";
}

if ($prior == 0) {
	echo "<article id='main'>\r\n";
	echo $_SESSION['notify'];
	echo "<h3>Forgotten Password</h3>\r\n
	You will be sent a confirmation email.<br>\r\n
	You must confirm by clicking on the link in the email.<br>\r\n
	Then you will be able to enter your new password.<p>\r\n
	<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">\r\n
	<table>\r\n
	<tr><td>eMail: </td><td><input type=\"text\" name=\"femail\"></input></td></tr>\r\n
	</table>\r\n
	<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Forgot_Pass_Send_Email\">\r\n
	<br>\r\n
	<input type=\"submit\" name=\"Button\" value=\"Send Email\" />\r\n
	<input type=\"submit\" name=\"Button\" value=\"Cancel\" />\r\n
	</form>\r\n";
	echo "</article>\r\n";
	
	$_SESSION['notify'] = "";
}
include ("footer.inc");
?>