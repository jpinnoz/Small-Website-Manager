<?php
include ("db_connect.inc");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Temp_Pass") {
	if ($_POST['Button']=="Send Email") {
		
		$charSet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$charSetLen = strlen($charSet)-1;
		
		for ($i = 0; $i < 16; $i++) {
			$pick = rand(0, $charSetLen);
	   	$randvalue .= $charSet[$pick];
		}
		
		$password = password_hash($randvalue, PASSWORD_DEFAULT);
		//echo "<html><body>";
		$userName = $_SESSION['user_name'];
		$query = "UPDATE `Users` SET `Change_Pass`='".$password."',`Change_Pass_Expire`=NOW() + INTERVAL 1 HOUR WHERE `User_Name`='".$userName."'";
		//echo $query."<p>";
		mysqli_query($cxn,$query);
		//echo "DONE";
		//echo "</body></html>";
		//echo "<html><body>".$randvalue."</body></html>";
		
		$to = $_POST['eMail'];
		
		$firstName = $_SESSION['first_name'];
		
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
		<h3>You requested to change your password</h3>
		<p>Hello {$firstName},</p>
		<p><a rel=\"nofollow\" href=\"{$url1}/changepass.php?username={$userName}&temppass={$randvalue}\">Click here to change your password</a></p>
		<p>If you cannot click the link, copy the following url into your browser:</p>
		<p>{$url1}/changepass.php?username={$userName}&temppass={$randvalue}</p>
		";
		
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		$query3 = "SELECT Value FROM Globals WHERE Global='Site Email Address'";
		$result3 = mysqli_query($cxn,$query3);
		$row3 = mysqli_fetch_assoc($result3);
		$siteEmail = $row3['Value'];

		$headers .= 'From: <{$siteEmail}>' . "\r\n";
		
		mail($to,$subject,$message,$headers);

		$url = "usersettings.php";
		$location = "Location: ".$url;
		header($location);
		die();
		
	} elseif ($_POST['Button']=="Cancel") {
		$url = "usersettings.php";
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
		$query = "UPDATE `Users` SET `Password`='{$password}',`Change_Pass`=NULL,`Change_Pass_Expire`=NULL WHERE `User_Name`='{$userName}'";
		//echo $query;
		mysqli_query($cxn,$query);
		$url = "index.php";
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
	$query1 = "SELECT `Change_Pass`, `Change_Pass_Expire` FROM `Users` WHERE `User_Name`='{$userName}'";
	$result1 = mysqli_query($cxn,$query1);
	$row1 = mysqli_fetch_assoc($result1);
	$changePass = $row1['Change_Pass'];
	$changePassExpire = $row1['Change_Pass_Expire'];
		
	$tempPass = $_GET['temppass'];
	
	include ("header.inc");
	include ("navbar.inc");
	echo "<article id='main'>";
	
	if (password_verify($tempPass, $changePass)) {
	//if ($_GET['temppass'] == $changePass) {
		if ($changePassExpire > date('Y-m-d H:i:s')) {
			
			echo "
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
			</form>";
		} else {
			echo "<div class='error'>\r\n";
			echo "You timed out!<p>";
			echo "Time out: ".$changePassExpire."<p>";
			echo "Now: ".date('Y-m-d H:i:s')."</div>";
		}
	} else {
		echo "<div class='error'>Temporary password incorrect</div>";
	}
	
	echo "</article>";
	include ("footer.inc");

} else {
	
	include ("header.inc");
	include ("navbar.inc");
	
	echo "<article id='main'>";

	if (isset($_SESSION['user_name'])) {
		$query = "SELECT `eMail` FROM `Users` WHERE `ID`='".$_SESSION['user_ID']."'";
		$result = mysqli_query($cxn,$query);
		$row = mysqli_fetch_assoc($result);
		$email = $row['eMail'];
	
		echo "
		<h3>Change Password</h3>
		A confirmation email will be sent to: $email<p>
		You must confirm by clicking on the link in the email. Then you will be able to enter your new password.";
		echo "<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">
		<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Temp_Pass\">
		<input type=\"hidden\" id=\"eMail\" name=\"eMail\" value=\"$email\">
		<input type=\"submit\" name=\"Button\" value=\"Send Email\" />
		<input type=\"submit\" name=\"Button\" value=\"Cancel\" />
		</form>";
	} else {
		echo "<div class=\"error\">Restricted Area. You need administrative priviledges to access this page.</div>";
	}
	
	echo "</article>";
	include ("footer.inc");
}
?>