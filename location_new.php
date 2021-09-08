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
		<div class="main-wrapper">
			<h2>New Location</h2>
				<form class="newhouse-form" action="location_new.inc.php" method="POST">
				<input type="text" name="location" placeholder="Location"><br>
				<button type="submit" name="submit">Finish</button><br>
			</form>
			<section class="cancel">
			<button class="cancel" onclick="location.href='location.php'">Cancel</button>
		</section>
		</div>
	</section>
<?php
	include_once'footer.php';

?>
