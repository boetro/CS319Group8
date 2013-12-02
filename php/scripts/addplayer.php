<?php  

	/**
	 * @requires connect.php 
	 * @requires util.php
	 * @requires db.php
	 */
	require '../classes/player.php';

	session_start();

	try 
	{
		$player = new Player($_POST['email'], $_POST['password'], $_POST['gamertag'], 'rgb(255, 255, 255)');
		$player->push();
		
		// set the sessions
		$_SESSION['gamertag'] = $player->__get('gamertag');
		$_SESSION['theme_color'] = $player->__get('theme_color');
		$_SESSION['id'] = $player->__get('id');

		echo json_encode(array(
			'player' => $player->serialize()
		));
		
		header('Location: ../../main.php');
	} 
	catch(Exception $e) 
	{
		/*echo '<pre>';
		print_r($e);
		echo '</pre>';
		exit();*/
		
		// TODO, make this work off ajax call
		header('Location: ../../register.php');
		// return json_encode(array(
		// 	'error' => true,
		// 	'message' => $e->getMessage(),
		// ));
	}