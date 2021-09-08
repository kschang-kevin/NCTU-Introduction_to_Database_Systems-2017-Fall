<?php

if(isset($_POST['submit'])){
	include_once'db.php';

	$account=mysqli_real_escape_string($conn, $_POST['account']);
	$password=mysqli_real_escape_string($conn, $_POST['password']);
	$confirm_password=mysqli_real_escape_string($conn, $_POST['confirm_password']);
	$name=mysqli_real_escape_string($conn, $_POST['name']);
	$email=mysqli_real_escape_string($conn, $_POST['email']);


	if(empty($account)||empty($password)||empty($name)||empty($email)||empty($confirm_password)){
		?><script language="JavaScript">alert("Can Not Be Empty");history.go(-1);</script>"<?
		exit();
	}else{
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			?><script language="JavaScript">alert("Wrong E-mail");history.go(-1);</script>"<?
			exit();
		}else{
			$sql="SELECT * FROM users WHERE user_account='$account'";
			$result =mysqli_query($conn,$sql);
			$resultCheck=mysqli_num_rows($result);
			if($resultCheck>0){
				?><script language="JavaScript">alert("Account has been signed");history.go(-1);</script>"<?

				
			}else{
				if($password!=$confirm_password){
					?><script language="JavaScript">alert("Confirm Password Incorrect");history.go(-1);</script>"<?
					
				}else{


					$hashedPwd=password_hash($password,PASSWORD_DEFAULT);
					$sql="INSERT INTO users(user_account,user_password,user_name,user_email,user_type) VALUES ('$account','$hashedPwd','$name','$email',0);";
					mysqli_query($conn,$sql);
					header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/home.php");
					exit();
				}
			}
		}
	}

}else{
	header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/signup.php");
	exit();
}