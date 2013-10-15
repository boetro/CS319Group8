<?php

	class User
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
		 * Returns a random salt of length 23
		**/
		public static function makeSalt()
		{
			return uniqid(mt_rand(), true);
		}

		/**
		 * Makes a hashed password with a new salt if the parameter = '' otherwise it makes a new random salt
		**/
		public static function makePassHash($password, $username, $salt='')
		{
			if($salt == '') {
				$salt = User::makeSalt();
			}
			echo '<br>';
			$hash = sha1($username.$password.$salt);
			return $salt."|".$hash;
		}

		/**
		 * Returns true if the hash password matches with the hash for the username and password
		**/
		public static function verifyPass($hash, $password, $username){

			$splithash = explode("|", $hash);
			$salt = $splithash[0];
			$h = User::makePassHash($password, $username, $salt);
			return $hash == $h;

		}
	}
?>
