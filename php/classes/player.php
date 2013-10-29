<?php

	class Player
	{
		private $gamerid;
		private $passhash;
		private $email;
		
		public function __construct($gamerid, $passhash, $email)
		{
			$this->gamerid = $gamerid;
			$this->passhash = $passhash;
			$this->email = $email;
		}

		/** 
		 * Takes the current representation of a User, and either creates a new row in the database,
		 * or updates the current one that exists in the database
		 */
		public function push() {

		}
	}