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
<button  onclick="location.href='newuser.php'">New</button>
</section>
	<?if(!isset($_SESSION['account']))
		{?><script>                       
             window.location.href='home.php';
                        </script><?}
	
	$sql="SELECT * FROM users WHERE 1";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);?>
	<div class="main-wrapper">
		<div class="main-container">
			<h2>User Managment Page</h2>
		</div>
	</div>
	<table  class="table" border="1">
	<tr>
		<td>Name</td>
		<td>Account</td>
		<td>E-mail</td>
		<td>Identity</td>
		<td>Change Identity</td>
	</tr>
	<tr>
		
	<td><? echo $_SESSION['u_name']; ?></td>       
	<td><? echo $_SESSION['u_account']; ?></td>
	<td><? echo $_SESSION['u_email']; ?></td>
	<td><? echo "Admin";?></td>
	<td><? echo "       ";?>
		<? echo "      ";?>
		<? echo "      ";?>
	</td>
	<? for ($i=0;$i<$total_records_user;$i++) {$row = mysqli_fetch_assoc($result);  ?>
	<tr>
		<?if($row['user_account']!=$_SESSION['account']){?>
			<td><? echo $row['user_name']; ?></td>       
			<td><? echo $row['user_account']; ?></td>
			<td><? echo $row['user_email']; ?></td>
			<td><? if($row['user_type']==0){
						echo "Normal";
					}
					else{
						echo "Admin";
					}
				?>
			</td>
				<td>
					<a href="promote.php?user_account=<? echo $row['user_account']; ?>">Promote</a>
					<a href="demote.php?user_account=<? echo $row['user_account']; ?>">Demote</a>
					<a href="delete.php?user_id=<? echo $row['user_id']; ?>">Delete</a>
				</td>
		<?}?>
	</tr>
	<?    }   ?>
</table>

