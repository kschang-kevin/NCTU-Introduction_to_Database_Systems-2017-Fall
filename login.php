<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
	<section class="main-container">
		<div class="login">
			<?php if(!(isset($_SESSION['u_id']))) 
					{?><script>                       
                        window.location.href='home.php';
                        </script><?}?>
			<form action="logout.inc.php" method="POST">
				<h2><?php if(isset($_SESSION['u_id'])) echo "User's Page"?></h2><br>
				<p><?php if(isset($_SESSION['u_id']))echo "Name:".$_SESSION['u_name'];?></p><br>
				<p><?php if(isset($_SESSION['u_id']))echo "Account:".$_SESSION['u_account'];?></p><br>
				<p><?php if(isset($_SESSION['u_id']))echo "E-mail:".$_SESSION['u_email'];?></p><br>
				<button type="submit" name="submit">Logout</button><br>
			</form>
		</div>
	</section>
<?php
	include_once'footer.php';

?>
