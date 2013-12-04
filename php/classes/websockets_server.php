<?php

require_once 'websockets.php';

class GameServer extends WebSocketServer {
        //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.
        
        protected function process ($user, $message) 
        {
                //$this->send($user,$message);
		foreach($this->users as $client)
		{
			$this->send($client, $message);
		}
        }
        
        protected function connected ($user) 
        {
		$this->send($user, json_encode(array(
			'id' => $user->id,
                        'gamertag' => $_SESSION['id']
		)));


                error_log('user connected with id : ' . $user->id);
	} 
        
        protected function closed ($user) 
        {}
}

$echo = new GameServer("0.0.0.0","9000");
