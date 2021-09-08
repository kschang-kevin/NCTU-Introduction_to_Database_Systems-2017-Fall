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
		<div class="login"><h2>My Favorite</h2>
			<?php if(!(isset($_SESSION['u_id']))) 
					{?><script>                       
                        window.location.href='home.php';
                        </script><?}?>
    	</div>
	</section>
    
	<?php 
	if(!isset($_SESSION['account']))
		{?><script>                       
             window.location.href='home.php';
                        </script><?}
	
	$tmp=$_SESSION['u_id'];
	$sql="SELECT * FROM Favorite WHERE user_id='$tmp'";
	$sql2="SELECT * FROM House_Information LEFT JOIN Information on House_Information.information_id=Information.id";
	$sql4="SELECT * FROM users";
	$sql5="SELECT * FROM House_Location LEFT JOIN Location ON House_Location.location_id=Location.id";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	$result4=mysqli_query($conn,$sql4);
	$total_fields_user4=mysqli_num_fields($result4); 
	$total_records_user4=mysqli_num_rows($result4);
	?>
	<section class="main-container">
		<div class="login">
	<? if ($total_records_user<1) {?><h2><?echo "You have no favorite here!";?></h2></div></section><?}
	else{?>
	<table  class="table" border="1">
	<tr>
		<td>id</td>
		<td>name</td>
		<td>price</td>
		<td>location</td>
		<td>time</td>
		<td>owner</td>
		<td>information</td>
		<td>option</td>
	</tr>
	<tr>
		
	<? for ($i=0;$i<$total_records_user;$i++) {$row = mysqli_fetch_assoc($result);  ?>
	<tr>
		<?if($row['user_id']==$_SESSION['u_id']){?><?
			$tmp=$row['favorite_id'];
			$sql3="SELECT * FROM House LEFT JOIN users ON House.owner_id=users.user_id ";
			$result3=mysqli_query($conn,$sql3);
			$total_fields_user3=mysqli_num_fields($result3); 
			$total_records_user3=mysqli_num_rows($result3);
			for ($j=0;$j<$total_records_user3;$j++) {$row3 = mysqli_fetch_assoc($result3);  
			if($row3['id']==$tmp){?>
			<td><? echo $row3['id'];?></td>       
			<td><? echo $row3['name'];?></td>
			<td><? echo $row3['price'];?></td>
			<td><? 
					$result5=mysqli_query($conn,$sql5);
					$total_fields_user5=mysqli_num_fields($result5); 
					$total_records_user5=mysqli_num_rows($result5);
					$tmp=0;
					for ($k=0;$k<$total_records_user5;$k++) {$row5=mysqli_fetch_assoc($result5);?>
				<?if($row5['house_id']==$row3['id']){
					$tmp=1;
					echo $row5['location'];?><?}?>
					<?;}if($tmp==0)echo"unknown"?></td>
			<td><? echo $row3['time'];?></td>
			<td><? echo $row3['user_name'];?></td>
			<?$result2=mysqli_query($conn,$sql2);
			$total_fields_user2=mysqli_num_fields($result2); 
			$total_records_user2=mysqli_num_rows($result2);?>
			<td><? for ($j=0;$j<$total_records_user2;$j++) {$row2 = mysqli_fetch_assoc($result2);  ?>
				<? if($row2['house_id']==$row['favorite_id'])
					{echo $row2['information'];?><br><?}?>
					<?}?>
					
			</td>
			<td>

				<a href="favorite_delete.inc.php?house_id=<? echo $row['id']; ?>">Delete</a><?}?>
			</td>
			<?}?>
			<?}?>
			<?}?>
		
	</tr>
	
</table>
<?}?>



		</div>
	</section>
<?php
	include_once'footer.php';

?>
