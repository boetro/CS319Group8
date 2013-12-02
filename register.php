<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Sequence</title>
		<meta charset="utf-8">
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
	</head>
	
	<body>
		<?php
			session_start();
			if(isset($_SESSION['gamertag']) && isset($_SESSION['theme_color'])){
				unset($_SESSION['gamertag']);
				unset($_SESSION['theme_color']);
			}
		?>
		<div class="container">
			<h1>
				Register
			</h1><br>
			
			<form role="form" action="./php/scripts/addplayer.php" method="POST">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name = "gamertag" class="form-control" id="username" placeholder="Username">
				</div>
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="email" name = "email" class="form-control" id="email" placeholder="Email">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name = "password" class="form-control" id="password" placeholder="Password">
				</div>
				<div class="form-group">
					<label for="confirmpassword">Confirm Password</label>
					<input type="password" name = "confirmpass" class="form-control" id="confirmpassword" placeholder="Re-enter password">
				</div>
				<button type="submit" class="btn btn-default">Sign up</button>
			</form><br>
			<a href="./index.php">Back</a>
		</div>
	</body>
</html>
