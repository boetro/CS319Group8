<?php 
	
	class Connect {

		private $connection;

		public function __construct() {
			
			try {
				// "mysql.cs.iastate.edu", "u31908", "CBWUTehhG", "db31908"
				$connection = new PDO('mysql:host=mysql.cs.iastate.edu;dbname=db31908', 'u31908', 'CBWUTehhG');

				# should only be used for development
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->connection = $connection;
			} catch(PDOException $exception) {
				echo 'PDO Exception : ' . $exception->getMessage();
			}

		}

		public function __destruct() {

			$this->connection = null;
		}

		public function getConnection() {

			return $this->connection;
		}
	}