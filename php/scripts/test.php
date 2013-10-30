<?php 

	require '../classes/db.php';

	$id = $_GET['id'];
	$tableName = $_GET['tableName'];
	
	$playerData = Db::findById($id, $tableName);
	echo $playerData;