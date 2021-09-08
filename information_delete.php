<?php
	include 'db.php';
	session_start();
	$delete_id = $_GET['id'];
	mysqli_query($conn,"DELETE FROM Information WHERE id='$delete_id'");
	mysqli_query($conn,"DELETE FROM House_Information WHERE information_id='$delete_id'");
	header("Location: information.php");
?>