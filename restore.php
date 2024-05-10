<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");
echo "<article id='main'>\r\n";

if ( isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) AND $_SESSION['auth_lev']==3 ) {
	
	if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submitCode']=="Restore") {
		
		if ($_POST['Button'] == "Restore") {

			$title = $_POST['ftitle'];
			$pageID = $_POST['fpageID'];
			$pageIteration = $_POST['fpageIteration'];
			
			$query1 = "UPDATE Cust_Pages_DATA SET Page_ID=$pageID, Page_Iteration=$pageIteration, Active=1 WHERE Page_ID=$pageID";
			mysqli_query($cxn,$query1);
			
			if ($pageID !== 1) {
				$query2 = "UPDATE SubMenus SET Active=1, Title='index.php?page=$title' WHERE Page_ID=$pageID";
				mysqli_query($cxn,$query2);
			}
			
			//echo "<div class='message'>Page Restored Successfully</div>"; //check this please
			$location = "Location: index.php";
			header($location);
			die();
	
		} elseif ($_POST['Button'] == "Cancel") {
			echo "<div class='message'>Page Restore Canceled</div>";
		}
	
	} elseif (isset($_GET['pageID']) AND isset($_GET['iteration'])) {
	
			$pageID = $_GET['pageID'];
			$pageIteration = $_GET['iteration'];
			$query = "SELECT Title, Last_Modified FROM Cust_Pages WHERE Page_ID=$pageID AND Page_Iteration=$pageIteration";
			$result = mysqli_query($cxn,$query);
			$row = mysqli_fetch_assoc($result);
			$title = $row['Title'];
			$lastModified = $row['Last_Modified'];
			echo	"<h3>Restore this page: \"$title\" (Last modified: ".$lastModified.")</h3>\r\n
			This will restore the previous page you selected and replace the nav bar link.<p>\r\n
			<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">\r\n
			<input type=\"hidden\" id=\"fpageID\" name=\"fpageID\" value=\"$pageID\">\r\n
			<input type=\"hidden\" id=\"fpageIteration\" name=\"fpageIteration\" value=\"$pageIteration\">\r\n
			<input type=\"hidden\" id=\"ftitle\" name=\"ftitle\" value=\"$title\">\r\n
			<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Restore\">\r\n
			<input type=\"submit\" name=\"Button\" value=\"Restore\" />\r\n
			<input type=\"submit\" name=\"Button\" value=\"Cancel\" />\r\n
			</form>\r\n";
	
	}
	
} else {
	echo "<div class='message'>Restricted Area. You need administrative priviledges to access this page.</div>\r\n";
}

echo "</article>\r\n";
include ("footer.inc");
?>