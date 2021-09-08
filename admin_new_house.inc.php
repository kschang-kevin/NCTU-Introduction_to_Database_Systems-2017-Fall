<?php
session_start();
if(isset($_POST['submit'])){
	include_once'db.php';

	$name=$_POST['name'];
	$price=$_POST['price'];
	$location=$_POST['location'];
	if(empty($name)||empty($price)||!isset($location)){
		?><script language="JavaScript">alert("Can Not Be Empty");history.go(-1);</script>"<?
		exit();
	}else{
		if(!(is_numeric($price))){
			?><script language="JavaScript">alert("Wrong price,please enter number!!!");history.go(-1);</script>"<?
			exit();
		}else{
			$sql=$conn->prepare('SELECT * FROM House where name=?');
			$sql->bind_param('s',$name);
			$sql->execute();
			$result=$sql->get_result();
			$resultCheck=mysqli_num_rows($result);
			if($resultCheck>0){
				?><script language="JavaScript">alert("Name has been signed");history.go(-1);</script>"<?
				exit();
			}
			else{	
				$tmp=$_SESSION['u_id'];
				$time=date("Y-m-d");		
				$sql=$conn->prepare("INSERT INTO House(name,price,time,owner_id) VALUES(?,?,'$time','$tmp')");		
				$sql->bind_param('si',$name,$price);
				$sql->execute();
				$sql2=$conn->prepare("SELECT id FROM House where name=?");
				$sql2->bind_param('s',$name);
				$sql2->execute();
				$result2=$sql2->get_result();
				$row2=mysqli_fetch_assoc($result2);
				$sql="SELECT id FROM Location where location='$location'";
				$result=mysqli_query($conn,$sql);
				$row=mysqli_fetch_assoc($result);
				$tmp=$row['id'];
				$tmp2=$row2['id'];
				$sql="INSERT INTO House_Location(location_id,house_id) VALUES('$tmp','$tmp2')";
				mysqli_query($conn,$sql);		
				if(empty($_POST["information"]))
				{
						header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/admin_house_management.php");
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
						$tmp=$row['id'];
						$sql3="INSERT INTO House_Information(information_id,house_id) VALUES ('$tmp','$tmp2')";
						mysqli_query($conn,$sql3);
					}
					header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/admin_house_management.php");
					exit();
				}
			}
		}
	}

}else{
	header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/admin_new_house.php");
	exit();
}