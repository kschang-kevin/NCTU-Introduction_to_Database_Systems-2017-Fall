<?php
	include 'db.php';
	session_start();
	$delete_id = $_GET['id'];
	mysqli_query($conn,"DELETE FROM House WHERE id='$delete_id'");
	header("Location: admin.php");
?>