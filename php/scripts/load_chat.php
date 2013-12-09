<?php
	require_once '../classes/connect.php';

	$socket = new Connect();
	$con = $socket->getConnection();

	$first = "SELECT * FROM chat_log WHERE game_id = '". $_POST['id'] ."' ORDER BY created_at ASC";
	$select = $con->prepare($first);
	if(!$select->execute())
		throw new Exception("Could not perform select query from find by id function in php Db class.");

	$results = $select->fetchAll(PDO::FETCH_CLASS);

	$chatHtml = '';

	if(!isset($_SESSION)){
		session_start();
	}
	for($i = 0; $i < count($results); ++$i){
		if($results[$i]->sender_id == $_SESSION['id'])
			$chatHtml .= '<div><span style="color: rgb(92, 133, 255);">You: ' . $results[$i]->message . '</span></div>';
		else
			$chatHtml .= '<div><span style="color: rgb(245, 169, 113);">Opp: ' . $results[$i]->message . '</span></div>';
	}
	//var_dump($results)
	echo $chatHtml;

?>