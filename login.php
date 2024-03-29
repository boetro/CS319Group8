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
				Sequence
			</h1><br>
			
			<form class="form-horizontal" role="form" action="./php/scripts/validatelogin.php" method="POST">
				<div class="form-group">
					<label for="username" class="col-lg-2 control-label">Username</label>
					<div class="col-lg-10">
						<input type="text" name="username" class="form-control" id="username" placeholder="Username">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-lg-2 control-label">Password</label>
					<div class="col-lg-10">
						<input type="password" name="password" class="form-control" id="password" placeholder="Password">
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<button type="submit" class="btn btn-default">Sign In</button>
					</div>
				</div>
			</form><br>
			
			<a href="./register.php">New user?</a>
		</div>
	</body>
</html>
