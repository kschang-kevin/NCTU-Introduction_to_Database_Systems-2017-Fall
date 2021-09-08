<?php
	include 'db.php';
	session_start();
	$demote_account = $_GET['user_account'];
	mysqli_query($conn,"UPDATE users SET user_type = '0' WHERE user_account='$demote_account'");
	header("Location: admin.php");
?>