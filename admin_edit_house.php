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
		<div class="login"><h2>Edit</h2>
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
	$sql="SELECT * FROM House WHERE owner_id='$tmp'"; 	
	$sql2="SELECT * FROM House_Information LEFT JOIN Information on House_Information.information_id=Information.id";			
	$sql4="SELECT * FROM House_Location LEFT JOIN Location ON House_Location.location_id=Location.id";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	$result2=mysqli_query($conn,$sql2);
	$total_fiedsl_user2=mysqli_num_fields($result2); 
	$total_records_user2=mysqli_num_rows($result2);?>
	<section class="main-container">
		<div class="login">
	<? if ($total_records_user<1) {?><h2><?echo "You have no house here!";?></h2></div></section><?}
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
	<? $sql="SELECT * FROM House LEFT JOIN users ON House.owner_id=users.user_id";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);?>	
	<? for ($i=0;$i<$total_records_user;$i++) {$row = mysqli_fetch_assoc($result);  ?>
	<tr>
		<?if($row['owner_id']==$_SESSION['u_id']){?>
			<td><? echo $row['id'];?></td>       
			<td><? echo $row['name'];?></td>
			<td><? echo $row['price'];?></td>
			<td><? 
					$result4=mysqli_query($conn,$sql4);
					$total_fields_user4=mysqli_num_fields($result4); 
					$total_records_user4=mysqli_num_rows($result4);
					$tmp=0;
					for ($k=0;$k<$total_records_user4;$k++) {$row4=mysqli_fetch_assoc($result4);?>
				<?if($row4['house_id']==$row['id']){
					$tmp=1;
					echo $row4['location'];?><?}?>
					<?;}if($tmp==0)echo"unknown"?></td>
			<td><? echo $row['time'];?></td>
			<td><? echo $row['user_name'];?></td>
			<?$result2=mysqli_query($conn,$sql2);
			$total_fields_user2=mysqli_num_fields($result2); 
			$total_records_user2=mysqli_num_rows($result2);?>
			<td><? for ($j=0;$j<$total_records_user2;$j++) {$row2 = mysqli_fetch_assoc($result2);  ?>
				<? if($row2['house_id']==$row['id']){
					echo $row2['information'];?><br><?}?>
				<?}?>
			</td>

			<td><a href="admin_edit_house.inc.php?id=<? echo $row['id']; ?>">Edit</a></td>
		<?}?>
	</tr>
	<?}?>
</table><?}?>




		</div>
	</section>
<?php
	include_once'footer.php';

?>
