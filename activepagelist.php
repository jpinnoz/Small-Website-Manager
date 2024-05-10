<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");
?>
<article id="main">
<h3>Active Pages Listing</h3>
<?php
echo "<table class='news'>\r\n";
//echo "<tr><th>Current Page Title</th><th>Last Modified</th><th>Last Author</th></tr>";
//Not sure how to get the Last Author???
echo "<tr><th>Current Page Title</th><th>Last Modified</th></tr>";

$query = "SELECT Cust_Pages.Title, Cust_Pages.Page_ID, Cust_Pages.Last_Modified FROM Cust_Pages INNER JOIN Cust_Pages_DATA ON Cust_Pages_DATA.Page_ID=Cust_Pages.Page_ID AND Cust_Pages_DATA.Page_Iteration=Cust_Pages.Page_Iteration WHERE Cust_Pages_DATA.Active=1;";

$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
while($row = mysqli_fetch_assoc($result))
{
	//echo "<tr><td><a href=\"pagehistory.php?thread={$row['Thread_ID']}\">{$row['Title']}</a></td><td>{$row['Last_Modified']}</td><td>{$row['User_Name']}</td></tr>";
	echo "<tr><td><a href=\"pagehistory.php?pageID={$row['Page_ID']}\">{$row['Title']}</a></td><td>{$row['Last_Modified']}</td></tr>";
}
echo  "</table>\r\n";
?>
</article>
<?php
include ("footer.inc");
?>