<?php

	require '../classes/connect.php';
	require '../classes/util.php';

	$socket = new Connect();
	$con = $socket->getConnection();

	session_start();	

	$update = $con->prepare("UPDATE player SET " . $_POST["column"] . " = '".$_POST["value"]."' WHERE gamertag = '" . $_SESSION["gamertag"]. "';");
	if(!$update->execute()) 
	{
		echo "Error updating settings.";
		print_r($update->errorInfo());
		die();
	}else{
		echo json_encode(array(
			'error' => false
		));
	}

?>