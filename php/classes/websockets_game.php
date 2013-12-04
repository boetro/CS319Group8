<?php

require_once 'game.php';
require_once 'websockets_user.php';

class WebSocketGame
{
	public $players = array();
	public $game = null;

	public function __construct(Game $game)
	{
		$this->game = $game;
	}
}

?>