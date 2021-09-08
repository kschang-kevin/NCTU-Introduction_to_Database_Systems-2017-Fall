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
	<button onclick="location.href='house.php'">House</button>
	<button onclick="location.href='order.php'">Order</button>
<button onclick="location.href='house_management.php'">House management</button>
<button onclick="location.href='favorite.php'">Favorite</button>
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
    	</div>
	</section>
    
	<?php 
	if(!isset($_SESSION['account']))
	{
		?><script>window.location.href='home.php';</script><?
	}
	
	$sql="SELECT * FROM House LEFT JOIN users ON House.owner_id=users.user_id";
	$sql2="SELECT * FROM House_Information LEFT JOIN Information on House_Information.information_id=Information.id";
	$sql3="SELECT * FROM Favorite";
	$sql4="SELECT * FROM House_Location LEFT JOIN Location ON House_Location.location_id=Location.id";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	$result2=mysqli_query($conn,$sql2);
	$total_fields_user2=mysqli_num_fields($result2); 
	$total_records_user2=mysqli_num_rows($result2);?>
	<table  class="table" border="1">
	<tr>
		<form action="search.php" method="GET">
			<input type="hidden" name="page" value=1>
			<td><input type="text" name="keyword_id" placeholder="Keyword"></td>
			<td><input type="text" name="keyword_name" placeholder="Keyword"></td>
			<td><select name="Price" onChange="this.form.submit()">
				<option value=">=0">All</option>
				<option value="BETWEEN 0 AND 500">0~500</option>
				<option value="BETWEEN 500 AND 1000">500~1000</option>
				<option value="BETWEEN 1000 AND 2000">1000~2000</option>
				<option value=">=2000">2000~</option>
			</select></td>			
			<td><input type="text" name="keyword_location" placeholder="Keyword"></td>
			<td><input type="text" name="keyword_time" placeholder="YYYY-MM-DD"><br>
				<input type="text" name="keyword_in" placeholder="Check-in"><br>
				<input type="text" name="keyword_out" placeholder="Check-out">
			</td>
			<td><input type="text" name="keyword_owner" placeholder="Keyword"></td>
			<td><?$sql7="SELECT * FROM Information";
					$result7=mysqli_query($conn,$sql7);
					$total_fields_user7=mysqli_num_fields($result7); 
					$total_records_user7=mysqli_num_rows($result7);
					for($i=0;$i<$total_records_user7;$i++)
					{
						$row7=mysqli_fetch_assoc($result7);
						?><input type="checkbox" name="<?echo $row7['id']?>" value="<?echo $row7['id']?>"><label><?echo $row7['information'];?></label><?
						?><br><?
					}?>
				</td>
			<td><button type="submit" name="submit">Search</button><br></td>
		
	</tr>
	<tr>
		<td>id</td>
		<td>name</td>
		<td>
			
				<button type="submit" name="submit_price_up"></button>
			
			price
			
				<button type="submit" name="submit_price_down"></button>
			
		</td>
		<td>location</td>
		<td>
			
				<button type="submit" name="submit_time_up"></button>
			 
			time
			
				<button type="submit" name="submit_time_down"></button>
			
		</td>
		<td>owner</td>
		<td>information</td>
		<td>option</td>
	</tr>
</form>
	<tr>
		
	<? for ($i=0;$i<$total_records_user;$i++) {$row = mysqli_fetch_assoc($result);  ?>
	<tr>
		
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
			<td>

				<?if($row['owner_id']!=$_SESSION['u_id']){
					$tmp=0;
					$result3=mysqli_query($conn,$sql3);
					$total_fields_user3=mysqli_num_fields($result3); 
					$total_records_user3=mysqli_num_rows($result3);
					for ($j=0;$j<$total_records_user2;$j++) {$row3 = mysqli_fetch_assoc($result3);

					if($row3['favorite_id']==$row['id']&&$row3['user_id']==$_SESSION['u_id']){
						$tmp=1;}}?><?if($tmp==1){echo "Already in favorite";}else{?>

				<a href="favorite.inc.php?house_id=<? echo $row['id']; ?>">Favorite</a>
				
				<?}?>
				<a href="order_page.php?id=<? echo $row['id']; ?>">Order</a>
			<?}?>

			</td>
			

		
	</tr>
	<?    }   ?>
</table>




		</div>
	</section>
<?php
	include_once'footer.php';

?>
