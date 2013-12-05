<?php

	require_once '../classes/connect.php';

	$socket = new Connect();
	$con = $socket->getConnection();

	$delete = "DELETE FROM game WHERE id = " . $_POST['id'] . ";";
	$select = $con->prepare($delete);

	if(!$select->execute()){
		echo json_encode(array( 'error' => true,
								'id' => $_POST['id']));
	}else{
		echo json_encode(array( 'error' => false,
								'id' => $_POST['id']));
	}
?>