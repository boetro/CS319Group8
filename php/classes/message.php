<?php

require_once 'player.php';
require_once 'game.php';
require_once 'connect.php';

class Message 
{
	private $id;
	private $sender;
	private $message;
	private $game;

	public function __construct(Player $sender, $message, Game $game, $time) 
	{
		$this->sender = $sender;
		$this->message = $message;
		$this->game = $game;
		$this->time = $time;
	}

	/**
	* Return a JSON representation of this chat message 
	**/
	public function toJSONChat() 
	{
		return json_encode(array('sender' => $this->sender,
			'message' => $this->message,
			'time' => $this->time));		
	}

	// public function serialize()
	// {
	// 	return json_encode(array(
	// 		'sender' => $this->sender->id,
	// 		'message' => $this->message,
	// 		'game' => $this->game->id,
	// 		'time' => $this->time
	// 	));
	// }

	public function push() 
	{
		$socket = new Connect();
		$con = $socket->getConnection();

		$addStmt = "INSERT INTO chat_log (sender_id, game_id, message, created_at) VALUES (:sender, :game, :message, :created_at)";
		$updateStmt = "UPDATE chat_log SET sender_id=:sender, game_id=:game, message=:message, created_at=:created_at WHERE id=:id";

		if(!isset($this->id)) 
		{
			// create a new message in the database
			error_log('attempting to add message to database with time format : ' . $this->time);
			$add = $con->prepare($addStmt);
			if( !$add->execute(array(':sender' => $this->sender->id, ':game' => $this->game->id, ':message' => $this->message, ':created_at' => date("Y-m-d H:i:s")))) 
				throw new Exception("Could not add new chat message to the database in push function.");

			$this->id = $con->lastInsertId(); 
		} 
		else 
		{
			// update current message
			$message = Db::find($this->id, 'id', 'chat_log');

			$update = $con->prepare($updateStmt);
			if(!$update->execute(array(':sender' => $this->sender->id, ':game' => $this->game->id, ':message' => $this->message, ':created_at' => date("Y-m-d H:i:s"), ':id' => $this->id))) 
				throw new Exception("Could not update chat message to the database in push function");
		}
	}
}
