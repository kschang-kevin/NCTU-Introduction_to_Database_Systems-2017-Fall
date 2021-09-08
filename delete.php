<?php
	include 'db.php';
	session_start();
	$delete_account = $_GET['user_account'];
	mysqli_query($conn,"DELETE FROM users WHERE user_account='$delete_account'");
	header("Location: admin.php");
?>