<?php
	include 'db.php';
	session_start();
	$delete_id = $_GET['house_id'];
	mysqli_query($conn,"DELETE FROM Favorite WHERE id='$delete_id'");	
	header("Location: favorite.php");
?>