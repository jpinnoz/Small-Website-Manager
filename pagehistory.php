<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");

echo "<article id='main'>";
echo "<h3>Page History</h3>";

if ($_GET["pageID"]) {
	$pageID=$_GET["pageID"];
	echo "<table class='news'>\r\n";
	echo "<tr><th>Page Iteration</th><th>Parent Iteration</th><th>Page Title</th><th>Last Modified</th><th>Last Author</th><th>Active</th></tr>";
	$query1 = "SELECT Cust_Pages.Page_Iteration, Cust_Pages.Parent_Iteration, Cust_Pages.Title, Cust_Pages.Last_Modified, Users.User_Name FROM Cust_Pages LEFT JOIN Users ON Cust_Pages.Last_Author=Users.ID WHERE Cust_Pages.Page_ID=$pageID ORDER BY Page_Iteration ASC";
	$result1 = mysqli_query($cxn,$query1) or die ("Couldn't execute query.");
	
	//$query2= "SELECT Cust_Pages.Sub_Thread_ID FROM Cust_Pages INNER JOIN Cust_Pages_DATA ON Cust_Pages.Sub_Thread_ID=Cust_Pages_DATA.Sub_Thread_ID WHERE Cust_Pages.Thread_ID=$thread AND Cust_Pages_DATA.Active=1;";
	$query2="SELECT Cust_Pages_DATA.Page_Iteration FROM Cust_Pages_DATA WHERE Cust_Pages_DATA.Page_ID=$pageID AND Cust_Pages_DATA.Active=1;";
	$result2 = mysqli_query($cxn,$query2) or die ("Couldn't execute query.");
	$row2 = mysqli_fetch_assoc($result2);
	
	while($row1 = mysqli_fetch_assoc($result1))
	{
		if ($row1['Page_Iteration'] == $row2['Page_Iteration']) {
			echo "<tr><td>{$row1['Page_Iteration']}</td><td>{$row1['Parent_Iteration']}</td><td><a href=\"index.php?page={$row1['Title']}\">{$row1['Title']}</a></td><td>{$row1['Last_Modified']}</td><td>{$row1['User_Name']}</td><td>TRUE</td></tr>";
		} else {
			echo "<tr><td>{$row1['Page_Iteration']}</td><td>{$row1['Parent_Iteration']}</td><td><a href=\"index.php?pageID={$pageID}&iteration={$row1['Page_Iteration']}\">{$row1['Title']}</a></td><td>{$row1['Last_Modified']}</td><td>{$row1['User_Name']}</td><td>FALSE</td></tr>";		
		}
	}
	echo  "</table>\r\n";
} else {
	echo "Error: Thread not specified";
}
?>
</article>
<?php
include ("footer.inc");
?>