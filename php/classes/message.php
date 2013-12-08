<?php

class Message 
{

	private $sender;
	private $message;
	private $game;
	private $time;

	public function __construct($sender, $message, $game, $time) 
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

	}
}
