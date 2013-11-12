<?php

	require '../classes/connect.php';
	require '../classes/util.php';

	$socket = new Connect();
	$con = $socket->getConnection();



	$update = $con->prepare("UPDATE player SET " . $_POST["column"] . " = '".$_POST["value"]."' WHERE gamertag = '" . $_POST["gamertag"]. "';");
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