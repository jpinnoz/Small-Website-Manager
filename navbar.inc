<nav id="vnav1">
<?php
$query = "SELECT Menu_Entry, Title FROM SubMenus WHERE MenuID='1' AND Active=1 ORDER BY LinkID ASC LIMIT 10";
$result = mysqli_query($cxn,$query) or die ("Couldn't execute query.");
while($row = mysqli_fetch_assoc($result))
{
	$menuEntry = $row['Menu_Entry'];
	$pageTitle = $row['Title'];
	$pageTitle = preg_replace('/ /', '_', $pageTitle);
	echo "<a href='$pageTitle'>$menuEntry</a>\r\n";
}

if ($_SESSION['auth_lev'] == 3 AND isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) ) {
	echo "<a class='newpage' href='newpage.php'>[New Page]</a>\r\n";
}
?>
</nav>