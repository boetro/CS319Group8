<?php
include 'user.php';
include 'connect.php';

$socket = new Connect();
$con = $socket->getConnection();

$username = $_POST["username"];
$password = $_POST["password"];

$selectAll = $con->prepare("SELECT * FROM player WHERE gamertag = :username LIMIT 1");
if(!$selectAll->execute(array(':username' => $username))) {
	echo "Error selecting: ";
	print_r($selectAll->errorInfo());
	die();
}

$results = $selectAll->fetchAll();

if(count($results) <= 0) {
 	echo 'didnt return from databse';
 	header('Location: ../login.html');
} else{
	$row = $results[0];
	if(User::verifyPass($row['pass_hash'], $password, $username)){
		header('Location: ../main.html');
	}else{
		header('Location: ../login.html');
	}

}
