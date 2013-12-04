<?php 

require_once '../classes/game.php';
require_once '../classes/player.php';
require_once '../classes/db.php';
require_once '../classes/connect.php';

try
{
	if(!isset($_SESSION)){
		session_start();
	}
	$socket = new Connect();
	$con = $socket->getConnection();

	$randPlayer = "SELECT id FROM player WHERE id != " . $_SESSION['id'] . " ORDER BY RAND() LIMIT 1;";
	$select = $con->prepare($randPlayer);

	if(!$select->execute()){
		throw new Exception("Could not perform select query from find by id function in php Db class.");
	}
	$results = $select->fetchAll(PDO::FETCH_CLASS);

	if(!count($results))
		return false; 

	if(sizeof($results) != 1)
		throw new Exception("Could not perform select query from find by id function in php Db class.");

	$game = new Game(array(
			Db::find($_SESSION['id'], 'id', 'player'),
			Db::find($results[0]->id, 'id', 'player')
		), 
		0,
		0
	);
	// save game state in database
	$game->push();

	echo $game->serialize();
} 
catch(Exception $e)
{
	return json_encode(array(
		'error' => true,
		'message' => $e->getMessage(),
	));
}

?>