<?php 

	/**
	 * Consists of a variety useful static functions
	 */
	class Util 
	{

		/**
		 * Creates a random salt of length 23
		 *
		 * @return string 
		**/
		public static function makeSalt()
		{

			return uniqid(mt_rand(), true);
		}

		/**
		 * Makes a hashed password with a new salt if the parameter = '' otherwise it makes a new random salt
		 *
		 * @param string password
		 * @param string username
		 * @param salt optional salt parameter
		**/
		public static function makePassHash($password, $username, $salt='')
		{

			if($salt == '') {
				$salt = Util::makeSalt();
			}
			
			$hash = sha1($username.$password.$salt);
			return $salt."|".$hash;
		}

		/**
		 * @return true if the hash password matches with the hash for the username and password
		**/
		public static function verifyPass($hash, $password, $username) {

			$splithash = explode("|", $hash);
			$salt = $splithash[0];
			$h = Util::makePassHash($password, $username, $salt);
			return $hash == $h;
		}
	}