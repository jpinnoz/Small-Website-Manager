<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");
?>
<article id='main'>
<h3>News</h3>
<?php
$query = "SELECT News.Heading,Users.User_Name,News.DateTime,News.Body FROM News LEFT JOIN Users ON News.Author=Users.ID ORDER BY News.DateTime DESC LIMIT 0,10";
$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
while($row = mysqli_fetch_assoc($result))
{
	echo "<table class='news'>\r\n";
	echo "<tr><th class='heading'>{$row['Heading']}</th><th class='username'>{$row['User_Name']}</th><th class='datetime'>{$row['DateTime']}</th></tr>\r\n";
	echo "<tr>";
	echo	"<td colspan='3'>{$row['Body']}";
	echo	"</td>";
	echo	"</tr>\r\n";
	echo  "</table>\r\n";
}
?>
</article>
<?php
include ("footer.inc");
?>