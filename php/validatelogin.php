<?php
include 'user.php';


$username = $_POST["username"];
$password = $_POST["password"];



$con = mysqli_connect("mysql.cs.iastate.edu", "u31908", "CBWUTehhG", "db31908");

if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$results = mysqli_query($con, "SELECT * FROM player WHERE gamertag = '".$username."';");
if(!$results){
	echo mysqli_error($con);
}

if(mysqli_num_rows($results) == 0){
 	header('Location: ../login.html');
}else{

	$row = mysqli_fetch_assoc($results);
	if(User::verifyPass($row['pass_hash'], $password, $username)){
		header('Location: ../main.html');
	}else{
		header('Location: ../login.html');
	}

}
