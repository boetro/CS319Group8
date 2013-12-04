<?php

require_once 'player.php';
require_once 'websockets_game.php';

class WebSocketUser 
{

        public $socket;
        public $id;
        public $setup = false;
        public $headers = array();
        public $handshake = false;

        public $handlingPartialPacket = false;
        public $partialBuffer = "";

        public $sendingContinuous = false;
        public $partialMessage = "";
        
        public $hasSentClose = false;
        // reference to player model
        public $player = null;
        public $currentGame = null;

        public function __construct($id, $socket) {
                $this->id = $id;
                $this->socket = $socket;
        }

        public function setPlayer(Player $player)
        {
                $this->player = $player;
        }

        public function setCurrentGame(WebSocketGame $game)
        {
                $this->currentGame = $game;
        }
}
