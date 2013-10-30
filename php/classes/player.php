<?php

	require 'db.php';
	require 'util.php';

	class Player implements Serializable
	{
		private $tableName = 'player';
		
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
		// TODO change caseing in database
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
		public function push() {
			if(!isset($id)) 
			{
				// create a new player in the database
				return 'no player exists';
			} 
			else 
			{
				// update current player
				return 'player exists';
			}
		}

		/**
		 * Magic getter
		 *
		 * @param property to get
		 * @return property or false if it does not exist
		 */
		public function __get($property) {
			
			if (property_exists($this, $property)) {
		      return $this->$property;
		    }

		    return false;
		}

		/**
		 * Magic setter
		 *
		 * @param property to set
		 * @param value to set the property to
		 * @return true on successfull set, false on fail
		 */
		public function __set($property, $value) {
			
			if (property_exists($this, $property)) {
		      $this->$property = $value;
		      return true;
		    }

		    return false;
		}

		public function serialize() 
		{
	    	return json_encode(array(
	    		'id' => $id,
	    		'email' => $email,
	    		'pass_hash' => $pass_hash,
	    		'gamertag' => $gamertag,
	    		'theme_color' => $theme_color,
	    		'created_at' => $created_at,
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