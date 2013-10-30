<?php 

	require '../classes/db.php';

	$value = $_GET['value'];
	$column = $_GET['column'];
	$table= $_GET['table'];

	try 
	{
		$playerData = Db::find($value, $column, $table);
		echo json_encode($playerData);
	}
	catch(Exception $e) {
		echo json_encode(array(
			'error' => true,
			'message' => $e->getMessage(),
		));
	}