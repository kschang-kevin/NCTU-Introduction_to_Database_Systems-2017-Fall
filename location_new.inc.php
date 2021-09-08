<?php
	session_start();
	if(isset($_POST['submit']))
	{
		include_once'db.php';
		if(empty($_POST["location"]))
		{
			?><script language="JavaScript">alert("Can not be empty");history.go(-1);</script>"<?
			exit();
		}		
		$location=$_POST["location"];
		$sql="SELECT * FROM Location";
		$result=mysqli_query($conn,$sql);
		$total_records_user=mysqli_num_rows($result);
		$tmp=0;
		for($i=0;$i<$total_records_user;$i++)
		{
			$row=mysqli_fetch_assoc($result);
			if($row['location']==$location)
			{
				$tmp=1;
			}
		}
		if($tmp==1)
		{
			?><script language="JavaScript">alert("Location exists");history.go(-1);</script>"<?
			exit();
		}
		else				
		{
			$sql=$conn->prepare("INSERT INTO Location(location) VALUES(?)");
			$sql->bind_param('s',$location);
			$sql->execute();
			header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/location.php");
		}
		
	}

		
	

else{
	header("Location: http://people.cs.nctu.edu.tw/~ksjhang60523/location.php");
	exit();
}