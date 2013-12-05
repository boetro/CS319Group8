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
			<div class="alert alert-danger" id="overallError"></div>
			<form id="loginInfo" class="form-horizontal" role="form" action="./php/scripts/validatelogin.php" method="POST">
				<div class="form-group">
					<div class="alert alert-danger" id="userError"></div>
					<label for="username" class="col-lg-2 control-label">Username</label>
					<div class="col-lg-10">
						<input type="text" name="username" class="form-control" id="username" placeholder="Username">
					</div>
				</div>
				<div class="form-group">
					<div class="alert alert-danger" id="passError"></div>
					<label for="password" class="col-lg-2 control-label">Password</label>
					<div class="col-lg-10">
						<input type="password" name="password" class="form-control" id="password" placeholder="Password">
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<button id="submit" type="button" class="btn btn-default">Sign In</button>
					</div>
				</div>
			</form><br>
			<a href="./register.php">New user?</a>
		</div>
	</body>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".alert").hide();
		$("#submit").on("click", function(){
			$(".alert").hide();
			var error = false;
			if($("#username").val() === ""){
				$("#userError").show();
				$("#userError").text("Please enter a username");
				error = true;
			}
			if($("#password").val() === ""){
				$("#passError").show();
				$("#passError").text("Please enter a password");
				error = true;
			}
			if(error){
				return;
			}
			var data = $.ajax({
				url: './php/scripts/validatelogin.php',
				type: 'POST',
				data: $("#loginInfo").serialize(),
				success: function(response){
					var data = $.parseJSON(response);
					if(data['error']){
						$("#overallError").show();
						$("#overallError").html(data['message']);
						$("#password").val('');
					}else{
						window.location.replace("./main.php");
					}
				}
			});
		})
	});
</script>
</html>
