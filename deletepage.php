<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");
echo "<article id='main'>\r\n";

if ( isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) AND $_SESSION['auth_lev']==3 ) {
	
	if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submitCode']=="Delete_Page") {
		
		if ($_POST['Button'] == "Delete") {

			$page = $_POST['page'];			
			
			//$query2 = "SELECT Thread_ID FROM Cust_Pages WHERE Title='$page' AND Active=1";
			$query2 = "SELECT Cust_Pages_DATA.Page_ID FROM Cust_Pages_DATA LEFT JOIN Cust_Pages ON Cust_Pages_DATA.Page_Iteration=Cust_Pages.Page_Iteration AND Cust_Pages_DATA.Page_ID=Cust_Pages.Page_ID WHERE Cust_Pages.Title='$page' AND Cust_Pages_DATA.Active=1;";
			$result2 = mysqli_query($cxn,$query2);
			$row2 = mysqli_fetch_assoc($result2);
			$pageID = $row2['Page_ID'];
			
			if ($pageID == 1) {
				echo "<div class='message'>Cannot Delete Home Page. Edit instead.</div>";
			} else {

				$query1 = "UPDATE Cust_Pages_DATA SET Active=0 WHERE Page_ID=$pageID";
				mysqli_query($cxn,$query1);	
				
				$query2 = "UPDATE `SubMenus` SET Active=0 WHERE Page_ID=$pageID";
				mysqli_query($cxn,$query2);
				
				echo "<div class='message'>Page Deleted Successfully</div>";
				$location = "Location: index.php";
				header($location);
				die();
			}
	
		} elseif ($_POST['Button'] == "Cancel") {
			echo "<div class='message'>Page Deletion Canceled</div>";
		}
	
	} elseif (isset($_GET['page'])) {
	
			$page = htmlspecialchars_decode($_GET['page']);
			$page = preg_replace('/_/', ' ', $page);	
			echo	"<h3>Delete Page \"$page\"</h3>\r\n
			This will delete the page and remove it from the Nav Bar. The page can be restored later if you wish.<p>\r\n
			<form action='".htmlentities($_SERVER['PHP_SELF'])."' method=\"post\">\r\n
			<input type=\"hidden\" id=\"page\" name=\"page\" value=\"$page\">\r\n
			<input type=\"hidden\" id=\"submitCode\" name=\"submitCode\" value=\"Delete_Page\">\r\n
			<input type=\"submit\" name=\"Button\" value=\"Delete\" />\r\n
			<input type=\"submit\" name=\"Button\" value=\"Cancel\" />\r\n
			</form>\r\n";
	
	}
	
} else {
	echo "<div class='message'>Restricted Area. You need administrative priviledges to access this page.</div>\r\n";
}

echo "</article>\r\n";
include ("footer.inc");
?>