<?php  

	require 'connect.php';

	class Db 
	{
		/**
		 * Array of the table names that exist in the database
		 */
		public static $tableNames = array(
			"player",		
		);

		/**
		 * Returns a json encoded string of a single row from the given table if found
		 *
		 * @param integer id 
		 * @param string tableName
		 * @return false if not found in table, or json string of row 
		 */
		public static function findById($id, $tableName) 
		{
			// check tableName against a list of known tables
			if(!in_array($tableName, Db::$tableNames, true))
				throw new Exception("That table name does not exist in the database");
	
			$socket = new Connect();
			$con = $socket->getConnection();

			// hack to force prepared statement to allow variable table names
			$select = $con->prepare("SELECT * FROM " .  $tableName . " WHERE id = :id LIMIT 1");
			if(!$select->execute(array(':id' => $id)))
				throw new Exception("Could not perform select query from find by id function in php Db class.");

			$results = $select->fetchAll(PDO::FETCH_CLASS);
			if(!count($results))
				return false; 

			return json_encode($results[0]);
		}
	}