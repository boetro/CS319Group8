<?php  

	/**
	 * @requires connect.php 
	 * @requires util.php
	 * @requires db.php
	 */
	require '../classes/player.php';

	$example = array();

	try 
	{
		$player = new Player($_POST['email'], $_POST['password'], $_POST['gamertag'], $_POST['theme_color']);
		$player->push();

		$example['before'] = $player->serialize();

		$player->email = 'hrrehg@iastate.edu';
		$player->push();

		$example['after'] = $player->serialize();
		echo json_encode($example);
	} 
	catch(Exception $e) 
	{
		return json_encode(array(
			'error' => true,
			'message' => $e->getMessage(),
		));
	}