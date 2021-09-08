<?php
	include_once'db.php';
	session_start();
	if(isset($_POST['submit']))
	{
		$name=$_POST['name'];
		$price=$_POST['price'];
		$location=$_POST['location'];	
		if(empty($name)||empty($price)||!isset($location))
		{
			?><script language="JavaScript">alert("Can Not Be Empty");history.go(-1);</script>"<?
			exit();
		}
		else
		{
			if(!(is_numeric($price)))
			{
				?><script language="JavaScript">alert("Wrong price,please enter number!!!");history.go(-1);</script>"<?
				exit();
			}
			else
			{
				$sql=$conn->prepare('SELECT * FROM House where name=?');
				$sql->bind_param('s',$name);
				$sql->execute();
				$result=$sql->get_result();
				$resultCheck=mysqli_num_rows($result);								
				$tmp=$_GET['id'];
				$time=date("Y-m-d");
				$sql=$conn->prepare("UPDATE House SET name=?,price=?,time='$time'WHERE id='$tmp'");		
				$sql->bind_param('si',$name,$price);
				$sql->execute();
				$sql2="SELECT id FROM Location WHERE location='$location'";
				$result2=mysqli_query($conn,$sql2);
				$row2=mysqli_fetch_assoc($result2);
				$tmp2=$row2['id'];
				$sql5="UPDATE House_Location SET location_id='$tmp2' WHERE house_id='$tmp'";	
				mysqli_query($conn,$sql5);
				$sql4="DELETE FROM House_Information WHERE house_id='$tmp'";
				mysqli_query($conn,$sql4);
				if(empty($_POST["information"]))
				{
					header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/edit_house.php");
					exit();
				}
				else
				{
					$information=$_POST["information"];
					foreach($information as $value)
					{
						$sql="SELECT id FROM Information where Information='$value'";
						$result=mysqli_query($conn,$sql);
						$row=mysqli_fetch_assoc($result);
						$tmp2=$row['id'];
						$sql3="INSERT INTO House_Information(information_id,house_id) VALUES ('$tmp2','$tmp')";
						mysqli_query($conn,$sql3);
					}
					header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/house_management.php");
					exit();
				}				
			}
		}

	}
	else
	{
		header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/edit_house.php");
		exit();
	}
?>