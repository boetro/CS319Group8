<?php

require_once 'websockets.php';

class GameServer extends WebSocketServer {
        //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.
        
        protected function process ($user, $message) 
        {
                //$this->send($user,$message);
		/*foreach($this->users as $client)
		{
			$this->send($client, $message);
		}*/

                // message hit on the server should only be sent to the other player connected to the game
        }
        
        protected function connected ($user) 
        {
		/*$this->send($user, json_encode(array(
                        'gamertag' => $user->player->gamertag
		)));*/


                error_log($user->player->gamertag . ' connected to game with id : ' . $user->currentGame->game->id . "\n");
	} 
        
        protected function closed ($user) 
        {}
}

$echo = new GameServer("0.0.0.0","9000");
