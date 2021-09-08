<?php
	session_start();
	if(isset($_POST['submit']))
	{
		include_once'db.php';
		if(empty($_POST["information"]))
		{
			?><script language="JavaScript">alert("Can not be empty");history.go(-1);</script>"<?
			exit();
		}		
		$information=$_POST["information"];
		$sql="SELECT * FROM Information";
		$result=mysqli_query($conn,$sql);
		$total_records_user=mysqli_num_rows($result);
		$tmp=0;
		for($i=0;$i<$total_records_user;$i++)
		{
			$row=mysqli_fetch_assoc($result);
			if($row['information']==$information)
			{
				$tmp=1;
			}
		}
		if($tmp==1)
		{
			?><script language="JavaScript">alert("Information exists");history.go(-1);</script>"<?
			exit();
		}
		else				
		{
			$sql=$conn->prepare("INSERT INTO Information(information) VALUES(?)");
			$sql->bind_param('s',$information);
			$sql->execute();
			header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/information.php");
		}
		
	}

		
	

else{
	header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/informarion.php");
	exit();
}