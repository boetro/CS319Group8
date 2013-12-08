<?php

require_once 'websockets.php';
require_once 'db.php';
require_once 'message.php';

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
                $message = json_decode($message);
                error_log('');
                // error_log('message receieved : ' . $message->message);
                error_log('message type : ' . $message->type);
                // error_log('sent from user : ' . $message->user);
                error_log('sent from user : ' . $user->player->id);
                error_log('sent from game : ' . $message->game);
                error_log('each player in game : ');
                if($user->currentGame->players) {
                        foreach($user->currentGame->players as $player) 
                        {
                                error_log('---- id : ' . $player->player->id);
                        }
                }

                // look to see if this game exists
                if($message->type == 'chat' || $message->type == 'move') {
                        foreach($this->games as $game) 
                        {
                                if($game->game->id === $message->game) 
                                {       
                                        error_log('found game');

                                        foreach ($game->players as $player) 
                                        {
                                               if($player->player->id != $user->player->id) 
                                               {        
                                                        error_log('found other player in game');
                                                        error_log('other player id : ' . $player->player->id);
                                                        $this->send($player, json_encode($message));
                                                        
                                                        // log the chat in the db
                                                        // if($message->type == 'chat') {}
                                                        // $dbMessage = new Message();
                                                        // $dbMessage->push();
                                                        // }
                                                        break;
                                               }
                                        }
                                }
                        }
                }
                else if($message->type == 'disconnect')
                {       
                        // user should be removed from games hes currently in
                        if($this->games) {
                                foreach($this->games as $gameKey => $game)
                                {
                                        if($game->game->id == $user->currentGame->game->id)
                                        {
                                                if($game->players) {
                                                        foreach($game->players as $playerKey => $player)
                                                        {
                                                                if($player->player->id == $user->player->id)
                                                                {
                                                                        error_log('removing player from active games');
                                                                        unset($this->games[$gameKey]->players[$playerKey]);
                                                                        $user->currentGame = null;

                                                                        print_r($this->games[$gameKey]->players);
                                                                        break;
                                                                }
                                                        }
                                                }       
                                        }
                                }
                        }
                }

                error_log('');
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
