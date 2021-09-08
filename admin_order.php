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
	<button onclick="location.href='admin.php'">Home</button>

<form action="logout.inc.php" method="POST">
	<button type="submit" name="submit">Log out</button><br><br><br><br>
</form>
</section>
	<section class="main-container">
		<div class="login">
			<?php if(!(isset($_SESSION['u_id']))) 
					{?><script>                       
                        window.location.href='home.php';
                        </script><?}?>
                        <?php 
	if(!isset($_SESSION['account']))
	{
		?><script>window.location.href='home.php';</script><?
	}
	$tmp=$_SESSION['u_id'];
	$sql="SELECT * FROM Order_list WHERE user_id='$tmp'";
	$sql2='SELECT * FROM House LEFT JOIN users on House.owner_id=users.user_id';
	$sql3='SELECT * FROM users';
	$result3=mysqli_query($conn,$sql3);
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	$resultCheck= mysqli_num_rows($result);
	echo $resultCheck;
	if($resultCheck<1)
	{
	 	?><h2>You haven't order any house</h2><?;
	 }
	 if($resultCheck>=1){?>
    </div>
	</section>
    
	
	<table  class="table" border="1">
	<tr>
		<td>name</td>
		<td>Check-in</td>
		<td>Check-out</td>
		<td>owner</td>
		<td>option</td>
	</tr>
</form>
	<? for ($i=0;$i<$total_records_user;$i++) {$row = mysqli_fetch_assoc($result);  ?>
	<tr>
		

			<td><? 
				$result2=mysqli_query($conn,$sql2);
				$total_fields_user2=mysqli_num_fields($result2); 
				$total_records_user2=mysqli_num_rows($result2);
				for ($j=0;$j<$total_records_user2;$j++) 
				{
					$row2=mysqli_fetch_assoc($result2);
					if($row['house_id']==$row2['id'])
						echo $row2['name'];
				}?>
			</td>
			<td><? echo $row['start_date'];?></td>
			<td><? echo $row['last_date'];?></td>
			<td><? 
				$result2=mysqli_query($conn,$sql2);
				$total_fields_user2=mysqli_num_fields($result2); 
				$total_records_user2=mysqli_num_rows($result2);
				for ($j=0;$j<$total_records_user2;$j++) 
				{
					$row2=mysqli_fetch_assoc($result2);
					if($row['house_id']==$row2['id'])
						echo $row2['user_name'];
				}?></td>
			<td>
				<a href="admin_order_delete.php?id=<? echo $row['id']; ?>">Delete</a>
				<a href="admin_order_edit.php?id=<? echo $row['id']; ?>&house_id=<? echo $row['house_id']; ?>">Edit</a>					
			</td>
			<?}?>	
	</tr>
	<?}?>
</table>




		</div>
	</section>
<?php
	include_once'footer.php';

?>
