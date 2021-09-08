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
			<h2>Sign Up</h2>
			<form class="signup-form" action="signup.inc.php" method="POST">
				<input type="text" name="account" placeholder="Account"><br>
				<input type="password" name="password" placeholder="Password"><br>
				<input type="password" name="confirm_password" placeholder="Type your password again"><br>
				<input type="text" name="name" placeholder="Your Name"><br>
				<input type="text" name="email" placeholder="Your E-mail"><br>
				<button type="submit" name="submit">Sign Up</button>
			</form>
		</div>
	</section>
<?php
	include_once'footer.php';

?>
