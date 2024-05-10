<?php
include ("db_connect.inc");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode']=="New_Page") {
	
	$newPageType=$_POST['newpagetype'];
	
	if ($newPageType == "Custom Page") {
		$location = "Location: custompage.php";
		header($location);
		die();
	} else {
		$query = "SELECT `Type`, `Default Menu Title`, `LinkData`, `GetData` FROM `SubMenusData` WHERE `Type`='$newPageType'";
		$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
		$row1 = mysqli_fetch_assoc($result);
		$linkData = $row1['LinkData'];
		$defaultMenuTitle = $row1['Default Menu Title'];
		
		$findMaxLinkID = "SELECT MAX(LinkID) AS `LargestID` FROM `SubMenus` WHERE `MenuID`=1";
		$result = mysqli_query($cxn,$findMaxLinkID);
		$row2 = mysqli_fetch_assoc($result);
		$newID = $row2['LargestID'] + 1;
		
		$newMenuItem = "INSERT INTO `SubMenus`(`MenuID`, `LinkID`, `Menu_Entry`, `Title`) VALUES ('1','$newID','$defaultMenuTitle','$linkData')";
		mysqli_query($cxn,$newMenuItem) or die ("Couldn't execute query.");
		
		$location = "Location: ".$linkData;
		header($location);
		die();
	}
	//echo "<html><body>{$_POST['newpagetype']}</body></html>";

} else {
include ("header.inc");
include ("navbar.inc");

echo "<article id='main'>\r\n";

if ( isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) AND $_SESSION['auth_lev']==3 ) {
	echo	"<h3>New Page</h3>\r\n
	<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">\r\n
	<table>\r\n
	<tr><td><label>Select Page Type: </label></td>
	<td><select name=\"newpagetype\" id=\"newpagetype\">";
		
	$query = "SELECT `Type`, `LinkData`, `GetData` FROM `SubMenusData`";
	$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<option value=\"{$row['Type']}\">{$row['Type']}</option>\r\n";
	}

	echo "</select></td></tr>\r\n
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