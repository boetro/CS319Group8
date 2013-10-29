<?php

require '../classes/connect.php';
require '../classes/util.php';

$socket = new Connect();
$con = $socket->getConnection();

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$confirm = $_POST["confirmpass"];

$pass_hash = Util::makePassHash($password, $username);

# prepared statements escape the data, elimating need for mysql_escape
$selectAll = $con->prepare("SELECT * FROM player WHERE gamertag = :username LIMIT 1");
if(!$selectAll->execute(array(':username' => $username))) {
	echo "Error selecting: ";
	print_r($add->errorInfo());
	die();
}

if(count($selectAll->fetchAll()) > 0){
	echo "Sorry. That username already exists.";
 	die();
}

$add = $con->prepare("INSERT INTO player (email, pass_hash, gamertag) VALUES (:email, :pass_hash, :username)");
if(!$add->execute(array(':email' => $email, ':pass_hash' => $pass_hash, ':username' => $username))) {
	echo "Error adding: ";
	print_r($add->errorInfo());
	die();
}

header('Location: ../main.html');

# connection will close on destruction of PDO object