<?php
include ("db_connect.inc");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="Log_In") {
		$username = $_POST['fusername'];
		$password = $_POST['fpassword'];
		$query = "SELECT Password, Authority_Level, First_Name, ID, Active FROM Users WHERE User_Name='".$username."'";
		$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
		if ($row = mysqli_fetch_assoc($result))
		{
			$hash = $row['Password'];
			if ($row['Active'] == 1) {
				if (password_verify($password, $hash)) {
					$_SESSION['auth_lev'] = $row['Authority_Level'];
					$_SESSION['first_name'] = $row['First_Name'];
					$_SESSION['user_name'] = $username;
					$_SESSION['user_ID'] = $row['ID'];
					//echo "Correct Password entered";
					$query = "UPDATE Users SET Last_Logged=now() WHERE User_Name='".$username."'";
					//echo $query;
					mysqli_query($cxn,$query);
					//echo "DB Updated";
				}	else {
					$message .= "Incorrect Password entered. Try to log in again<br>\r\n";			
				}
			} else {
				$message .= "Account not activated yet. Check your email for activation code.<br>\r\n";			
			}
		} else {
			$message .= "Username not found. Try to log in again.<br>\r\n";		
		}
		//echo "Test";
}

include ("header.inc");
include ("navbar.inc");

echo "<article id='main' style='margin-top: 0%'>";

echo "<div class='message'>$message</div>\r\n";

if ($_GET["page"]) {
	$handle = htmlspecialchars_decode($_GET["page"]);
	$handle = preg_replace('/_/', ' ', $handle);
	$query = "SELECT Cust_Pages.Title AS Title, Cust_Pages.Body AS Body FROM Cust_Pages INNER JOIN Cust_Pages_DATA ON Cust_Pages_DATA.Page_ID=Cust_Pages.Page_ID AND Cust_Pages_DATA.Page_Iteration=Cust_Pages.Page_Iteration WHERE Title='$handle' AND Cust_Pages_DATA.Active=1;";
} elseif ($_GET["pageID"] AND $_GET["iteration"]) {
	$query = "SELECT Title, Body FROM Cust_Pages WHERE Page_ID=".$_GET["pageID"]." AND Page_Iteration=".$_GET["iteration"]." ORDER BY Last_Modified DESC;";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST['ftitle'])) {
	$handle = htmlspecialchars_decode($_POST["ftitle"]);
	$handle = preg_replace('/_/', ' ', $handle);	
	$query = "SELECT Cust_Pages.Title AS Title, Cust_Pages.Body AS Body FROM Cust_Pages INNER JOIN Cust_Pages_DATA ON Cust_Pages_DATA.Page_ID=Cust_Pages.Page_ID AND Cust_Pages_DATA.Page_Iteration=Cust_Pages.Page_Iteration WHERE Title='$handle' AND Cust_Pages_DATA.Active=1;";
} else {
	//Set Title in Globals
	//$query = "SELECT Title, Body FROM Cust_Pages WHERE Title=\"Welcome\" AND Active=1 ORDER BY Last_Modified DESC;";
	$query = "SELECT Cust_Pages.Title AS Title, Cust_Pages.Body AS Body FROM Cust_Pages INNER JOIN Cust_Pages_DATA ON Cust_Pages_DATA.Page_ID=Cust_Pages.Page_ID AND Cust_Pages_DATA.Page_Iteration=Cust_Pages.Page_Iteration WHERE Cust_Pages_DATA.Page_ID=1 AND Cust_Pages_DATA.Active=1;";
}

$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
if ($row = mysqli_fetch_assoc($result))
{
	if ($_GET["pageID"] AND $_GET["iteration"]) {
		echo "<h4>Note: This web page is not the current <span style=\"text-decoration: underline;\">active</span> one. If you however wish to revert to this page, click \"Edit Page\".</h4>";
	}
	echo	"<h1>{$row['Title']}</h1>\r\n";
	echo	"<p>\r\n";
	
	$text = $row['Body'];
	$text = htmlentities($text);

	$patterns = array(
            "/\[link\](.*?)\[\/link\]/",
            "/\[url\](.*?)\[\/url\]/",
            "/\[img\](.*?)\[\/img\]/",
            "/\[b\](.*?)\[\/b\]/",
            "/\[u\](.*?)\[\/u\]/",
            "/\[i\](.*?)\[\/i\]/",
            "/\n/");
        
	$replacements = array(
            "<a href=\"\\1\">\\1</a>",
            "<a href=\"\\1\">\\1</a>",
            "<img src=\"\\1\">",
            "<strong>\\1</strong>",
            "<u>\\1</u>",
            "<em>\\1</em>",
            "<br>");
        
	$newText = preg_replace($patterns,$replacements, $text);
	
	echo $newText;
	echo "</p>\r\n";
	
	if ($_SESSION['auth_lev'] == 3 AND isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) ) {
		$pageTitle = preg_replace('/ /', '_', $row['Title']);
		echo "<div>\r\n";
		
		if ($_GET['pageID']) {
			if ($_GET['iteration']) {
				echo "<a href='editpage.php?pageID={$_GET['pageID']}&iteration={$_GET['iteration']}'>[Edit Page]</a>\r\n";
			}
		} else {
			echo "<a href='editpage.php?page=$pageTitle'>[Edit Page]</a>\r\n";
		}
		if ($_GET['pageID']) {
			if ($_GET['iteration']) {
				echo "<a href='restore.php?pageID={$_GET['pageID']}&iteration={$_GET['iteration']}'>[Restore]</a>\r\n";
			}
			echo "<a href='pagehistory.php?pageID={$_GET['pageID']}'>[History]</a>\r\n";
		} else {
			$query = "SELECT Cust_Pages_DATA.Page_ID FROM Cust_Pages_DATA INNER JOIN Cust_Pages ON Cust_Pages_DATA.Page_ID=Cust_Pages.Page_ID AND Cust_Pages_DATA.Page_Iteration=Cust_Pages.Page_Iteration WHERE Cust_Pages.Title='{$row['Title']}' AND Cust_Pages_DATA.Active=1;";
			//$query = "SELECT Thread_ID FROM Cust_Pages WHERE Title='{$row['Title']}' AND Active=1";
			//echo $query;
			$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
			$row = mysqli_fetch_assoc($result);
			echo "<a href='pagehistory.php?pageID={$row['Page_ID']}'>[History]</a>\r\n";
		}
		//echo "<a href='pagehistory.php?thread=6'>[History]</a>\r\n";
		echo "<a href='deletepage.php?page=$pageTitle'>[Delete Page]</a>\r\n";
		echo "</div>\r\n";
	}
}
	
echo "</article>\r\n";
include ("footer.inc");
?>