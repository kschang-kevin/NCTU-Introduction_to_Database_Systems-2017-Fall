<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
	<section class="main-container">
		<div class="main-wrapper">
			<h2>New House</h2>
			<form class="newhouse-form" action="admin_new_house.inc.php" method="POST">
				<input type="text" name="name" placeholder="Name"><br>
				<input type="text" name="price" placeholder="Price"><br>
				<?
					$sql="SELECT * FROM Location";
					$result=mysqli_query($conn,$sql);
					$total_fields_user=mysqli_num_fields($result); 
					$total_records_user=mysqli_num_rows($result);
					for($i=0;$i<$total_records_user;$i++)
					{
						$row=mysqli_fetch_assoc($result);
						$tmp=$row['location'];
						?><input type="radio" name="location" value="<?echo $tmp;?>"><label><?echo $tmp;?></label><?
					}
				?>
				<?
					$sql="SELECT * FROM Information";
					$result=mysqli_query($conn,$sql);
					$total_fields_user=mysqli_num_fields($result); 
					$total_records_user=mysqli_num_rows($result);
					for($i=0;$i<$total_records_user;$i++)
					{
						$row=mysqli_fetch_assoc($result);
						?><input type="checkbox" name="information[]" value="<?echo $row['information']?>"><label><?echo $row['information'];?></label><?
					}
				?>
				<button type="submit" name="submit">Finish</button><br>
			</form>
			<section class="cancel">
			<button class="cancel" onclick="location.href='admin_house_management.php'">Cancel</button>
		</section>
		</div>
	</section>
<?php
	include_once'footer.php';

?>
