<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
		<nav>
			<div class="main-wrapper">
				<div class="nav-login">
					<?php
						if(isset($_SESSION['u_id'])){
							echo'<form action="logout.inc.php" method="POST">
						<button type="submit" name="submit">Logout</button>
						<form>';
						}else{
							echo '<form action="login.inc.php" method="POST">
							<h2>Log in</h2>
						<input type="text" name="account" placeholder="Account"><br><br><br><br>
						<input type="password" name="password" placeholder="Password"><br><br><br><br>
						<button type="submit" name="submit">Login</button><br>
						<a href="signup.php">No account?Sign up</a>
					</form>';
						}
					?>
					
				</div>
			</div>
		</nav>
	</body>
	
