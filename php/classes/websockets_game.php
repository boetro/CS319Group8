<?php

require_once 'game.php';
require_once 'websockets_user.php';

class WebSocketGame
{
	public $player1 = null;
	public $player2 = null;
	public $game = null;

	public function __construct(WebSocketUser $player1, WebSocketUser $player2, Game $game)
	{
		$this->player1 = $player1;
		$this->player2 = $player2;
		$this->game = $game;
	}

	public function hasPlayer1()
	{
		return $player1;
	}

	public function hasPlayer2()
	{
		return $player2;
	}
}

?>