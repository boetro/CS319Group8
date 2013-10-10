<?php

include 'user.php';

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$confirm = $_POST["confirmpass"];

$pass_hash = User::makePassHash($password, $username);

echo strlen($pass_hash);

$con = mysqli_connect("mysql.cs.iastate.edu", "u31908", "CBWUTehhG", "db31908");

if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$results = mysqli_query($con, "SELECT * FROM player WHERE gamertag = '".$username."';");

if(!$results){
	echo mysqli_error($con);
}

if(mysqli_num_rows($results) > 0){
 	header('Location: ../register.html');
 	return;
}

$add = "INSERT INTO player (email, pass_hash, gamertag)
VALUES ('".$email."', '".$pass_hash."','".$username."')";

if(!mysqli_query($con, $add)){
	echo "Error adding: " . mysqli_error($con);
	header('Location: ../register.html');
	return;
}
header('Location: ../main.html');

mysqli_close($con);

?>

