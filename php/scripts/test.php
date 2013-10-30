<?php 

	require '../classes/db.php';

	try 
	{
		$playerData = Db::find($_POST['value'], $_POST['column'], $_POST['table']);
		echo json_encode($playerData);
	}
	catch(Exception $e) {
		echo json_encode(array(
			'error' => true,
			'message' => $e->getMessage(),
		));
	}