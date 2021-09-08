<?php
	include 'db.php';
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<section class="top_button">
		
		<button onclick="location.href='login.php'">Home</button>
		<form action="logout.inc.php" method="POST">
			<button type="submit" name="submit">Log out</button><br><br><br><br>
		</form>
	</section>
	<section class="main-container">
		<div class="login">
			<h2>House Page</h2>
			<?php 
				if(!(isset($_SESSION['u_id']))) 
				{?>
					<script>                       
                        window.location.href='home.php';
                    </script><?
                }?>
    	</div>
	</section>
    <?php 
		if(!isset($_SESSION['account']))
		{?>
			<script>                       
             	window.location.href='home.php';
            </script><?}
	$tmp=$_SESSION['u_id'];
	$sql="SELECT * FROM Order_list LEFT JOIN House ON Order_list.house_id=House.id WHERE House.owner_id='$tmp'";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	$sql2="SELECT * FROM users";
	
	?>
	<section class="main-container">
		<div class="login"><?if($total_records_user<1)
	 {?>
	 	<h2>You  Have No House Here!!!</h2></div></section><?
	 }
	 else if($total_records_user>0){?>
	<table  class="table" border="1">
	
		<td>House</td>
		<td>Check in</td>
		<td>Check out</td>
		<td>Vistor</td>
	</tr>
	<tr>
		
	<? for ($i=0;$i<$total_records_user;$i++) {$row = mysqli_fetch_assoc($result);  ?>
	<tr>
		
			<td><? echo $row['name'];?></td>
			<td><? echo $row['start_date'];?></td>
			<td><? echo $row['last_date'];?></td>
			<td><? 
			$result2=mysqli_query($conn,$sql2);
	$total_fields_user2=mysqli_num_fields($result2); 
	$total_records_user2=mysqli_num_rows($result2);for ($j=0;$j<$total_records_user2;$j++) {$row2 = mysqli_fetch_assoc($result2); if($row['user_id']==$row2['user_id']) echo $row2['user_name'];}?></td>
			<?}?>	
	</tr>
	
</table>
<?}?>



		</div>
	</section>
<?php
	include_once'footer.php';

?>
