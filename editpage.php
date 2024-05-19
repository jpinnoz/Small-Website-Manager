<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");
echo "<article id='main'>\r\n";
	
if ($_SERVER["REQUEST_METHOD"] == "POST" AND $_POST['submitCode'] == "Edit_Page") {
	$newTitle = $_POST['ftitle'];
	$oldTitle = $_POST['fOldTitle'];
	$body = $_POST['fbody'];
	$pageID = $_POST['fpage_ID'];
	$pageIteration = $_POST['fpageIteration'];
	$parentID = $_POST['fparentIteration'];
	$menuEntry = $_POST['fmenuName'];
	$addToMenu = $_POST['faddToMenu'];
	$lastAuthor = $_SESSION['user_ID'];
	
	//echo "<html><body>";
	//echo "Test";
	$query1 = "INSERT INTO `Cust_Pages`(`Title`, `Body`, `Page_ID`, `Page_Iteration`, `Parent_Iteration`, `Last_Author`) VALUES ('$newTitle','$body','$pageID','$pageIteration','$parentID','$lastAuthor')";
	//echo $query1;
	mysqli_query($cxn,$query1);
	//echo "<p>";
	
	$query2 = "UPDATE Cust_Pages_DATA SET Page_Iteration=$pageIteration WHERE Page_ID=$pageID";
	echo $query2;
	mysqli_query($cxn,$query2);
	
	if ($pageID == 1 AND $addToMenu==TRUE) {
		$query3 = "UPDATE `SubMenus` SET `Menu_Entry`='$menuEntry' WHERE `Page_ID`='$pageID'";
		mysqli_query($cxn,$query3);
	} elseif ($addToMenu==TRUE) {
	
		$findMaxLinkID = "SELECT MAX(LinkID) AS `LargestID` FROM `SubMenus` WHERE `MenuID`=1";
		$result3 = mysqli_query($cxn,$findMaxLinkID);
		$row3 = mysqli_fetch_assoc($result3);
		$newLinkID = $row3['LargestID'] + 1;
		
		if (!$cxn -> query("UPDATE `SubMenus` SET `Title`='index.php?page=$newTitle', `Menu_Entry`='$menuEntry', Active=1 WHERE `Page_ID`='$pageID'")) {

			$newMenuItem = "INSERT INTO `SubMenus`(`MenuID`, `LinkID`, `Page_ID`, `Menu_Entry`, `Title`) VALUES ('1','$newLinkID','$pageID','$menuEntry','index.php?page=$newTitle')";
			mysqli_query($cxn,$newMenuItem) or die ("Couldn't execute query.");
		}
		
		$newMenuItemBackup = "INSERT INTO `SubMenus_BACKUP`(`Page_ID`, `Page_Iteration`, `Menu_ID`, `Link_ID`, `Menu_Entry`, `Title`) VALUES ('$pageID', '$pageIteration', '1', '$newLinkID', '$menuEntry', 'index.php?page=$newTitle')";
		mysqli_query($cxn,$newMenuItemBackup) or die ("Couldn't execute query.");
		
	} elseif ($pageID == 1 AND $addToMenu==FALSE) {
		//echo "<div class='error'>You cannot remove the Home Page from the Navigation Bar</div>\r\n";
		$message .= "You cannot remove the Home Page from the Navigation Bar<br>\r\n";
	} elseif ($addToMenu==FALSE) {
		//$query3 = "DELETE FROM `SubMenus` WHERE Title='index.php?page=$oldTitle'";
		$query3 = "UPDATE `SubMenus` SET Active=0 WHERE Page_ID=$pageID";		
		mysqli_query($cxn,$query3);
	}
	
	$pageTitle = preg_replace('/ /', '_', $newTitle);
	$location = "Location: index.php?page=$pageTitle";
	header($location);
	die();
} else {

	$result1 ="";
	$query1 ="";
	if (isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) AND $_SESSION['auth_lev']==3 ) {
		if ($_GET['pageID'] && $_GET['iteration'] || $_GET['page']) {
			if ($_GET['page']) {
				//echo "Test 1";
				$handle = htmlspecialchars_decode($_GET["page"]);
				$handle = preg_replace('/_/', ' ', $handle);

				$query1 = "SELECT Cust_Pages.Title AS Title, Cust_Pages.Body AS Body, Cust_Pages.Page_ID AS Page_ID, Cust_Pages.Page_Iteration AS Page_Iteration, Cust_Pages.Last_Modified FROM Cust_Pages INNER JOIN Cust_Pages_DATA ON Cust_Pages_DATA.Page_ID=Cust_Pages.Page_ID AND Cust_Pages_DATA.Page_Iteration=Cust_Pages.Page_Iteration WHERE Title='$handle' AND Cust_Pages_DATA.Active=1;";
				
				//echo $query1;
				$result1 = mysqli_query($cxn,$query1);
				$row1 = mysqli_fetch_assoc($result1);
				$pageID = $row1['Page_ID'];
				
				$query3 = "SELECT `Menu_Entry` FROM `SubMenus` WHERE Page_ID=$pageID";
				$result3 = mysqli_query($cxn,$query3);
				$row3 = mysqli_fetch_assoc($result3);
				$menuName = $row3['Menu_Entry'];
				
			} elseif ($_GET['pageID'] && $_GET['iteration']) {
			
				$pageID = $_GET['pageID'];
				$pageIteration = $_GET['iteration'];
				$query1 = "SELECT Title, Body, Page_ID, Page_Iteration, Last_Modified FROM Cust_Pages WHERE Page_ID=$pageID AND Page_Iteration=$pageIteration;";
				//echo $query1;
				$result1 = mysqli_query($cxn,$query1);
				$row1 = mysqli_fetch_assoc($result1);
				//echo $query1;
				
				$query3 = "SELECT `Menu_Entry` FROM `SubMenus_BACKUP` WHERE Page_ID=$pageID AND Page_Iteration=$pageIteration";
				$result3 = mysqli_query($cxn,$query3);
				$row3 = mysqli_fetch_assoc($result3);
				$menuName = $row3['Menu_Entry'];
			}
			
			$query2 = "SELECT MAX(Page_Iteration) AS `Page_Iteration` FROM Cust_Pages WHERE Page_ID=$pageID";
			$result2 = mysqli_query($cxn,$query2);
			$row2 = mysqli_fetch_assoc($result2);
			$newPageIteration = $row2['Page_Iteration']+1;
			$handle2 = "index.php?page=".$handle;
				
			echo	"<h3>Edit Page</h3>\r\n
			<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">\r\n
			<table>\r\n
			<tr><td>Menu Title: </td><td><input type=\"text\" size=\"20\" name=\"fmenuName\" value=\"$menuName\"></input></td></tr>\r\n
			<tr><td>Add to Nav Bar?: </td><td><input type=\"checkbox\" id=\"faddToMenu\" name=\"faddToMenu\" checked ><label for=\"faddToMenu\">Check this if you want this Menu Title to be added to the Main Nav bar on the left</label></td></tr>\r\n
			<tr><td>Page Title: </td><td><input type=\"text\" size=\"40\" value=\"{$row1['Title']}\" name=\"ftitle\"></input></td></tr>\r\n
			<tr><td>Body: </td><td><textarea rows=5 cols=60 name=\"fbody\">{$row1['Body']}</textarea></td></tr>\r\n
			</table>\r\n
			<input type=\"hidden\" id=\"fOldTitle\" name=\"fOldTitle\" value=\"$handle\">\r\n
			<input type=\"hidden\" id=\"fpage_ID\" name=\"fpage_ID\" value=\"{$row1['Page_ID']}\">\r\n
			<input type=\"hidden\" id=\"fpageIteration\" name=\"fpageIteration\" value=\"$newPageIteration\">\r\n
			<input type=\"hidden\" id=\"fparentIteration\" name=\"fparentIteration\" value=\"{$row1['Page_Iteration']}\">\r\n
			<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Edit_Page\">\r\n
			<input type=\"submit\" name=\"Button\" value=\"Update\" />\r\n
			</form>";
		} else {
			echo "<div class='error'>Page not specified</div>";		
		}
	} else {
		echo "<div class='error'>Restricted Area. You need administrative priviledges to access this page.</div>";
	}

}
	echo "</article>\r\n";
	include ("footer.inc");

?>