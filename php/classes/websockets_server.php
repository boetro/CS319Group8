<?php

require_once 'websockets.php';
require_once 'db.php';
require_once 'message.php';
require_once 'player.php';
require_once 'game.php';

class GameServer extends WebSocketServer {
        //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.
        
    protected function process ($user, $message) 
    {
        // message hit on the server should only be sent to the other player connected to the game
        $message = json_decode($message);
        error_log('');
        error_log('message receieved : ');
        print_r($message);
        error_log('each player in game : ');
        if($user->currentGame->players) {
                foreach($user->currentGame->players as $player) 
                {
                        error_log('---- id : ' . $player->player->id);
                }
        }

        if($message->type == 'chat' || $message->type == 'move') {

            // find game
            foreach($this->games as $game) 
            {
                if($game->game->id === $message->game) 
                {       
                    foreach ($game->players as $player) 
                    {
                        // send other player message if they are currently connected to the game
                        if($player->player->id != $user->player->id) 
                        {        
                            $this->send($player, json_encode($message));
                            break;
                        }
                    }
                }
            }

            if($message->type == 'chat') 
            {
                // log the chat in the db
                $dbMessage = new Message(Player::unserialize(Db::find($message->user, 'id', 'player')), $message->message, Game::unserialize(Db::find($message->game, 'id', 'game')), $message->time);
                $dbMessage->push();
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
        error_log($user->player->gamertag . ' connected to game with id : ' . $user->currentGame->game->id . "\n");
    } 
        
    protected function closed ($user) 
    {}
}

$echo = new GameServer("0.0.0.0","9000");
