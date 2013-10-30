<?php  

	require '../classes/player.php';

	$player = new Player('blah', 'blah', 'gamers', null);
	echo $player->push();