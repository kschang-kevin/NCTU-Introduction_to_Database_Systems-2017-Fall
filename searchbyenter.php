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
	else
	{
		$where=" WHERE ";
		/*$tmp=$_POST['keyword_owner'];
		$sql4="SELECT * FROM users where user_name='$tmp'";
		$result4=mysqli_query($conn,$sql4);
		$total_fields_user=mysqli_num_fields($result4); 
		$total_records_user=mysqli_num_rows($result4);
		$ans=owner_id;
		for ($i=0;$i<$total_records_user;$i++) 
		{	
			$ans=$row['user_id'];
		}
		if($_POST['keyword_id']==NULL){
			$kid=id;
		}
		else{
			$kid=$_POST['keyword_id'];
		}
		if($_POST['keyword_name']==NULL){
			$kname=name;
		}
		else{
			$kname=$_POST['keyword_name'];
		}
		if($_POST['keyword_location']==NULL){
			$klocation=location;
		}
		else{
			$klocation=$_POST['keyword_location'];
		}
		if($_POST['keyword_time']==NULL){
			$ktime=time;
		}
		else{
			$ktime=$_POST['keyword_time'];
		}

		$where=" WHERE id=".$kid." and 
		name=".$kname." and 
		price".(string)($_POST['Price'])." and 
		location=".$klocation." and 
		time=".$ktime." and
		owner_id=".$ans." ";*/
		$where=$where."price ".(string)$_POST['Price']." ";
		if(!empty($_POST['keyword_id']))
		{
			$where=$where."AND id=".(string)$_POST['keyword_id']." ";
		}
		if(!empty($_POST['keyword_name']))
		{
			$where=$where."AND name='".(string)$_POST['keyword_name']."' ";
		}
		if(!empty($_POST['keyword_location']))
		{
			$where=$where."AND location='".(string)$_POST['keyword_location']."' ";
		}
		if(!empty($_POST['keyword_time']))
		{
			$where=$where."AND time='".(string)$_POST['keyword_time']."' ";
		}
		if(!empty($_POST['keyword_owner']))
		{
			$tmp=$_POST['keyword_owner'];
			$sql4="SELECT * FROM users where user_name='$tmp'";
			$result4=mysqli_query($conn,$sql4);
			$total_fields_user=mysqli_num_fields($result4); 
			$total_records_user=mysqli_num_rows($result4);
			for ($i=0;$i<$total_records_user;$i++) 
			{	
				$row = mysqli_fetch_assoc($result4);
				$where=$where."AND owner_id=".(string)$row['user_id']." ";
			}
		}
		if(!empty($_POST['information'])){
			$information_check=$_POST['information'];
			$num=count($information_check);
		}
		$sql="SELECT * FROM House LEFT JOIN users ON House.owner_id=users.user_id".$where;
		//$sql="SELECT * FROM House LEFT JOIN users ON House.owner_id=users.user_id".$where;
		//echo $sql;
	}
	$account=mysqli_real_escape_string($conn, $_SESSION['account']);
	$sql2="SELECT * FROM Information";
	$sql3="SELECT * FROM Favorite";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	$result2=mysqli_query($conn,$sql2);
	$total_fields_user2=mysqli_num_fields($result2); 
	$total_records_user2=mysqli_num_rows($result2);?>
	<table  class="table" border="1">
	<tr>
		<form action="searchbyenter.php" method="POST">
			<td><input type="text" name="keyword_id" placeholder="Keyword"></td>
			<td><input type="text" name="keyword_name" placeholder="Keyword"></td>
			<td><select name="Price">
				<option value=">=0">All</option>
				<option value="BETWEEN 0 AND 3000">0~3000</option>
				<option value="BETWEEN 3000 AND 6000">3000~6000</option>
				<option value="BETWEEN 6000 AND 12000">6000~12000</option>
				<option value=">=20000">20000~</option>
			</select></td>			
			<td><input type="text" name="keyword_location" placeholder="Keyword"></td>
			<td><input type="text" name="keyword_time" placeholder="YYYY-MM-DD"></td>
			<td><input type="text" name="keyword_owner" placeholder="Keyword"></td>
			<td><input type="checkbox" name="information[]" value="wifi"><label>wifi</label>
				<input type="checkbox" name="information[]" value="lockers"><label>lockers</label><br>
				<input type="checkbox" name="information[]" value="laundry facilities"><label>laundry facilities</label><br>
				<input type="checkbox" name="information[]" value="kitchen"><label>kitchen</label><br>
				<input type="checkbox" name="information[]" value="elevator"><label>elevator</label>
				<input type="checkbox" name="information[]" value="no smoking"><label>no smoking</label><br>
				<input type="checkbox" name="information[]" value="television"><label>television</label>
				<input type="checkbox" name="information[]" value="breakfast"><label>breakfast</label><br>
				<input type="checkbox" name="information[]" value="toiletries provided"><label>toiletries provided</label><br>
				<input type="checkbox" name="information[]" value="shuttle service"><label>shuttle service</label></td>
			<td><button type="submit" name="submit">Search</button><br></td>
		</form>
	</tr>
	<tr>
		<td>id</td>
		<td>name</td>
		<td>
			<form action="search.php" method="POST">
				<button type="submit" name="submit_price_up"></button>
			</form> 
			price
			<form action="search.php" method="POST">
				<button type="submit" name="submit_price_down"></button>
			</form>
		</td>
		<td>location</td>
		<td>
			<form action="search.php" method="POST">
				<button type="submit" name="submit_time_up"></button>
			</form> 
			time
			<form action="search.php" method="POST">
				<button type="submit" name="submit_time_down"></button>
			</form>
		</td>
		<td>owner</td>
		<td>information</td>
		<td>option</td>
	</tr>
	<tr>
	<?if(empty($_POST['information'])){?>
		<?for ($i=0;$i<$total_records_user;$i++) {$row = mysqli_fetch_assoc($result);  ?>
		<tr>	
			<td><? echo $row['id'];?></td>       
			<td><? echo $row['name'];?></td>
			<td><? echo $row['price'];?></td>
			<td><? echo $row['location'];?></td>
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
				<a href="favorite.inc.php?house_id=<? echo $row['id']; ?>">Favorite</a><?}?>
				
			</td>
				<?}?>
		</tr>
		<?}?>
	<?}else{?>
		<?for ($i=0;$i<$total_records_user;$i++) {$row = mysqli_fetch_assoc($result);  ?>
		<tr>

			<?
			$array[]=10;
			$result2=mysqli_query($conn,$sql2);
			$total_fields_user2=mysqli_num_fields($result2); 
			$total_records_user2=mysqli_num_rows($result2);?>
			<?for ($a=0;$a<$total_records_user2;$a++)
			{
				$row2 = mysqli_fetch_assoc($result2);
				if($row2['house_id']==$row['id']){
					$array[]=$row2['information'];
				}
				
			}?>
			<?if(count(array_intersect($array,$information_check))==$num){?>
				<td><? echo $row['id'];?></td>       
				<td><? echo $row['name'];?></td>
				<td><? echo $row['price'];?></td>
				<td><? echo $row['location'];?></td>
				<td><? echo $row['time'];?></td>
				<td><? echo $row['user_name'];?></td>
				<?$result2=mysqli_query($conn,$sql2);
				$total_fields_user2=mysqli_num_fields($result2); 
				$total_records_user2=mysqli_num_rows($result2);?>
				<td><? for ($j=0;$j<$total_records_user2;$j++) {$row2 = mysqli_fetch_assoc($result2);  ?>
						<? if($row2['house_id']==$row['id']){
							echo $row2['information'];?>
							<br><?}?>
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
					<a href="favorite.inc.php?house_id=<? echo $row['id']; ?>">Favorite</a><?}?>
					
				</td>
					<?}?>
			<?}?>
		</tr>
		<?unset($array);}?>
	<?}?>

</table>




		</div>
	</section>
<?php
	include_once'footer.php';

?>
