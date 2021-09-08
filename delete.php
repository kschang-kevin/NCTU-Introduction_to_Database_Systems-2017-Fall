<?php
	include 'db.php';
	session_start();
	$delete_id = $_GET['user_id'];
	$sql="SELECT * FROM House";
	$result=mysqli_query($conn,$sql);
	$total_records_user=mysqli_num_rows($result);
	for ($i=0;$i<$total_records_user;$i++)
	{
		$row = mysqli_fetch_assoc($result);
		if($row['owner_id']==$delete_id )
		{
			$tmp=$row['id'];
			mysqli_query($conn,"DELETE FROM House_Information WHERE house_id='$tmp'");
			mysqli_query($conn,"DELETE FROM House_Location WHERE house_id='$tmp'");
		}
	}
	mysqli_query($conn,"DELETE FROM users WHERE user_id='$delete_id'");
	mysqli_query($conn,"DELETE FROM Favorite WHERE user_id='$delete_id'");
	mysqli_query($conn,"DELETE FROM House WHERE owner_id='$delete_id'");
	header("Location: user_management.php");
?>