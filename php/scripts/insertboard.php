<?php

	require '../classes/connect.php' ;
	require '../classes/board.php';

	$testPlayers = array();
	$testing = new Board($testPlayers);
	$serialized = serialize($testing);

	echo 'serialized : ' . $serialized;

	$unserialized = unserialize($serialized);

	echo 'unserialized : ' . $unserialized;