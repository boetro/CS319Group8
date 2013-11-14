<?php

	/* @requires connect.php */
	require 'db.php';
	require 'util.php';
	require_once 'connect.php';

	class Player implements Serializable
	{
		private $table = 'player';
		
		/**
		 * @column idplayer
		 * @auto
		 */
		private $id;

		/**
		 * @column created_at
		 * @auto
		 **/
		private $created_at;
		
		/**
		 * @column email
		 */
		private $email;

		/**
		 * @column pass_hash
		 */
		private $pass_hash;
		
		/**
		 * @column gamertag
		 **/
		private $gamertag;

		/**
		 * @column Theme_Color
		 **/
		private $theme_color;
		
		public function __construct($email, $password, $gamertag, $theme_color)
		{
			$pass_hash = Util::makePassHash($password, $gamertag);

			$this->email = $email;
			$this->pass_hash = $pass_hash;
			$this->gamertag = $gamertag;
			$this->theme_color = $theme_color;
		}

		/** 
		 * Takes the current representation of a User, and either creates a new row in the database,
		 * or updates the current one that exists in the database
		 */
		public function push() 
		{
			$socket = new Connect();
			$con = $socket->getConnection();

			$addStmt = "INSERT INTO player (email, pass_hash, gamertag, theme_color) VALUES (:email, :pass_hash, :gamertag, :theme_color)";
			$updateStmt = "UPDATE player SET email=:email, pass_hash=:pass_hash, gamertag=:gamertag, theme_color=:theme_color WHERE id=:id";

			if(!isset($this->id)) 
			{
				// create a new player in the database
				// TODO, error checking on values that already exist in the database
				$duplicate = Db::find($this->gamertag, 'gamertag', 'player');
				if($duplicate){
					throw new Exception("Player already exists");
				}
				$add = $con->prepare($addStmt);
				if( !$add->execute(array(':email' => $this->email, ':pass_hash' => $this->pass_hash, ':gamertag' => $this->gamertag, ':theme_color' => $this->theme_color))) 
					throw new Exception("Could not add new Player to the database in push function.");

				$this->created_at = date('Y-m-d H:i:s');
				$this->id = $con->lastInsertId(); 
				session_start();
			} 
			else 
			{
				// update current player
				$current = Db::find($this->id, 'id', 'player');

				$update = $con->prepare($updateStmt);
				if(!$update->execute(array(':email' => $this->email, ':pass_hash' => $this->pass_hash, ':gamertag' => $this->gamertag, ':theme_color' => $this->theme_color, ':id' => $this->id))) 
					throw new Exception();
			}
		}

		/**
		 * Magic getter
		 *
		 * @param property to get
		 * @return property or false if it does not exist
		 */
		public function __get($property) 
		{	
			if (property_exists($this, $property)) 
		      return $this->$property;

		    return false;
		}

		/**
		 * Magic setter
		 *
		 * @param property to set
		 * @param value to set the property to
		 * @return true on successfull set, false on fail
		 */
		public function __set($property, $value) 
		{	
			if($property == 'id')
				throw new Exception("Please do not try to alter the id of the player.");

			if (property_exists($this, $property)) 
			{
		      $this->$property = $value;
		      return true;
		    }

		    return false;
		}

		public function serialize() 
		{
	    	return json_encode(array(
	    		'id' => $this->id,
	    		'email' => $this->email,
	    		'pass_hash' => $this->pass_hash,
	    		'gamertag' => $this->gamertag,
	    		'theme_color' => $this->theme_color,
	    		'created_at' => $this->created_at,
	    	));
	    }
	    
	    public function unserialize($data) 
	    {
	    	$data = json_decode($data);

	    	$this->id = $data['id'];
	    	$this->email = $data['email'];
	    	$this->pass_hash = $data['pass_hash'];
	    	$this->gamertag = $data['gamertag'];
	    	$this->theme_color = $data['theme_color'];
	    	$this->created_at = $data['created_at'];
	    }
	}