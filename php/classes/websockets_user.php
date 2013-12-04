<?php

require_once 'player.php';

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

        public function __construct($id, $socket, Player $player = null) {
                $this->id = $id;
                $this->socket = $socket;
                $this->player = $player;
        }
}
