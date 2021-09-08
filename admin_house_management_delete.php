<?php
	include 'db.php';
	session_start();
	$delete_house = $_GET['id'];
	mysqli_query($conn,"DELETE FROM House WHERE id='$delete_house'");
	mysqli_query($conn,"DELETE FROM House_Information WHERE house_id='$delete_house'");
	mysqli_query($conn,"DELETE FROM House_Location WHERE house_id='$delete_house'");
	header("Location: admin_house_management.php");
?>