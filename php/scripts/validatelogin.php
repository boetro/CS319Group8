<?php
	include_once '../classes/player.php';
	include_once '../classes/connect.php';
	include_once '../classes/util.php';

	$socket = new Connect();
	$con = $socket->getConnection();

	$username = $_POST["username"];
	$password = $_POST["password"];

	$selectAll = $con->prepare("SELECT * FROM player WHERE gamertag = :username LIMIT 1");
	if(!$selectAll->execute(array(':username' => $username))) 
	{
		echo "Error selecting: ";
		print_r($selectAll->errorInfo());
		die();
	}

	$results = $selectAll->fetchAll();

	if(count($results) <= 0) 
	{
	 	echo 'didnt return from databse';
	 	header('Location: ../../login.html');
	} 
	else
	{
		$row = $results[0];
		if(Util::verifyPass($row['pass_hash'], $password, $username))
		{
			session_start();
			$_SESSION['id'] = $row['id'];
			$_SESSION['gamertag'] = $username;
			$_SESSION['theme_color'] = $row['theme_color'];
			header('Location: ../../main.php');
		}
		else
		{
			header('Location: ../../login.php');
		}

	}