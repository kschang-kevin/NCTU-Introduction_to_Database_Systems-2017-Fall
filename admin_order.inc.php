<?php
include 'db.php';
	session_start();
?>
<?php
	$tmp1=$_GET['id'];
	$tmp2=$_GET['std']; 
	$tmp3=$_GET['ltd']; 
	$tmp= $_SESSION['u_id'];
 	$sql="SELECT * FROM Order_list WHERE house_id=$tmp1";
	$result=mysqli_query($conn,$sql);
	$total_fields_user=mysqli_num_fields($result); 
	$total_records_user=mysqli_num_rows($result);
	if($total_records_user==0)
	{
		$sql2="INSERT INTO Order_list(start_date,last_date,user_id,house_id) VALUES('$tmp2','$tmp3','$tmp','$tmp1')";
				mysqli_query($conn,$sql2);
				header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/admin_order.php");
				exit();
	}
	else
	{
		$det=1;
		for($i=0;$i<$total_records_user;$i++) 
		{
			$row=mysqli_fetch_assoc($result);
			if(strtotime($tmp2)-strtotime($row['last_date'])>=0||strtotime($tmp3)-strtotime($row['start_date'])<=0)
			{
				$det=1;
			}

			else
			{
				$det=0;
				?><script language="JavaScript">alert("The interval has been assigned");history.go(-1);</script>"<?
				exit();
			}
		}
		if($det==1){
			$sql2="INSERT INTO Order_list(start_date,last_date,user_id,house_id) VALUES('$tmp2','$tmp3','$tmp','$tmp1')";
			mysqli_query($conn,$sql2);
			header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/admin_order.php");
			exit();
		}
	}
	
?>