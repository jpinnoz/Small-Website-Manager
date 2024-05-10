<?php
include ("db_connect.inc");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submitCode']=="New_Page") {
	$row = "";
	$result = "";
	$query = "";
	$query1 = "";
	$findMaxLinkID = "";
	$newMenuItem = "";
	$isTitleUnique = "";
	
	$menuName = $_POST['fmenuName'];
	$addToMenu = $_POST['faddToMenu'];
	$title = $_POST['ftitle'];
	$url1 = "index.php?page=".$title;
	$pageTitle = preg_replace('/ /', '_', $title);
	$url2 = "index.php?page=".$pageTitle;
	$location = "Location: ".$url2;
	$body = $_POST['fbody'];
	
	$query = "SELECT Cust_Pages.Title AS Title, Cust_Pages.Body AS Body FROM Cust_Pages INNER JOIN Cust_Pages_DATA ON Cust_Pages_DATA.Page_ID=Cust_Pages.Page_ID AND Cust_Pages_DATA.Page_Iteration=Cust_Pages.Page_Iteration WHERE Title='$title' AND Cust_Pages_DATA.Active=1;";
	$result = mysqli_query($cxn,$query);

	if ($row = mysqli_fetch_assoc($result)) {
		$message = "Page Title already taken. Please try a different Title.";
	} else {

		$query = "SELECT MAX(Page_ID) AS `maxID` FROM `Cust_Pages`";
		$result = mysqli_query($cxn,$query);
		$row = mysqli_fetch_assoc($result);
		$maxID = $row['maxID']+1;
		$lastAuthor = $_SESSION['user_ID'];
		
		$query1 = "INSERT INTO `Cust_Pages` (`Title`, `Body`, `Page_ID`, `Page_Iteration`, `Last_Author`) VALUES ('$title','$body','$maxID','1','$lastAuthor')";
		if ($result1 = mysqli_query($cxn,$query1) or die ("Couldn't execute query.")) {

			if ($addToMenu == TRUE) {
				$findMaxLinkID = "SELECT MAX(LinkID) AS `LargestID` FROM `SubMenus` WHERE `MenuID`=1";
				$result2 = mysqli_query($cxn,$findMaxLinkID);
				$row2 = mysqli_fetch_assoc($result2);
				$newID = $row2['LargestID'] + 1;
				
				$newMenuItem = "INSERT INTO `SubMenus`(`MenuID`, `LinkID`, `Menu_Entry`, `Title`) VALUES ('1','$newID','$menuName','$url1')";
				mysqli_query($cxn,$newMenuItem) or die ("Couldn't execute query.");
			}
		} else {
			$message .= "<br>Error inserting record";
		}
		
		$query3 = "INSERT INTO `Cust_Pages_DATA` (`Page_ID`, `Page_Iteration`, `Active`) VALUES ('$maxID','1','1')";
		mysqli_query($cxn,$query3) or die ("Couldn't execute query.");
		
	}
	//echo $message;
	header($location);
	die();
} else {
	include ("header.inc");
	include ("navbar.inc");

	echo "<article id='main'>\r\n";

	if ( isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) AND $_SESSION['auth_lev']==3 ) {
		echo	"<h3>New Page</h3>\r\n
		<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">\r\n
		<table>\r\n
		<tr><td>Menu Title: </td><td><input type=\"text\" size=\"20\" name=\"fmenuName\"></input></td></tr>\r\n
		<tr><td>Add to Nav Bar?: </td><td><input type=\"checkbox\" id=\"faddToMenu\" name=\"faddToMenu\" checked ><label for=\"faddToMenu\">Check this if you want this Menu Title to be added to the Main Nav bar on the left</label></td></tr>\r\n
		<tr><td>Page Title: </td><td><input type=\"text\" size=\"40\" name=\"ftitle\"></input></td></tr>\r\n
		<tr><td>Body: </td><td><textarea rows=5 cols=60 name=\"fbody\"></textarea></td></tr>\r\n
		</table>\r\n
		<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"New_Page\">\r\n
		<input type=\"submit\" name=\"Button\" value=\"Submit\" />\r\n
		</form>";
	} else {
		echo "Restricted Area. You need administrative priviledges to access this page.";
	}
		
	echo "</article>\r\n";
	include ("footer.inc");
}

?>