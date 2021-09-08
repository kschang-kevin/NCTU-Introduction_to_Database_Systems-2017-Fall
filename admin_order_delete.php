<?php
	include 'db.php';
	session_start();
	$delete_id = $_GET['id'];
	mysqli_query($conn,"DELETE FROM Order_list WHERE id='$delete_id'");
	header("Location: admin_order.php");
?>