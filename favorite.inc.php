<?php
	include 'db.php';
	session_start();
	$favorite_house = $_GET['house_id'];
	$tmp=$_SESSION['u_id'];
	$sql="INSERT into Favorite(user_id,favorite_id) values('$tmp','$favorite_house')";
	mysqli_query($conn,$sql);
	header("Location: login.php");
?>