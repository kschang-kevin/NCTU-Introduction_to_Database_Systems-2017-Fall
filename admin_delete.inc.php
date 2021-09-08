<?php
	include 'db.php';
	session_start();
	$delete_id = $_GET['house_id'];
	mysqli_query($conn,"DELETE FROM House WHERE id='$delete_id'");
	mysqli_query($conn,"DELETE FROM House_Information WHERE house_id='$delete_id'");
	mysqli_query($conn,"DELETE FROM House_Location WHERE house_id='$delete_id'");
	header("Location: admin.php");
?>