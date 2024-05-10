<?php
include ("db_connect.inc");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Forgot_Pass_Send_Email") {
	if ($_POST['Button']=="Send Email") {
		
		$email = $_POST['femail'];
		//First Name, User Name
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
		//$userName = $_SESSION['user_name'];
		$query = "UPDATE `Users` SET `Forgot_Pass`='".$password."',`Forgot_Pass_Expire`=NOW() + INTERVAL 1 HOUR WHERE `User_Name`='".$userName."'";
		//echo $query;
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
		$headers .= 'From: <jpinnoz@gmail.com>' . "\r\n";
		
		mail($to,$subject,$message,$headers);

		$url = "login.php";
		$location = "Location: ".$url;
		header($location);
		die();
		
		//echo "Test";
		
	} elseif ($_POST['Button']=="Cancel") {
		$url = "login.php";
		$location = "Location: ".$url;
		header($location);
		die();	
	}
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Change_Pass") {
	$newPass1 = $_POST['fnewpass'];
	$newPass2 = $_POST['fnewpassconfirm'];
	$userName = $_POST['userName'];
	$tempPass = $_POST['tempPass'];
	
	if ($newPass1 == $newPass2) {
		$password = password_hash($newPass1, PASSWORD_DEFAULT);
		$query = "UPDATE `Users` SET `Password`='{$password}',`Forgot_Pass`=NULL,`Forgot_Pass_Expire`=NULL WHERE `User_Name`='{$userName}'";
		//echo $query;
		mysqli_query($cxn,$query);
		$url = "login.php";
		$location = "Location: ".$url;
		header($location);
		die();
	} else {
		$url = htmlentities($_SERVER['PHP_SELF']);
		$location = "Location: ".$url."?username=".$userName."&temppass=".$tempPass;
		header($location);
		die();
	}

} elseif ($_GET['username'] AND $_GET['temppass']) {
	
	$userName = $_GET['username'];
	$query1 = "SELECT `Forgot_Pass`, `Forgot_Pass_Expire` FROM `Users` WHERE `User_Name`='{$userName}'";
	$result1 = mysqli_query($cxn,$query1);
	$row1 = mysqli_fetch_assoc($result1);
	$changePass = $row1['Forgot_Pass'];
	$changePassExpire = $row1['Forgot_Pass_Expire'];
		
	$tempPass = $_GET['temppass'];
	
	include ("header.inc");
	include ("navbar.inc");
	
	if (password_verify($tempPass, $changePass)) {
		if ($changePassExpire > date('Y-m-d H:i:s')) {
			
			echo "
			<article id='main'>
			<h3>Change Password</h3>
			<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">
			<table>
			<tr><td>New Password: </td><td><input type=\"password\" name=\"fnewpass\"></input></td></tr>
			<tr><td>Confirm New Password: </td><td><input type=\"password\" name=\"fnewpassconfirm\"></input></td></tr>
			</table>
			<input type=\"hidden\" id=\"userName\" name=\"userName\" value=\"".$userName."\">
			<input type=\"hidden\" id=\"tempPass\" name=\"tempPass\" value=\"".$tempPass."\">
			<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Change_Pass\">
			<input type=\"submit\" name=\"Button\" value=\"Update\" />
			</form>
			<br>
			</article\r\n";
		} else {
			echo "<article id='main'>";
			echo "You timed out!<p>";
			//echo "Time out: ".$changePassExpire."<p>";
			//echo "Now: ".date('Y-m-d H:i:s')."<p></div>";
			echo "</article>";
		}
	} else {
		echo "<article id='main'>";
		echo "Temporary password incorrect";
		echo "</article>";
	}
			
	include ("footer.inc");

} else {
	
	include ("header.inc");
	include ("navbar.inc");
	
	echo "<article id='main'>
	<h3>Forgotten Password</h3>
	You will be sent a confirmation email.<br>
	You must confirm by clicking on the link in the email.<br>
	Then you will be able to enter your new password.
	<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">
	<table>
	<tr><td>eMail: </td><td><input type=\"text\" name=\"femail\"></input></td></tr>
	</table>
	<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Forgot_Pass_Send_Email\">
	<input type=\"submit\" name=\"Button\" value=\"Send Email\" />
	<input type=\"submit\" name=\"Button\" value=\"Cancel\" />
	</form>
	</article>";
	
	include ("footer.inc");
}
?>