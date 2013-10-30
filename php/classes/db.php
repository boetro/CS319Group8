<?php  

	require 'connect.php';

	class Db 
	{
		/**
		 * Array of the table names and their columns that exist in the database
		 */
		public static $tables = array(
			"player" => array(
				"id",
				"theme_color",
				"created_at",
				"gamertag",
				"pass_hash",
				"email"
			),		
		);

		/**
		 * Returns an array of all rows from the given table if found
		 *
		 * @param value
		 * @param string column  
		 * @param string table
		 * @return false if not found in table, or array of rows
		 */
		public static function find($value, $column, $table) 
		{
			// check table against a list of known tables
			if(!array_key_exists($table, Db::$tables))
				throw new Exception("That table name does not exist in the database.");
			else 
			{
				$sub = Db::$tables[$table];
				if(!in_array($column, $sub, true))
					throw new Exception("The column name does not exist in the database.");
			}

			$socket = new Connect();
			$con = $socket->getConnection();

			// hack to force prepared statement to allow variable table names, SQL injection wont occur since checking against const array
			$first = "SELECT * FROM " .  $table . " WHERE " . $column . "='" . $value . "'";
			$select = $con->prepare($first);
			if(!$select->execute())
				throw new Exception("Could not perform select query from find by id function in php Db class.");

			$results = $select->fetchAll(PDO::FETCH_CLASS);
			if(!count($results))
				return false; 

			return $results;
		}
	}