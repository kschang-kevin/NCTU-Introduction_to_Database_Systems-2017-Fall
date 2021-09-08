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
		<button onclick="location.href='admin_house.php'">House</button>
		<button onclick="location.href='admin_order.php'">Order</button>
		<button onclick="location.href='user_management.php'">User management</button>
		<button onclick="location.href='admin_house_management.php'">House management</button>
		<button onclick="location.href='admin_favorite.php'">Favorite</button>
		<button onclick="location.href='information.php'">Information</button>
		<button onclick="location.href='location.php'">Location</button>
		<form action="logout.inc.php" method="POST">
			<button type="submit" name="submit">Log out</button><br><br><br><br>
		</form>
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
	
	$tmp1=0;
	$tmp2=0;
	$tmp3=0;
	$tmp4=0;
	if(!isset($_SESSION['account']))
	{
		?><script>window.location.href='home.php';</script><?
 	}
	if(empty($_GET['keyword_in'])||empty($_GET['keyword_out']))
 	{
 		?><script language="JavaScript">alert("Check-in and Check-out cannot be empty");history.go(-1);</script>"<?
				
 	}
 		$where=" where "; 	
 		if(!empty($_GET['Price']))
			$where=$where."price ".(string)$_GET['Price']." ";
		if(!empty($_GET['keyword_id']))
		{
			$where=$where."AND House.id=? ";
			$tmp1=1;
		}
		if(!empty($_GET['keyword_name']))
		{
			$where=$where."AND name=? ";
			$tmp2=1;	
		}
		$tmp3000=0;
		if(!empty($_GET['keyword_location']))
		{
			$tmp=(string)$_GET['keyword_location'];
			$sql4=$conn->prepare('SELECT * FROM Location where location=?');
			$sql4->bind_param('s',$tmp);			
			$sql4->execute();
			$result4=$sql4->get_result();			
			$total_records_user=mysqli_num_rows($result4);
			for ($i=0;$i<$total_records_user;$i++) 
			{	
				$row = mysqli_fetch_assoc($result4);
				$tmp3000=$row['id'];
			}
			$where=$where."AND location_id=".$tmp3000." ";
		}
		if(!empty($_GET['keyword_time']))
		{
			$where=$where."AND time=? ";
			$tmp4=1;
		}
		if(!empty($_GET['keyword_owner']))
		{
			$tmp=(string)$_GET['keyword_owner'];
			$sql4=$conn->prepare('SELECT * FROM users where user_name=?');
			$sql4->bind_param('s',$tmp);			
			$sql4->execute();
			$result4=$sql4->get_result();			
			$total_fields_user=mysqli_num_fields($result4); 
			$total_records_user=mysqli_num_rows($result4);
			if($total_records_user==0)
			$where=$where."AND owner_id=0 ";	
			for ($i=0;$i<$total_records_user;$i++) 
			{	
				$row = mysqli_fetch_assoc($result4);
				$where=$where."AND owner_id=".(string)$row['user_id']." ";
			}
		}
		$max=0;
		$information_check[]=100;
		$sql900="SELECT * FROM Information";
		$result900=mysqli_query($conn,$sql900);
		$total_records_user900=mysqli_num_rows($result900);
		for($qqq=0;$qqq<$total_records_user900;$qqq++)
		{
			$row900 = mysqli_fetch_assoc($result900);
			$max=$row900['id'];
			
		}
		for($qqq=0;$qqq<$max;$qqq++)
		{
			if(empty($_GET[$qqq+1]))
			{
			}
			else
			{
				$sql900="SELECT * FROM Information where id=$qqq+1";
				$result900=mysqli_query($conn,$sql900);
				$total_records_user900=mysqli_num_rows($result900);
				$row900 = mysqli_fetch_assoc($result900);
				$poo=$row900['information'];
				array_push($information_check,$poo);
			}
		}
		unset($information_check[0]);
		$num=count($information_check);
		if(isset($_GET['submit_price_up']))
 		{
 		$sql=$conn->prepare("SELECT House.id AS h_id,name,price,time,owner_id,user_id,user_account,user_name,user_type,House_Location.id,location_id,house_id FROM House LEFT JOIN users ON House.owner_id=users.user_id LEFT JOIN House_Location ON House_Location.house_id=House.id ".$where." ORDER BY price DESC");
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('i',$_GET['keyword_id']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_name']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('s',$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_name']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('sss',$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('isss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		$sql->execute();
 		$result=$sql->get_result();
 	}
 	else if(isset($_GET['submit_price_down']))
 	{
 		$sql=$conn->prepare("SELECT House.id AS h_id,name,price,time,owner_id,user_id,user_account,user_name,user_type,House_Location.id,location_id,house_id FROM House LEFT JOIN users ON House.owner_id=users.user_id LEFT JOIN House_Location ON House_Location.house_id=House.id ".$where." ORDER BY price");
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('i',$_GET['keyword_id']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_name']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('s',$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_name']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('sss',$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('isss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		$sql->execute();
 		$result=$sql->get_result();
 	}
 	else if(isset($_GET['submit_time_up']))
 	{
 		$sql=$conn->prepare("SELECT House.id AS h_id,name,price,time,owner_id,user_id,user_account,user_name,user_type,House_Location.id,location_id,house_id FROM House LEFT JOIN users ON House.owner_id=users.user_id LEFT JOIN House_Location ON House_Location.house_id=House.id ".$where." ORDER BY time DESC");
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('i',$_GET['keyword_id']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_name']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('s',$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_name']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('sss',$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('isss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		$sql->execute();
 		$result=$sql->get_result();
 	}
 	else if(isset($_GET['submit_time_down']))
 	{
 		$sql=$conn->prepare("SELECT House.id AS h_id,name,price,time,owner_id,user_id,user_account,user_name,user_type,House_Location.id,location_id,house_id FROM House LEFT JOIN users ON House.owner_id=users.user_id LEFT JOIN House_Location ON House_Location.house_id=House.id ".$where." ORDER BY time");
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('i',$_GET['keyword_id']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_name']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('s',$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_name']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('sss',$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('isss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		$sql->execute();
 		$result=$sql->get_result();
 	}
 	else
 	{

 		$sql=$conn->prepare("SELECT House.id AS h_id,name,price,time,owner_id,user_id,user_account,user_name,user_type,House_Location.id,location_id,house_id FROM House LEFT JOIN users ON House.owner_id=users.user_id LEFT JOIN House_Location ON House_Location.house_id=House.id ".$where);
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('i',$_GET['keyword_id']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_name']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('s',$_GET['keyword_location']);
 			echo $where;
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('s',$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_name']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('is',$_GET['keyword_id'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('ss',$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==0)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==0&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==0&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('iss',$_GET['keyword_id'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==0&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('sss',$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		if($tmp1==1&&$tmp2==1&&$tmp3==1&&$tmp4==1)
 		{
 			$sql->bind_param('isss',$_GET['keyword_id'],$_GET['keyword_name'],$_GET['keyword_location'],$_GET['keyword_time']);
 		}
 		$sql->execute();
 		$result=$sql->get_result();
 	
 	}
	$sql2="SELECT * FROM House_Information LEFT JOIN Information on House_Information.information_id=Information.id";	
	$sql3="SELECT * FROM Favorite";
	$sql4="SELECT * FROM House_Location LEFT JOIN Location ON House_Location.location_id=Location.id";
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	?>
	<table  class="table" border="1">
	<tr>

		<form action="admin_search.php" method="GET">
			<input type="hidden" name="page" value=1>
			<td><input type="text" name="keyword_id" value="<?if(isset($_GET['keyword_id']))echo $_GET['keyword_id']; else if(!empty($_GET['keyword_id']))echo $_GET['keyword_id'];else NULL;?>"></td>
			<td><input type="text" name="keyword_name" value="<?if(isset($_GET['keyword_name']))echo $_GET['keyword_name']; else if(!empty($_GET['keyword_name']))echo $_GET['keyword_name'];else NULL;?>"></td>
			<td><select name="Price" id="Price" onChange="this.form.submit()">
				<option value=">=0">All</option>
				<option value="BETWEEN 0 AND 500">0~500</option>
				<option value="BETWEEN 500 AND 1000">500~1000</option>
				<option value="BETWEEN 1000 AND 2000">1000~2000</option>
				<option value=">=2000">2000~</option>
			</select>
			<SCRIPT>
				var selvar = '<?=$_GET['Price']?>'; 
				if (selvar=='') selvar = '>=0';   
				Price.value = selvar; 
			</SCRIPT></td>			
			<td><input type="text" name="keyword_location" value="<?if(isset($_GET['keyword_location']))echo $_GET['keyword_location']; else if(!empty($_GET['keyword_location']))echo $_GET['keyword_location'];else NULL;?>"></td>
			<td><input type="text" name="keyword_time" value="<?echo isset($_GET['keyword_time'])?$_GET['keyword_time']:NULL;?>"><br>
				<input type="text" name="keyword_in" value="<?if(isset($_GET['keyword_in']))echo $_GET['keyword_in']; else if(!empty($_GET['keyword_in']))echo $_GET['keyword_in'];else NULL;?>"><br>
				<input type="text" name="keyword_out" value="<?if(isset($_GET['keyword_out']))echo $_GET['keyword_out']; else if(!empty($_GET['keyword_out']))echo $_GET['keyword_out'];else NULL;?>">
			</td>
			<td><input type="text" name="keyword_owner" value="<?if(isset($_GET['keyword_owner']))echo $_GET['keyword_owner']; else if(!empty($_GET['keyword_owner']))echo $_GET['keyword_owner'];else NULL;?>"></td>
			<td><?$sql7="SELECT * FROM Information";
				$result7=mysqli_query($conn,$sql7);
				$total_fields_user7=mysqli_num_fields($result7); 
				$total_records_user7=mysqli_num_rows($result7);
				for($i=0;$i<$total_records_user7;$i++)
				{
					$row7=mysqli_fetch_assoc($result7);
					?><input type="checkbox" name="<?echo $row7['id'];?>" value="<?echo $row7['id']?>"<?foreach ($information_check as $value)if($value==$row7['information'])checked;else unchecked; ?>><label><?echo $row7['information'];?></label><?
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
					
						<button class="submit" type="submit" name="submit_price_down"></button>
					
				
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
	<? 
$tmp20=0;
		$cun=0;
		if(!isset($_GET['submit']))
		{
			$tmp10=$_GET['keyword_in'];
			$tmp11=$_GET['keyword_out'];

		}
		else
		{
			$tmp10=$_GET['keyword_in'];
			$tmp11=$_GET['keyword_out'];
		}
		$sql10="SELECT * FROM Order_list ";
		for ($i=0;$i<$total_records_user;$i++)
		{
			$row = mysqli_fetch_assoc($result);
			$result10=mysqli_query($conn,$sql10);
			$total_records_user10=mysqli_num_rows($result10);
			$tmp20=0;
			if($total_records_user10!=0)
			{
				for($k=0;$k<$total_records_user10;$k++)
				{
					$tmp20=0;

					$row10 = mysqli_fetch_assoc($result10);
					if(!((strtotime($tmp10)-strtotime($row10['last_date'])>=0)||(strtotime($tmp11)-strtotime($row10['start_date'])<=0))&&$row['id']==$row10['house_id'])
					{
						$tmp20=1;
						break;
					}
					else if($num!=0)
					{
						$array[]=100;
						$result2=mysqli_query($conn,$sql2);
						$total_fields_user2=mysqli_num_fields($result2); 
						$total_records_user2=mysqli_num_rows($result2);
						for($a=0;$a<$total_records_user2;$a++)
						{

							$row2 = mysqli_fetch_assoc($result2);
							if($row2['house_id']==$row['h_id'])
							{
								$poo=$row2['information'];
								array_push($array,$poo);
							}
						}
						if(count(array_intersect($array,$information_check))!=$num)
						{
							$tmp20=1;
						}		
					unset($array);
					}
					
				}
				if($tmp20==0)
				{
					$cun=$cun+1;
				}
			}
			else
			{
				if($num!=0)
				{
					$array[]=100;
					$result2=mysqli_query($conn,$sql2);
					$total_fields_user2=mysqli_num_fields($result2); 
					$total_records_user2=mysqli_num_rows($result2);
					for($a=0;$a<$total_records_user2;$a++)
					{

						$row2 = mysqli_fetch_assoc($result2);
						if($row2['house_id']==$row['h_id'])
						{
							$poo=$row2['information'];
							array_push($array,$poo);
						}
					}
					if(count(array_intersect($array,$information_check))!=$num)
					{
						$tmp20=1;
					}		
					unset($array);
				}
				if($tmp20==0)
				{
					$cun=$cun+1;
				}

			}
		}
		$per=5;
		$i=0;
		$page=intval($_GET["page"]);
		$total_page=ceil($cun/$per);
		$end=$page*$per;
		$start=($page-1)*$per+1;
		$canprint=0;
		$sql->execute();
		$result=$sql->get_result();
		while($start<=$end&&$start<=$cun)
		{
			if($i==$total_records_user)
			{
				break;
			}
		for ($i=0;$i<$total_records_user;$i++)
		{
			$row = mysqli_fetch_assoc($result);  ?>
		<tr>
			<?
			$result10=mysqli_query($conn,$sql10);
			$total_records_user10=mysqli_num_rows($result10);
			$tmp20=0;
			for($k=0;$k<$total_records_user10;$k++)
			{
				if($total_records_user10!=0)
			{
				
					$tmp20=0;

					$row10 = mysqli_fetch_assoc($result10);
					if(!((strtotime($tmp10)-strtotime($row10['last_date'])>=0)||(strtotime($tmp11)-strtotime($row10['start_date'])<=0))&&$row['id']==$row10['house_id'])
					{
						$tmp20=1;
						break;
					}
					else if($num!=0)
					{
						$array[]=100;
						$result2=mysqli_query($conn,$sql2);
						$total_fields_user2=mysqli_num_fields($result2); 
						$total_records_user2=mysqli_num_rows($result2);
						for($a=0;$a<$total_records_user2;$a++)
						{

							$row2 = mysqli_fetch_assoc($result2);
							if($row2['house_id']==$row['h_id'])
							{
								$poo=$row2['information'];
								array_push($array,$poo);
							}
						}
						if(count(array_intersect($array,$information_check))!=$num)
						{
							$tmp20=1;
						}		
					unset($array);
					}
					
				}
				}
			
			if($total_records_user10==0)
					{
						if($num!=0){
						$array[]=100;
						$result2=mysqli_query($conn,$sql2);
						$total_fields_user2=mysqli_num_fields($result2); 
						$total_records_user2=mysqli_num_rows($result2);
						for($a=0;$a<$total_records_user2;$a++)
						{

							$row2 = mysqli_fetch_assoc($result2);
							if($row2['house_id']==$row['h_id'])
							{
								$poo=$row2['information'];
								array_push($array,$poo);
							}
						}
						if(count(array_intersect($array,$information_check))!=$num)
						{
							$tmp20=1;
						}		
					unset($array);
					}
				}
				
			
			if($tmp20==0)
			{
				$canprint=$canprint+1;
			}
			
			?>
			<?
			$tmp=$_GET['keyword_location'];
			$sql200=$conn->prepare('SELECT * FROM House_Location LEFT JOIN Location ON House_Location.location_id=Location.id where location=?');
			$sql200->bind_param('s',$tmp);			
			$sql200->execute();
			$result200=$sql200->get_result();			
			$total_records_user200=mysqli_num_rows($result200);
			if($num==0&&$tmp20==0&&$canprint>=$start&&$canprint<=$end)
			{
				$start=$start+1;
				?>
				<td><? echo $row['h_id'];?></td>       
				<td><? echo $row['name'];?></td>
				<td><? echo $row['price'];?></td>
				<td>
					<? 
					$result4=mysqli_query($conn,$sql4);
					$total_fields_user4=mysqli_num_fields($result4); 
					$total_records_user4=mysqli_num_rows($result4);
					$tmp=0;
					for($k=0;$k<$total_records_user4;$k++)
					{
						$row4=mysqli_fetch_assoc($result4);
						if($row4['house_id']==$row['h_id'])
						{
							$tmp=1;
							echo $row4['location'];
							break;
						}
					}
					if($tmp==0)
						echo"unknown"?>		
				</td>
				<td><? echo $row['time'];?></td>
				<td><? echo $row['user_name'];?></td>
				<td><?
				$result2=mysqli_query($conn,$sql2);
				$total_fields_user2=mysqli_num_fields($result2); 
				$total_records_user2=mysqli_num_rows($result2);
				for($j=0;$j<$total_records_user2;$j++)
				{
					$row2 = mysqli_fetch_assoc($result2);
					if($row2['house_id']==$row['h_id'])
					{
						echo $row2['information'];?><br><?
					}
					
				}?>	
				</td>
				<td>
				<?if($row['owner_id']!=$_SESSION['u_id']){
					$tmp=0;
					$result3=mysqli_query($conn,$sql3);
					$total_fields_user3=mysqli_num_fields($result3); 
					$total_records_user3=mysqli_num_rows($result3);
					for ($j=0;$j<$total_records_user2;$j++) {$row3 = mysqli_fetch_assoc($result3);

					if($row3['favorite_id']==$row['h_id']&&$row3['user_id']==$_SESSION['u_id']){
						$tmp=1;}}?><?if($tmp==1){echo "Already in favorite";}else{?>
				<a href="admin_favorite.inc.php?house_id=<? echo $row['h_id']; ?>">Favorite</a><?}?>
				<a href="admin_order_page.php?id=<? echo $row['h_id']; ?>">Order</a>
				<a href="admin_delete.inc.php?id=<? echo $row['h_id']; ?>">Delete</a>
				</td>
				<?}
			}
			else if($tmp20==0&&$canprint>=$start&&$canprint<=$end)
			{

				$array[]=100;
				$result2=mysqli_query($conn,$sql2);
				$total_fields_user2=mysqli_num_fields($result2); 
				$total_records_user2=mysqli_num_rows($result2);
				for($a=0;$a<$total_records_user2;$a++)
				{

					$row2 = mysqli_fetch_assoc($result2);
					if($row2['house_id']==$row['h_id'])
					{
						$poo=$row2['information'];
						array_push($array,$poo);
					}
						
				}
				if(count(array_intersect($array,$information_check))==$num)
				{
					$start=$start+1;
					?>
					<td><? echo $row['h_id'];?></td>       
					<td><? echo $row['name'];?></td>
					<td><? echo $row['price'];?></td>
					<td>
					<? 
					$result4=mysqli_query($conn,$sql4);
					$total_fields_user4=mysqli_num_fields($result4); 
					$total_records_user4=mysqli_num_rows($result4);
					$tmp=0;
					for($k=0;$k<$total_records_user4;$k++)
					{
						$row4=mysqli_fetch_assoc($result4);
						if($row4['house_id']==$row['h_id'])
						{
							$tmp=1;
							echo $row4['location'];
							break;
						}
					}
					if($tmp==0)
						echo"unknown"?>		
					</td>
					<td><? echo $row['time'];?></td>
					<td><? echo $row['user_name'];?></td>
					<td><?
					$result2=mysqli_query($conn,$sql2);
					$total_fields_user2=mysqli_num_fields($result2); 
					$total_records_user2=mysqli_num_rows($result2);
					for($j=0;$j<$total_records_user2;$j++)
					{

						$row2 = mysqli_fetch_assoc($result2);
						if($row2['house_id']==$row['h_id'])
						{
							echo $row2['information'];?><br><?
						}
						
					}?>	
					</td>
					<td>
						<?if($row['owner_id']!=$_SESSION['u_id'])
						{
							$tmp=0;
							$result3=mysqli_query($conn,$sql3);
							$total_fields_user3=mysqli_num_fields($result3); 
							$total_records_user3=mysqli_num_rows($result3);
							for ($j=0;$j<$total_records_user2;$j++)
							{
								$row3 = mysqli_fetch_assoc($result3);
								if($row3['favorite_id']==$row['h_id']&&$row3['user_id']==$_SESSION['u_id'])
								{
									$tmp=1;
								}
							}
							if($tmp==1)
							{
								echo "Already in favorite";
							}
							else
							{?>
								<a href="admin_favorite.inc.php?house_id=<? echo $row['h_id']; ?>">Favorite</a>
							<?}?>
								<a href="admin_order_page.php?id=<? echo $row['h_id']; ?>">Order</a>
								<a href="admin_delete.inc.php?id=<? echo $row['h_id']; ?>">Delete</a>
					</td>
						<?}
				}?>
				<?unset($array);
			}?>
		</tr>
		<?}
		}?>
</table>

		<?
		
		for($i=1;$i<=$total_page;$i++)
		{
			?><a href="admin_search.php?page=<? echo $i; ?>&&keyword_in=<? if(!empty($_GET['keyword_in']))echo $_GET['keyword_in']; ?>&&keyword_out=<? if(!empty($_GET['keyword_out']))echo $_GET['keyword_out']; ?>&&keyword_id=<? if(!empty($_GET['keyword_id']))echo $_GET['keyword_id']; ?>&&keyword_name=<? if(!empty($_GET['keyword_name']))echo $_GET['keyword_name']; ?>&&keyword_location=<? if(!empty($_GET['keyword_location']))echo $_GET['keyword_location']; ?>&&keyword_time=<? if(!empty($_GET['keyword_time']))echo $_GET['keyword_time']; ?>&&Price=<? if(!empty($_GET['Price']))echo $_GET['Price'];?>&&<?for($jjj=1;$jjj<=$max;$jjj++){if(!empty($_GET[$jjj])){echo $_GET[$jjj];?>=<?echo $_GET[$jjj];}?>&&<?}?>"><? echo $i;?></a>
		<?;}?>

		<?echo "total ".$cun;?> 
		<?echo "on page ".$_GET["page"];?> 


		</div>
	</section>
<?php
	include_once'footer.php';
?>
