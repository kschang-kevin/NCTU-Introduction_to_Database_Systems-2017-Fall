<?php
	include 'db.php';
	session_start();
	$promote_account = $_GET['user_account'];
	mysqli_query($conn,"UPDATE users SET user_type = '1' WHERE user_account='$promote_account'");
	header("Location: admin.php");
?>