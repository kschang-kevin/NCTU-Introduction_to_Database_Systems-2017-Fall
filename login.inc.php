<?php

session_start();


if(isset($_POST['submit'])){
	include 'db.php';

	$account=$_POST['account'];
	$password=$_POST['password'];

	if(empty($account)||empty($password)){

		?><script language="JavaScript">alert("Can Not Be Empty");history.go(-1);</script>"<?
	}else{
		$sql=$conn->prepare('SELECT * FROM users where user_account=?');
		$sql->bind_param('s',$account);
		$sql->execute();
		$result=$sql->get_result();
		$resultCheck= mysqli_num_rows($result);
		if($resultCheck<1){
			?><script language="JavaScript">alert("No This Account");history.go(-1);</script>"<?
			exit();
		}else{
			if($row=mysqli_fetch_assoc($result)){
				if($password==$row['user_password']){
					$_SESSION['account']=$_POST['account'];
					$_SESSION['password']=$_POST['password'];
					$_SESSION['u_name']=$row['user_name'];
					$_SESSION['u_account']=$row['user_account'];
					$_SESSION['u_email']=$row['user_email'];
					$_SESSION['u_id']=$row['user_id'];
					$_SESSION['u_type']=$row['user_type'];
					if($row['user_type']==0){
						header("Location:login.php");
					}else{
						header("Location:admin.php");
					}
					exit();
				}else{
						$hashedPwdCheck= password_verify($password,$row['user_password']);
						if($hashedPwdCheck==false){
							?><script language="JavaScript">alert("Wrong Password");history.go(-1);</script>"<?
							exit();
						}
						elseif($hashedPwdCheck==true){
							$_SESSION['account']=$_POST['account'];
							$_SESSION['password']=$_POST['password'];
							$_SESSION['u_name']=$row['user_name'];
							$_SESSION['u_account']=$row['user_account'];
							$_SESSION['u_email']=$row['user_email'];
							$_SESSION['u_id']=$row['user_id'];
							$_SESSION['u_type']=$row['user_type'];
							if($row['user_type']==0){
								header("Location:login.php");
							}else{
								header("Location:admin.php");
							}
							exit();
						}
				}

			}
		}
	}
}
else{
		header("http://people.cs.nctu.edu.tw/~ksjhang60523/home.php");
		exit();
}
?>