<?php

	require 'connect.php';

	class Player
	{
		
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
		
		public function __construct($email, $pass_hash, $gamertag, $theme_color)
		{
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
	}