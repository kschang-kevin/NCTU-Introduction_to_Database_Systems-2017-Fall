<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
	<section class="main-container">
		<div class="main-wrapper">
			<h2>New User</h2>
			<form class="newuser-signup-form" action="newuser.inc.php" method="POST">
				<input type="text" name="account" placeholder="Account"><br>
				<input type="password" name="password" placeholder="Password"><br>
				<input type="password" name="confirm_password" placeholder="Type your password again"><br>
				<input type="text" name="name" placeholder="Your Name"><br>
				<input type="text" name="email" placeholder="Your E-mail"><br>
				<input type="radio" name="identity" value="admin"><label>admin</label>
            	<input type="radio" name="identity" value="normal"><label>normal</label><br><br>
				<button type="submit" name="submit">Sign Up</button>
			</form>
			<section class="cancel">
			<button class="cancel" onclick="location.href='user_management.php'">Cancel</button>
		</section>
		</div>
	</section>
<?php
	include_once'footer.php';

?>
