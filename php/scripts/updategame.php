<?php 
	/**
	 * @requires connect.php
	 * @requires boardspace.php
	 * @requires player.php
	 */ 
	require_once '../classes/game.php';
	require_once '../classes/db.php';
	require_once '../classes/player.php';

	try
	{
		$game = Game::unserialize(Db::find($_POST['id'] ,'id', 'game'));

		$game->board = json_decode($_POST['board']);
		print_r($game->board);
		$game->players = array(
			Player::unserialize(Db::find($_POST['player1'], 'id', 'player')),
			Player::unserialize(Db::find($_POST['player2'], 'id', 'player'))
		);
		$game->totalMoves = $_POST['totalMoves'];
		$game->turn = $_POST['turn'];

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