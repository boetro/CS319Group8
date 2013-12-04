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
			<div class="alert alert-danger" id="overallError"></div>
			<form id="registerForm" role="form" action="" method="POST">
				<div class="form-group">
					<div class="alert alert-danger" id="userError"></div>
					<label for="username">Username</label>
					<input type="text" name = "gamertag" class="form-control" id="username" placeholder="Username">
				</div>
				<div class="form-group">
					<div class="alert alert-danger" id="emailError"></div>
					<label for="email">Email Address</label>
					<input type="email" name = "email" class="form-control" id="email" placeholder="Email">
				</div>
				<div class="form-group">
					<div class="alert alert-danger" id="passError"></div>
					<label for="password">Password</label>
					<input type="password" name = "password" class="form-control" id="password" placeholder="Password">
				</div>
				<div class="form-group">
					<div class="alert alert-danger" id="confirmError"></div>
					<label for="confirmpassword">Confirm Password</label>
					<input type="password" name = "confirmpass" class="form-control" id="confirmpassword" placeholder="Re-enter password">
				</div>
				<button id="submit" type="button" class="btn btn-default">Sign up</button>
			</form><br>
			<a href="./index.php">Back</a>
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
			if($("#confirmpassword").val() === ""){
				$("#confirmError").show();
				$("#confirmError").text("Please confirm your password here");
				error = true;
			}
			if($("#confirmpassword").val() !== $("#password").val()){
				$("#passError").show();
				$("#passError").text("Passwords do not match");
				$("#password").val("");
				$("#confirmpassword").val("");
				error = true;
			}
			if($("#email").val() === ""){
				$("#emailError").show();
				$("#emailError").text("Please enter an email");
				error = true;
			}
			if(error){
				return;
			}
			var data = $.ajax({
				url: './php/scripts/addplayer.php',
				type: 'POST',
				data: $("#registerForm").serialize(),
				success: function(response){
					console.log(response);
					var data = $.parseJSON(response);
					if(data['error']){
						$("#overallError").show();
						$("#overallError").html(data['message']);
						$("#password").val('');
						$("#confirmpassword").val('');
					}else{
						window.location.replace("./main.php");
					}
				}
			});
		})
	});
</script>
</html>
