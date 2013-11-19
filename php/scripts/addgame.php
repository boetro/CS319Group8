<?php 

require '../classes/game.php';
require_once '../classes/player.php';
require_once '../classes/db.php';

try
{
	$game = new Game(array(
			Db::find($_POST['player1'], 'id', 'player'),
			Db::find($_POST['player2'], 'id', 'player')
		), 
		$_POST['totalMoves'], 
		$_POST['turn']
	);
	// save game state in database
	$game->push();

	echo json_encode(array(
		'game' => $game->serialize()
	));
} 
catch(Exception $e)
{
	return json_encode(array(
		'error' => true,
		'message' => $e->getMessage(),
	));
}

?>