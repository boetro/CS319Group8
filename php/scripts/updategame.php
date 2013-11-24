<?php 
	/**
	 * @requires connect.php
	 * @requires boardspace.php
	 * @requires player.php
	 */ 
	require '../classes/game.php';
	require '../classes/db.php';

	try
	{
		$game = Game::unserialize(Db::find($_POST['id'] ,'id', 'game'));

		// set new game data
		// FIXME
		/*$game->board = $_POST['board'];
		$game->players = array(
			$_POST['player1'],
			$_POST['player2']
		);
		$game->totalMoves = $_POST['totalMoves'];
		$game->turn = $_POST['turn'];*/

		// push changes to the database
		$game->push();
	} 
	catch(Exception $e) 
	{
		return json_encode(array(
			'error' => true,
			'message' => $e->getMessage()
		));
	}
 ?>