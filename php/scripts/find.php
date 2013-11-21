<?php 

	require '../classes/db.php';

	try 
	{
		$data = Db::find($_POST['value'], $_POST['column'], $_POST['table']);
		echo json_encode($data);
	}
	catch(Exception $e) {
		echo json_encode(array(
			'error' => true,
			'message' => $e->getMessage(),
		));
	}