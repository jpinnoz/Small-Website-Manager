<?php
include ("db_connect.inc");
include ("header.inc");
include ("navbar.inc");
?>
<article id="main">
<h3>Log In</h3>
<form action="index.php" method="post">
<table>
<tr><td>Username: </td><td><input type="text" name="fusername"></input></td></tr>
<tr><td>Password: </td><td><input type="password" name="fpassword"></input></td></tr>
</table>
<input type="hidden" id="submitCode" name="submitCode" value="Log_In"> 
<input type="submit" name="Button" value="Log in" />
</form>
<br>
<p>Click <a href="forgotpass.php">here</a> if you've forgotten your password</p>
<p>
Click <a href="register.php">here</a> to register
</p>
</article>

<?php
include ("footer.inc");
?>