<?php

class Message 
{

	private $sender;
	private $message;
	private $game;

	public function __construct($sender, $message, $game) 
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

	public function push() 
	{
		$socket = new Connect();
		$con = $socket->getConnection();

		$addStmt = "INSERT INTO chat_log (sender_id, game_id, message) VALUES (:sender_id, :game_id, :message)";

		$add = $con->prepare($addStmt);
		if( !$add->execute(array(':sender_id' => $this->sender, ':game_id' => $this->game, ':message' => $this->message))) 
			throw new Exception("Could not add new Message to the database in push function.");
	}
}
