<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");
?>
<article id="main">
<h3>Deleted Pages Listing</h3>
<?php
echo "<table class='news'>\r\n";
//echo "<tr><th>Current Page Title</th><th>Last Modified</th><th>Last Author</th></tr>";
echo "<tr><th>Current Page Title</th><th>Last Modified</th></tr>";
$query1 = "SELECT Cust_Pages.Page_ID, Cust_Pages.Page_Iteration, Cust_Pages.Title, Cust_Pages.Last_Modified FROM Cust_Pages INNER JOIN Cust_Pages_DATA ON Cust_Pages.Page_ID=Cust_Pages_DATA.Page_ID AND Cust_Pages.Page_Iteration=Cust_Pages_DATA.Page_Iteration WHERE Cust_Pages_DATA.Active=0;";
$result1 = mysqli_query($cxn,$query1) or die ("Couldn't execute query.");
//echo $query1;

while($row1 = mysqli_fetch_assoc($result1))
{
	echo "<tr><td><a href=\"pagehistory.php?pageID={$row1['Page_ID']}\">{$row1['Title']}</a></td><td>{$row1['Last_Modified']}</td></tr>";
}
echo  "</table>\r\n";
?>
</article>
<?php
include ("footer.inc");
?>