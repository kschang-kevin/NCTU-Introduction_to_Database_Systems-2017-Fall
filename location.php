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
		<button  onclick="location.href='location_new.php'">New</button>
	</section>
	<section class="main-container">
		<div class="login">
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
	$sql="SELECT * from Location";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	?>
	<table  class="table" border="1">
	<tr>
		<td>Location</td>
		<td>option</td>
	</tr>
	<tr>		
	<? 
		for($i=0;$i<$total_records_user;$i++) 
		{
			$row = mysqli_fetch_assoc($result);  ?>
		<tr>
		<td>
			<?
				echo $row['location'];
		    ?>
		</td>
		<td>
		<a href="location_delete.php?id=<? echo $row['id']; ?>">Delete</a>	
	</td>
		<?}?>					
			
			
			

		
	</tr>
	
</table>




		</div>
	</section>
<?php
	include_once'footer.php';

?>
