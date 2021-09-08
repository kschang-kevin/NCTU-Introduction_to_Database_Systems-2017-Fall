<?php
	include 'db.php';
	session_start();
	$delete_id = $_GET['id'];
	mysqli_query($conn,"DELETE FROM Location WHERE id='$delete_id'");
	mysqli_query($conn,"DELETE FROM House_Location WHERE location_id='$delete_id'");
	header("Location: location.php");
?>